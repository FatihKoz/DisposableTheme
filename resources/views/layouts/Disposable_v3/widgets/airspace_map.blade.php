<div id="map" style="width: {{ $config['width'] }}; height: {{ $config['height'] }}; border-radius: 3px;"></div>

@section('scripts')
  @parent
  <script>
    phpvms.map.render_airspace_map({
      lat: "{{$config['lat']}}",
      lon: "{{$config['lon']}}",
      metar_wms: {!! json_encode(config('map.metar_wms')) !!},
      leafletOptions: {
          // scrollWheelZoom: true,
          providers: {'OpenStreetMap.Mapnik': {},}
        }
    });
  </script>
@endsection