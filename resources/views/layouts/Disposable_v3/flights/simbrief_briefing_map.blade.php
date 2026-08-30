  {{-- Leaflet Map Modal Button --}}
  <a class="btn btn-sm btn-primary my-1" data-bs-toggle="modal" data-bs-target="#FlightMapModal" href="#" onclick="ExpandFlightMap()">Route Map</a>

  {{-- Map Modal --}}
  <div class="modal" id="FlightMapModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="FlightMapModalTitle" aria-hidden="true">
    <div class="modal-dialog mx-auto" style="max-width: 80%;">
      <div class="modal-content shadow-none p-0">
        <div class="modal-header border-0 p-1">
          <h5 class="card-title m-0" id="FlightMapModalTitle">
            Map
          </h5>
          <span class="close">
            <i class="fas fa-times-circle" data-bs-dismiss="modal" data-bs-target="#FlightMapModal" aria-label="Close" aria-hidden="true"></i>
          </span>
        </div>
        <div class="modal-body border-0 p-0">
          <div id="FlightMap" style="width: 100%; height: 80vh;"></div>
        </div>
        <div class="modal-footer border-0 p-1 small text-end">
          @if(filled($flight->origin) && filled($flight->destination) && filled($flight->general))
            {{ $flight->origin->name.' > '.$flight->destination->name }} | GC Distance: {{ $flight->general->gc_distance }} nm | Route Distance: {{ $flight->general->route_distance }} nm | Air Distance:{{ $flight->general->air_distance }} nm
          @else
            No Flight Data Found !
          @endif
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
        var DepLoc = [{{ $flight->origin->pos_lat.', '.$flight->origin->pos_long }}];
        var ArrLoc = [{{ $flight->destination->pos_lat.', '.$flight->destination->pos_long }}];
        var Route = [{{ $flightPathJson }}] ;
        // Build Icons
        var RedIcon = new L.Icon({"iconUrl":"https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png","shadowUrl":"https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png","iconSize":[12,20],"shadowSize":[20,20]});
        var GreenIcon = new L.Icon({"iconUrl":"https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png","shadowUrl":"https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png","iconSize":[12,20],"shadowSize":[20,20]});
        var BlueIcon = new L.Icon({"iconUrl":"https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png","shadowUrl":"https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png","iconSize":[12,20],"shadowSize":[20,20]});
        var YellowIcon = new L.Icon({"iconUrl":"https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png","shadowUrl":"https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png","iconSize":[12,20],"shadowSize":[20,20]});
        // Build Airports Layer Group
        var BoundaryGroup = new L.featureGroup();
        var mAirports = L.layerGroup();
        var APT_{{ $flight->origin->icao_code }} = L.marker(DepLoc, {icon: BlueIcon , opacity: 0.8}).bindPopup('Origin: {{ $flight->origin->name ?? $flight->origin->icao_code }}').addTo(mAirports).addTo(BoundaryGroup);
        var APT_{{ $flight->destination->icao_code }} = L.marker(ArrLoc, {icon: GreenIcon , opacity: 0.8}).bindPopup('Destination: {{ $flight->destination->name ?? $flight->destination->icao_code }}').addTo(mAirports).addTo(BoundaryGroup);
        // Build City Pairs / Flights Layer Group
        var mFlights = L.layerGroup();
        var FLT_{{ $flight->origin->icao_code.$flight->destination->icao_code }}_GC = L.geodesic([DepLoc, ArrLoc], {weight: 2, opacity: 0.6, steps: 5, color: 'blue'}).bindPopup('Great Circle').addTo(mFlights);
        var FLT_{{ $flight->origin->icao_code.$flight->destination->icao_code }}_ROUTE = L.geodesic(Route, {weight: 2, opacity: 0.8, steps: 5, color: 'darkgreen'}).bindPopup('Flight Route').addTo(mFlights);
        // Define Base Layers For Control Box
        var DarkMatter = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png?key={{ $carto_apikey }}', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/attributions">CARTO</a>',
          subdomains: 'abcd',
          maxZoom: 20
        });
        var NatGeo = L.tileLayer.provider('Esri.NatGeoWorldMap');
        var OpenSM = L.tileLayer.provider('OpenStreetMap.Mapnik');
        var WorldTopo = L.tileLayer.provider('Esri.WorldTopoMap');
        // Define Additional Overlay Layers
        var OpenAIP = L.tileLayer('https://{s}.api.tiles.openaip.net/api/data/openaip/{z}/{x}/{y}.png?apiKey={{ $openaip_apikey }}', {
          attribution: '&copy; <a href="https://www.openaip.net/">openAIP Data</a>',
          subdomains: ['a', 'b', 'c'],
          minZoom: 2,
          maxZoom: 14
        });
        // Define Control Groups
        var BaseLayers = {'Dark Matter': DarkMatter, 'OpenSM Mapnik': OpenSM, 'NatGEO World': NatGeo, 'World Topo': WorldTopo};
        var Overlays = {'OpenAIP Data': OpenAIP};
        // Define Map and Add Control Box
        var FlightMap = L.map('FlightMap', {center: DepLoc, layers: [WorldTopo, mAirports, mFlights], scrollWheelZoom: true}).fitBounds(BoundaryGroup.getBounds().pad(0.2));
        L.control.layers(BaseLayers, Overlays).addTo(FlightMap);
        // TimeOut to ReDraw The Map in Modal
        setTimeout(function(){ FlightMap.invalidateSize().fitBounds(BoundaryGroup.getBounds().pad(0.2))}, 300);
      }
    </script>
  @endsection
