@php
  use \Nwidart\Modules\Facades\Module;
  use App\Models\Enums\FlightType;
  use App\Models\Enums\PirepStatus;
  use App\Models\Enums\PirepState;
  use App\Models\Enums\UserState;
  use Carbon\Carbon;

  // Check phpVMS Module
  // Return boolean
  if (!function_exists('DT_CheckModule')) {
    function DT_CheckModule($module_name)
    {
      $phpvms_module = Module::find($module_name);

      return filled($phpvms_module) ? $phpvms_module->isEnabled() : false;
    }
  }

  // Check Tankering Possiblity
  // Return html formatted string
  if (!function_exists('DT_CheckTankering')) {
    function DT_CheckTankering($flight = null, $aircraft = null, $factor = 0.85)
    {
      $result_ok = '<span class="text-success fw-bold">Tankering Recommended</span>';
      $result_no = '<span class="text-danger fw-bold">Tankering NOT Recommended</span>';
      $result_skip = '<span class="text-secondary fw-bold">Tankering NOT Calculated</span>';

      if (!$flight || !$aircraft) {
        return $result_skip;
      }

      $fuel_type = optional($aircraft->subfleet)->fuel_type;

      if ($fuel_type !== 1) {
        return $result_skip;
      }

      $def_jeta1_cost = setting('airports.default_jet_a_fuel_cost');
      $dep_cost = $def_jeta1_cost;
      $arr_cost = $def_jeta1_cost;

      if ($flight->dpt_airport && $flight->dpt_airport->fuel_jeta_cost > 0) {
        $dep_cost = $flight->dpt_airport->fuel_jeta_cost;
      }

      if ($flight->arr_airport && $flight->arr_airport->fuel_jeta_cost > 0) {
        $arr_cost = $flight->arr_airport->fuel_jeta_cost;
      }

      if ($dep_cost < ($arr_cost * $factor)) {
        return $result_ok;
      }

      return $result_no;
    }
  }

  // Check URL
  // Return boolean
  if (!function_exists('DT_CheckUrl')) {
    function DT_CheckUrl($url = null)
    {
      if (!$url) { return false; }
      $headers = get_headers($url);

      if ($headers && strpos($headers[0], '200')) {
        return true;
      } else {
        return false;
      }
    }
  }

  // Get image files from a directory
  // Return array or null
  if (!function_exists('DT_GetImages')) {
    function DT_GetImages($dir = null)
    {
      $dir = isset($dir) ? $dir : 'image/carousel/';
      $type = isset($type) ? $type : 'bs5';

      if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
          while (($file = readdir($dh)) !== false) {
            if (stripos($file, '.jpg') !== false || stripos($file, '.jpeg') !== false || stripos($file, '.png') !== false) {
              $image_files[] = $dir.$file;
            }
          }
          closedir($dh);
        }
      }

      if (isset($image_files)) {
        shuffle($image_files);
      }

      return isset($image_files) ? $image_files : null;
    }
  }

  // Get Required Units
  // Return array
  if (!function_exists('DT_GetUnits')) {
    function DT_GetUnits($type = null)
    {
      $units = [];
      $units['currency'] = setting('units.currency');
      $units['distance'] = setting('units.distance');
      $units['fuel'] = setting('units.fuel');
      $units['weight'] = setting('units.weight');

      if ($type === 'full') {
        $units['volume'] = settings('units.volume');
        $units['altitude'] = settings('units.altitude');
      }

      return $units;
    }
  }

  // Convert Distance / Nautical Miles
  // Return string
  if (!function_exists('DT_ConvertDistance')) {
    function DT_ConvertDistance($distance, $unit = null)
    {
      $unit = isset($unit) ? $unit : setting('units.distance');

      if (!$distance[$unit] > 1) {
        return null;
      }

      $distance = number_format($distance[$unit]).' '.$unit;

      return $distance;
    }
  }

  // Convert Minutes
  // Return string
  if (!function_exists('DT_ConvertMinutes')) {
    function DT_ConvertMinutes($minutes = 0, $format = '%02d:%02d')
    {
      $minutes = intval($minutes);

      if ($minutes < 1) {
          return null;
      }
      $hours = floor($minutes / 60);
      $minutes = ($minutes % 60);

      return sprintf($format, $hours, $minutes);
    }
  }

  // Convert Weight / Pounds
  // Return string
  if (!function_exists('DT_ConvertWeight')) {
    function DT_ConvertWeight($value, $target_unit = null)
    {
      $target_unit = isset($target_unit) ? $target_unit : setting('units.weight');

      if (!$value[$target_unit] > 0) {
        return null;
      }

      $value = number_format($value[$target_unit]) . ' ' . $target_unit;

      return $value;
    }
  }

  // Decode Days Of Flights
  // Return string
  if (!function_exists('DT_FlightDays')) {
    function DT_FlightDays($flight_days)
    {
      $days = array();

      for ($i=0; $i<7; $i++) {
        if ($flight_days & pow(2, $i)) {
          $days[]=jddayofweek($i, 1);
        }
      }

      return implode(', ', $days);;
    }
  }

  // Decode Flight Type
  // Return mixed (plain text or bootstrap badge/button)
  if (!function_exists('DT_FlightType')) {
    function DT_FlightType($flight_type, $type = null)
    {
      $flight_type = FlightType::label($flight_type);

      if ($type === 'badge') {
        $flight_type = '<span class="badge bg-white mx-1 text-black">'.$flight_type.'</span>';
      } elseif ($type === 'button') {
        $flight_type = '<span class="btn btn-sm bg-white m-0 mx-1 p-0 px-1 disabled text-black">'.$flight_type.'</span>';
      }

      return $flight_type;
    }
  }

  // Format Flight STA and STD Times (from 1200 to 12:30)
  // Return string
  if (!function_exists('DT_FormatScheduleTime')) {
    function DT_FormatScheduleTime($time = null)
    {
      if (is_null($time) || !is_numeric($time) || strlen($time) === 5) {
        return $time;
      }

      if (!str_contains($time, ':') && strlen($time) === 4) {
        $time = substr($time, 0, 2).':'.substr($time, 2, 2);
      }

      return $time;
    }
  }

  // Fuel Cost Converter / lbs-currency to kg-currency
  // Return string
  if (!function_exists('DT_FuelCost')) {
    function DT_FuelCost($cost = 0, $unit = null, $currency = null)
    {
      if ($cost == 0) {
        return null;
      }
      $unit = isset($unit) ? $unit : setting('units.fuel');
      $currency = isset($currency) ? $currency : setting('units.currency');

      if ($unit === 'kg') {
        $cost = $cost / 0.45359237;
      }
      $cost = number_format($cost, 3) . ' ' . ucfirst($currency) . '/' . ucfirst($unit);

      return $cost;
    }
  }

  // Read Json File
  // Return object
  if (!function_exists('DT_ReadJson')) {
    function DT_ReadJson($file = null)
    {
      $file = isset($file) ? $file : 'disposable/simbrief_ofp_layouts.json';

      if (!is_file($file)) {
        return null;
      }

      $string = file_get_contents($file);
      $json_collection = collect(json_decode($string));

      return $json_collection;
    }
  }

  // Decode RouteCode
  // Return mixed (plain text or bootstrap badge/button)
  if (!function_exists('DT_RouteCode')) {
    function DT_RouteCode($route_code, $type = null)
    {
      if (empty($route_code)) {
        return null;
      }

      if (DT_CheckModule('DisposableSpecial')) {
        $route_code = DS_GetTourName($route_code);
      }

      if ($route_code === 'H') { $route_code = 'Historic' ;}
      elseif ($route_code === 'AJ') { $route_code = 'AnadoluJet' ;}
      elseif (str_contains($route_code, 'PF')) { $route_code = 'Personal Flight' ;}
      // You can add more text for your own codes like below
      // elseif ($route_code === 'XX') { $route_code = 'My Route Code' ;}

      if ($type === 'badge') {
        $route_code = '<span class="badge bg-warning mx-1 text-black">'.$route_code.'</span>';
      } elseif ($type === 'button') {
        $route_code = '<span class="btn btn-sm bg-warning m-0 mx-1 p-0 px-1 disabled text-black">'.$route_code.'</span>';
      }

      return $route_code;
    }
  }

  // Decode Route Leg
  // Return mixed (plain text or bootstrap badge/button)
  if (!function_exists('DT_RouteLeg')) {
    function DT_RouteLeg($route_leg, $type = null)
    {
      if (empty($route_leg)) {
        return null;
      }
      if ($type === 'badge') {
        $route_leg = '<span class="badge bg-warning mx-1 text-black"> Leg# '.$route_leg.'</span>';
      } elseif ($type === 'button') {
        $route_leg = '<span class="btn btn-sm bg-warning m-0 mx-1 p-0 px-1 disabled text-black"> Leg# '.$route_leg.'</span>';
      }

      return $route_leg;
    }
  }

  // Format Pirep Field value
  // Return formatted string (with html tags)
  if (!function_exists('DT_PirepField')) {
    function DT_PirepField($field, $units = null, $aircraft = null)
    {
      $slug = $field->slug;
      $value = (string) $field->value;
      $units = isset($units) ? $units : DT_GetUnits();
      $error = null;

      if (is_numeric($value)) {
        // Landing Rate
        if ($slug === 'landing-rate') {
          if ($value > 0) {
            $error = ' <i class="fas fa-exclamation-triangle mx-2" style="color:firebrick;" title="Positive Landing Rate !"></i>';
          }
          $value = number_format($value).' ft/min'.$error;
        }
        // Threshold Distance
        elseif (str_contains($slug, 'threshold-distance')) {
          if ($units['distance'] === 'km') {
            $value = number_format($value / 3.2808).' m'.$error;
          } else {
            $value = number_format($value).' ft'.$error;
          }
        }
        // Landing G-Force
        elseif ($slug === 'landing-g-force') {
          $value = number_format($value, 2).' g'.$error;
        }
        // Fuel Values
        elseif (str_contains($slug, '-fuel')) {
          if ($units['fuel'] === 'kg') {
            $value = $value / 2.20462262185;
          }
          if ($value < 0) {
            $error = ' <i class="fas fa-exclamation-triangle mx-2" style="color: firebrick;" title="Negative Fuel !"></i>';
          }
          if ($value <= 10) {
            $value = number_format($value, 2).' '.$units['fuel'].$error;
          } else {
            $value = number_format($value).' '.$units['fuel'].$error;
          }
        }
        // Weight Values
        elseif (str_contains($slug, '-weight')) {
          if ($units['weight'] === 'kg') {
            $value = $value / 2.20462262185;
          }
          $value = number_format($value).' '.$units['weight'].$error;
        }
        // Pitch, Roll, Heading : Angle
        elseif (str_contains($slug, 'roll') || str_contains($slug, 'pitch') || str_contains($slug, 'heading')) {
          // $value = number_format($value,2)."&deg;".$error;
          $value = $value.'&deg;'.$error;
        }
        // Centerline Deviation : Distance
        elseif (str_contains($slug, 'centerline-dev')) {
          if ($units['distance'] === 'km') {
            $value = number_format(($value / 3.2808), 2).' m'.$error;
          } else {
            $value = number_format($value, 2).' ft'.$error;
          }
        }
        // TakeOff and Landing Speeds
        elseif (str_contains($slug, '-speed')) {
          $value = number_format($value).' kts';
        }
      }
      // Date/Time Values (not displaying full date on purpose)
      elseif (str_contains($slug, 'time-real') || str_contains($slug, 'time-sim')) {
        $value = Carbon::parse($value)->format('H:i').' UTC';
      }

      return $value;
    }
  }

  // Pirep State
  // Return formatted string (with html tags)
  if (!function_exists('DT_PirepState')) {
    function DT_PirepState($pirep, $type = 'badge')
    {
      $color = 'primary';
      $state = $pirep->state;

      if ($state === PirepState::IN_PROGRESS || $state === PirepState::DRAFT) {
        $color = 'info';
      } elseif ($state === PirepState::PENDING) {
        $color = 'secondary';
      } elseif ($state === PirepState::ACCEPTED) {
        $color = 'success';
      } elseif ($state === PirepState::CANCELLED || $state === PirepState::DELETED || $state === PirepState::REJECTED) {
        $color = 'danger';
      } elseif ($state === PirepState::PAUSED) {
        $color = 'warning';
      }

      if ($type === 'bg') {
        $result = 'class="bg-'.$color.'"';
      } elseif ($type === 'row') {
        $result = 'class="table-'.$color.'"';
      } elseif ($type === 'badge') {
        $result = '<span class="badge bg-'.$color.' text-black">'.PirepState::label($state).'</span>';
      } else {
        $result = PirepState::label($state);
      }

      return $result;
    }
  }

  // Pirep Status
  // Return formatted string (with html tags)
  if (!function_exists('DT_PirepStatus')) {
    function DT_PirepStatus($pirep, $type = 'badge')
    {
      if ($pirep->state === PirepState::DRAFT) {
        return null;
      }

      $color = 'info';
      $status = $pirep->status;

      if ($status === PirepStatus::ARRIVED) {
        $color = 'success';
      } elseif ($status === PirepState::CANCELLED) {
        $color = 'danger';
      } elseif ($status === PirepState::PAUSED) {
        $color = 'warning';
      }

      if ($type === 'bg') {
        $result = 'class="bg-'.$color.'"';
      } elseif ($type === 'row') {
        $result = 'class="table-'.$color.'"';
      } elseif ($type === 'badge') {
        $result = '<span class="badge bg-'.$color.' text-black">'.PirepStatus::label($status).'</span>';
      } else {
        $result = PirepStatus::label($status);
      }

      return $result;
    }
  }

  // Prepare IVAO VA System Report
  // Return array
  if (!function_exists('DT_PrepareIVAO_Report')) {
    function DT_PrepareIVAO_Report($pirep = null)
    {
      // VA Details
      $vasys['Id'] = Theme::getSetting('gen_ivao_vaid');
      $vasys['VA_ICAO'] = Theme::getSetting('gen_ivao_icao');

      // User Details
      $vasys['PersonId'] = optional($pirep->user->fields->firstWhere('name', Theme::getSetting('gen_ivao_field')))->value;

      if (!filled($vasys['PersonId'])) {
        return [];
      }

      // Get Units
      $units = DT_GetUnits();

      // Pirep Details
      $vasys['Type'] = 'I'; // I = IFR, V = VFR, S = SVFR
      $vasys['TasCruise'] = '410'; // Not possible to calculate it without indicated/calibrated airspeed and ISA Deviation!
      $vasys['Flight_Number'] = $pirep->airline->code.$pirep->flight_number;
      $vasys['Aircraft'] = $pirep->aircraft->icao;
      $vasys['DepAirport'] = $pirep->dpt_airport_id;
      $vasys['LandAirport'] = $pirep->arr_airport_id;
      $vasys['Distance'] = $pirep->distance->internal(0);
      $vasys['Altitude'] = $pirep->level;
      $vasys['DateDay'] = $pirep->created_at->format('d');
      $vasys['DateMonth'] = $pirep->created_at->format('m');
      $vasys['DateYear'] = $pirep->created_at->format('Y');

      // Actual Times (From Acars Fields)
      $time_takeoff = optional($pirep->fields->where('slug', 'takeoff-time-real')->first())->value;
      $time_landing = optional($pirep->fields->where('slug', 'landing-time-real')->first())->value;

      $vasys['TakeOff'] = filled($time_takeoff) ? true : false;
      $vasys['Landing'] = filled($time_landing) ? true : false;

      $vasys['DepTime'] = filled($time_takeoff) ? Carbon::parse($time_takeoff)->format('H') : null;
      $vasys['ActDepTime'] = filled($time_takeoff) ? Carbon::parse($time_takeoff)->format('i') : null;
      $vasys['Land_Hour'] = filled($time_landing) ? Carbon::parse($time_landing)->format('H') : null;
      $vasys['Land_Minute'] = filled($time_landing) ? Carbon::parse($time_landing)->format('i') : null;

      // SimBrief Based Details (Fallback to Pirep)
      if (filled($pirep->simbrief)) {
        $vasys['SimBrief'] = true;
        $vasys['Callsign'] = substr($pirep->simbrief->xml->atc->callsign, 3, 4);
        $vasys['DestAirport'] = $pirep->simbrief->xml->destination->icao_code;
        $vasys['AltAirport'] = $pirep->simbrief->xml->alternate->icao_code;
        $vasys['Route'] = $pirep->simbrief->xml->general->route_ifps;
      } else {
        $vasys['SimBrief'] = false;
        $vasys['Callsign'] = substr($pirep->user->ident, 3, 4);
        $vasys['DestAirport'] = optional($pirep->flight)->arr_airport_id ?? $pirep->alt_airport_id;
        $vasys['AltAirport'] = filled(optional($pirep->flight)->alt_airport_id) ? $pirep->flight->alt_airport_id : 'NONE';
        $vasys['Route'] = $pirep->route;
      }
      // Fuel Used and Unit Type
      $vasys['Fuel_Qty'] = $pirep->fuel_used->local(0);
      if ($units['fuel'] === 'kg') {
        $vasys['Fuel_Type'] = 'K';
      } else {
        $vasys['Fuel_Type'] = 'L';
      }

      return $vasys;
    }
  }

  // Round Numeric Values (conversion part for SimBrief usage mostly)
  // Return numeric
  if (!function_exists('DT_Round')) {
    function DT_Round($value, $round = 100, $conv = null)
    {
      if ($conv === 'lbs') {
        $value = $value * 2.20462262185;
      } elseif ($conv === 'kg') {
        $value = $value / 2.20462262185;
      } elseif ($conv === 'kgs') {
        $value = $value / 2.20462262185;
      }

      $value = floatval($value);
      $rmv = fmod($value, $round);
      $rmv = $round - $rmv;
      $rounded = $value + $rmv;

      return $rounded;
    }
  }

  // User State
  // Return formatted string (with html tags)
  if (!function_exists('DT_UserState')) {
    function DT_UserState($user, $type = 'badge')
    {
      $color = 'primary';
      $state = $user->state;
      $base_date = filled($user->last_pirep) ? $user->last_pirep->submitted_at : $user->created_at;
      $inactivity_date = $base_date->addDays(setting('pilots.auto_leave_days'));
      $title = null;

      if ($state === UserState::PENDING) {
        $color = 'warning';
      } elseif ($state === UserState::ACTIVE) {
        $color = 'success';
        $title = Carbon::now()->diffInDays($inactivity_date).' days remaining as active';
      } elseif ($state === UserState::REJECTED || $state === UserState::SUSPENDED || $state === UserState::DELETED) {
        $color = 'danger';
      } elseif ($state === UserState::ON_LEAVE) {
        $color = 'secondary';
        $title = 'Considered inactive for '.$inactivity_date->diffInDays(Carbon::now()).' days';
      }

      if ($type === 'bg') {
        $result = 'class="bg-'.$color.'"';
      } elseif ($type === 'bg_add') {
        $result = 'bg-'.$color;
      } elseif ($type === 'row') {
        $result = 'class="table-'.$color.'" title="'.UserState::label($state).'"';
      } elseif ($type === 'badge') {
        $result = '<span class="badge bg-'.$color.' text-black" title="'.$title.'">'.UserState::label($state).'</span>';
      } else {
        $result = UserState::label($state);
      }

      return $result;
    }
  }
@endphp