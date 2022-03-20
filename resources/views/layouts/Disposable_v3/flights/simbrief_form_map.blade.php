  {{-- Leaflet Map Modal Button --}}
  <div class="row mb-2">
    <div class="col d-grid">
      <button type="button" class="btn btn-sm btn-warning p-0 px-1" data-toggle="modal" data-target="#FlightMapModal" onclick="ExpandFlightMap()">Map</button>
    </div>
  </div>

  {{-- Map Modal --}}
  <div class="modal" id="FlightMapModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="FlightMapModalTitle" aria-hidden="true">
    <div class="modal-dialog mx-auto" style="max-width: 80%;">
      <div class="modal-content shadow-none p-0">
        <div class="modal-header border-0 p-1">
          <h5 class="card-title m-0" id="FlightMapModalTitle">
            Map
          </h5>
          <span class="close">
            <i class="fas fa-times-circle" data-dismiss="modal" aria-label="Close" aria-hidden="true"></i>
          </span>
        </div>
        <div class="modal-body border-0 p-0">
          <div id="FlightMap" style="width: 100%; height: 80vh;"></div>
        </div>
        <div class="modal-footer border-0 p-1 small text-end">
          {{ $flight->dpt_airport->name.' > '.$flight->arr_airport->name }} | GC Distance: {{ $flight->distance->local(0).' '.$units['distance'] }} | Block Time: {{ DB_ConvertMinutes($flight->flight_time, '%2dh %2dm') }}
        </div>
      </div>
    </div>
  </div>

  @section('scripts')
    @parent
    {{-- Map Leaflet Script --}}
    <script type="text/javascript">
      function ExpandFlightMap() {
        // Build Coordinates
        var Alternate = @if(filled($flight->alt_airport)) Boolean(true) @else Boolean(false) @endif;
        var DepLoc = [{{ $flight->dpt_airport->lat.', '.$flight->dpt_airport->lon }}];
        var ArrLoc = [{{ $flight->arr_airport->lat.', '.$flight->arr_airport->lon }}];
        if (Alternate === true) {
          var AltLoc = [{{ optional($flight->alt_airport)->lat.', '.optional($flight->alt_airport)->lon }}];
        }
        // Build Icons
        var RedIcon = new L.Icon({"iconUrl":"https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png","shadowUrl":"https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png","iconSize":[12,20],"shadowSize":[20,20]});
        var GreenIcon = new L.Icon({"iconUrl":"https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png","shadowUrl":"https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png","iconSize":[12,20],"shadowSize":[20,20]});
        var BlueIcon = new L.Icon({"iconUrl":"https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png","shadowUrl":"https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png","iconSize":[12,20],"shadowSize":[20,20]});
        var YellowIcon = new L.Icon({"iconUrl":"https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png","shadowUrl":"https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png","iconSize":[12,20],"shadowSize":[20,20]});
        // Build Airports Layer Group
        var BoundaryGroup = new L.featureGroup();
        var mAirports = L.layerGroup();
        var APT_{{ $flight->dpt_airport_id }} = L.marker(DepLoc, {icon: BlueIcon , opacity: 0.8}).bindPopup('Origin: {{ $flight->dpt_airport->name ?? $flight->dpt_airport_id }}').addTo(mAirports).addTo(BoundaryGroup);
        var APT_{{ $flight->arr_airport_id }} = L.marker(ArrLoc, {icon: GreenIcon , opacity: 0.8}).bindPopup('Destination: {{ $flight->arr_airport->name ?? $flight->arr_airport_id }}').addTo(mAirports).addTo(BoundaryGroup);
        if (Alternate === true) {
          var APT_{{ $flight->alt_airport_id }} = L.marker(AltLoc, {icon: YellowIcon , opacity: 0.8}).bindPopup('Alternate: {{ $flight->alt_airport->name ?? $flight->alt_airport_id }}').addTo(mAirports);
        }
        // Build City Pairs / Flights Layer Group
        var mFlights = L.layerGroup();
        var FLT_{{ $flight->dpt_airport_id.$flight->arr_airport_id }} = L.geodesic([DepLoc, ArrLoc], {weight: 2, opacity: 0.8, steps: 5, color: 'darkgreen'}).addTo(mFlights);
        if (Alternate === true) {
          var FLT_{{ $flight->arr_airport_id.$flight->alt_airport_id }} = L.geodesic([ArrLoc, AltLoc], {weight: 2, opacity: 0.7, steps: 5, color: 'darkred'}).addTo(mFlights);
        }
        // Define Base Layers For Control Box
        var DarkMatter = L.tileLayer.provider('CartoDB.DarkMatter');
        var NatGeo = L.tileLayer.provider('Esri.NatGeoWorldMap');
        var OpenSM = L.tileLayer.provider('OpenStreetMap.Mapnik');
        var WorldTopo = L.tileLayer.provider('Esri.WorldTopoMap');
        // Define Additional Overlay Layers
        var OpenAIP = L.
          tileLayer('http://{s}.tile.maps.openaip.net/geowebcache/service/tms/1.0.0/openaip_basemap@EPSG%3A900913@png/{z}/{x}/{y}.{ext}', {
          attribution: '<a href="https://www.openaip.net/">openAIP Data</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-NC-SA</a>)',
          ext: 'png',
          minZoom: 4,
          maxZoom: 14,
          tms: true,
          detectRetina: true,
          subdomains: '12'
        });
        // Define Control Groups
        var BaseLayers = {'Dark Matter': DarkMatter, 'OpenSM Mapnik': OpenSM, 'NatGEO World': NatGeo, 'World Topo': WorldTopo};
        var Overlays = {'OpenAIP Data': OpenAIP};
        // Define Map and Add Control Box
        var FlightMap = L.map('FlightMap', {center: DepLoc, layers: [DarkMatter, mAirports, mFlights], scrollWheelZoom: false}).fitBounds(BoundaryGroup.getBounds().pad(0.2));
        L.control.layers(BaseLayers, Overlays).addTo(FlightMap);
        // TimeOut to ReDraw The Map in Modal
        setTimeout(function(){ FlightMap.invalidateSize().fitBounds(BoundaryGroup.getBounds().pad(0.2))}, 300);
      }
    </script>
  @endsection
