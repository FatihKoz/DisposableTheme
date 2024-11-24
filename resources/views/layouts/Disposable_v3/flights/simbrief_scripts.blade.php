@section('scripts')
  @parent
  <script src="{{public_asset('/assets/global/js/simbrief.apiv1.js')}}"></script>
  @if($DBasic)
    @include('DBasic::flights.simbrief_special_scripts')
  @endif
  <script>
    // Open RouteFinder iframe on click, not before
    function OpenRouteFinder () {
      var rfinder_frame = $("#rfinder");
      rfinder_frame.attr("src", rfinder_frame.data("src")); 
    }
  </script>
  <script type="text/javascript">
    // ******
    // Change Aircraft Type According to Airframe selection
    // And remove pax and baggage weights from acdata
    const acDataOrig = String(document.getElementById("acdata").value);

    function CheckAirframe() {
      let weight = Boolean({{ setting('simbrief.use_standard_weights', false) }})
      let actype = String("{{ $actype }}");
      let acData = String(document.getElementById("acdata").value);
      acOrig = JSON.parse(acDataOrig.replace(/&quot;/g,'"'));
      acJson = JSON.parse(acData.replace(/&quot;/g,'"'));
      let airframe = document.getElementById("sbairframe").value;
      if (airframe != "") {
        document.getElementById("actype").value = airframe
        if (!weight) {
          delete acJson.paxwgt
          delete acJson.bagwgt
          document.getElementById("acdata").value = JSON.stringify(acJson)
        }
      } else {
        document.getElementById("actype").value = actype
        if (!weight) {
          document.getElementById("acdata").value = JSON.stringify(acOrig)
        }
      }
    }
  </script>
  <script type="text/javascript">
    // Disable Cost Index value entry if CI not possible or selected
    function CheckCruiseProfile() {
      let profile = document.getElementById("cruise_profile").value;
      if (profile === "CI") {
        document.getElementById("civalue").disabled = false
      } else {
        document.getElementById("civalue").disabled = true
      }
    }
  </script>
  <script type="text/javascript">
    // Disable ETOPS Threshold and Rule Time Fields if ETOPS is not used
    function CheckEtops() {
      let etops = document.getElementById("etops").value;
      if (etops == 0) {
        document.getElementById("etopstime").disabled = true
        document.getElementById("etopsrule").disabled = true
      } else {
        document.getElementById("etopstime").disabled = false
        document.getElementById("etopsrule").disabled = false
      }
    }
  </script>
  <script type="text/javascript">
    // Calculate the Scheduled Enroute Time for Simbrief API
    // Your PHPVMS flight_time value must be from BLOCK to BLOCK
    // Including departure and arrival taxi times
    // If this value is not correctly calculated and configured
    // Simbrief CI (Cost Index) calculation will not provide realistic results
    let num = {{ $flight->flight_time ?? '0'}};
    let hours = (num / 60);
    let rhours = Math.floor(hours);
    let minutes = (hours - rhours) * 60;
    let rminutes = Math.round(minutes);
    document.getElementById("steh").setAttribute('value', rhours.toString()); // Sent to Simbrief
    document.getElementById("stem").setAttribute('value', rminutes.toString()); // Sent to Simbrief
    // If No Block Time Provided Revert Back To Long Range Cruise
    // And Do Not Send Block Time Values
    if (rhours == 0 && rminutes == 0) {
      document.getElementById("cruise").value = "LRC";
      document.getElementById("civalue").disabled = true;
      document.getElementById("steh").disable = true;
      document.getElementById("stem").disable = true;
    }
  </script>
  <script type="text/javascript">
    // Disable Submitting CI Value when LRC is selected
    function DisableCI() {
      let cruise = document.getElementById("cruise").value;
      if (cruise === "LRC") {
        document.getElementById("civalue").disabled = true
      } else {
        document.getElementById("civalue").disabled = false
      }
    }
  </script>
  <script type="text/javascript">
    // Enable/Disable SID/STAR finding option of SimBrief
    function SidStarSelection() {
      sidstar = String(document.getElementById("sidstar").value);
      if (sidstar === "NIL") {
        document.getElementById("omit_sids").value = "1";
        document.getElementById("omit_stars").value = "1";
        document.getElementById("find_sidstar").disabled = true;
      } else {
        document.getElementById("omit_sids").value = "0";
        document.getElementById("omit_stars").value = "0";
        document.getElementById("find_sidstar").disabled = false;
        document.getElementById("find_sidstar").value = sidstar;
      }
    }
  </script>
  <script type="text/javascript">
    // Change StepClimbs Option According to Flight Level
    // If No FL is defined, set StepClimbs to Enabled
    // If or When FL is defined, set it to Disabled
    // Check SimBrief API details for requirements of StepClimb Option
    let level = Number(document.getElementById("fl").value);
    if (level === 0) {
      document.getElementById("stepclimbs").value = "1";
      }
    function CheckFL() {
      level = Number(document.getElementById("fl").value);
      if (level === 0) {
        document.getElementById("stepclimbs").value = "1";
      } else {
        document.getElementById("stepclimbs").value = "0";
      }
    }
  </script>
  <script type="text/javascript">
    // Disable Submitting a fixed flight level for Stepclimb option to work
    // Script is related to Plan Step Climbs selection
    function DisableFL() {
      let climb = document.getElementById("stepclimbs").value;
      if (climb === "0") {
        document.getElementById("fl").disabled = false
      } else {
        document.getElementById("fl").disabled = true
      }
    }
  </script>
  <script type="text/javascript">
    // Convert Weights according To User selection
    // If it differs from airline weight units
    const airline_weight = String("{{ setting('units.weight') }}");
    const cargo_load = Number({{ $tcargoload }});
    const pax_load = Number({{ $tpaxload }});
    const bag_load = Number({{ $tbagload }});
    const tot_load = Number({{ $tpayload }});
    const conv_factor = Number(2.20462262185);
    function ConvertWeights() {
      let ofp_weight = document.getElementById("ofp_weights").value;
      // Format unit type text to match phpvms style
      if (ofp_weight === 'KGS') { unit = 'kg'; }
      else if (ofp_weight === 'LBS') { unit = 'lbs'; }
      // Check current selection and compare with airline defaults
      if (airline_weight === "kg" && ofp_weight === 'LBS') {
        // Convert Kg to Lbs
        var cargo_weight = cargo_load * conv_factor;
        var pax_weight = pax_load * conv_factor;
        var bag_weight = bag_load * conv_factor;
        var tot_weight = tot_load * conv_factor;
      } else if (airline_weight === "lbs" && ofp_weight === 'KGS') {
        // Convert Lbs to Kgs
        var cargo_weight = cargo_load / conv_factor;
        var pax_weight = pax_load / conv_factor;
        var bag_weight = bag_load / conv_factor;
        var tot_weight = tot_load / conv_factor;
      } else {
        // No Converstion Use Vms Calculated Weight
        var cargo_weight = cargo_load;
        var pax_weight = pax_load;
        var bag_weight = bag_load;
        var tot_weight = tot_load;
      }
      // Sent To SimBrief
      if (cargo_load) {
        document.getElementById("cargo").value = (cargo_weight / 1000).toFixed(1); // Sent To SimBrief
      }
      // Just for Display
      if (pax_load && bag_load) {
        document.getElementById("tdPaxLoad").value = pax_weight.toFixed(0).concat(" ",unit);
        document.getElementById("tdBagLoad").value = bag_weight.toFixed(0).concat(" ",unit);
      }
      if (pax_load && bag_load && cargo_load) {
        document.getElementById("tdCargoLoad").value = cargo_weight.toFixed(0).concat(" ",unit);
      }
      if (tot_load) {
        document.getElementById("tdPayload").value = tot_weight.toFixed(0).concat(" ",unit);
      }
    }
  </script>
  <script type="text/javascript">
    // Get current UTC time, add some margin to it and format according to Simbrief API
    // Script also rounds the minutes to nearest 5 to avoid a Departure time like 1538 ;)
    // If you need to reduce the margin change value below. 45 (Mins) is the default
    let prepMargin = 45;
    let ofpDate = new Date();
    let realDate = new Date();
    const months = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];

    ofpDate.setMinutes(ofpDate.getMinutes() + prepMargin);
    let deph = ("0" + ofpDate.getUTCHours(ofpDate)).slice(-2);
    let depm = ofpDate.getUTCMinutes(ofpDate);

    if (depm < 55) {
      depm = Math.ceil(depm / 5) * 5;
    } else if (depm > 55) {
      depm = Math.floor(depm / 5) * 5;
    }

    depm = ("0" + depm).slice(-2);
    let planDOF = ("0" + ofpDate.getUTCDate()).slice(-2) + months[ofpDate.getUTCMonth()] + ofpDate.getUTCFullYear();

    document.getElementById("dof").setAttribute('value', planDOF);
    document.getElementById("date").setAttribute('value', planDOF); // Sent to Simbrief
    document.getElementById("deph").setAttribute('value', deph); // Sent to SimBrief
    document.getElementById("depm").setAttribute('value', depm); // Sent to SimBrief
  </script>
  <script type="text/javascript">
    // Check manually changed ETD hours and adjust DOF if needed
    function CheckDOF() {
      let CalendarMonths = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
      let CurrentDate = new Date();
      let Tomorrow = new Date(CurrentDate.getTime() + 86400000);
      let HoursUTC = CurrentDate.getUTCHours(CurrentDate);
      let HoursFRM = document.getElementById("deph").value;
      let RealDOF = ("0" + CurrentDate.getUTCDate()).slice(-2) + months[CurrentDate.getUTCMonth()] + CurrentDate.getUTCFullYear();
      let PlanDOF = ("0" + Tomorrow.getUTCDate()).slice(-2) + months[Tomorrow.getUTCMonth()] + Tomorrow.getUTCFullYear();

      if (HoursFRM < HoursUTC) {
        document.getElementById("dof").setAttribute('value', PlanDOF);
        document.getElementById("date").setAttribute('value', PlanDOF); // Sent to Simbrief
      } else {
        document.getElementById("dof").setAttribute('value', RealDOF);
        document.getElementById("date").setAttribute('value', RealDOF); // Sent to Simbrief
      }
    }
  </script>
@endsection
