@php
  $map_height = isset($map_height) ? $map_height : '600px';
  $map_width = isset($map_width) ? $map_width : '100%';
@endphp
<div id="map" style="width: {{ $map_width }}; height: {{ $map_height }};"></div>

@section('scripts')
  @parent
  <script type="text/javascript">
    phpvms.map.render_route_map({
      pirep_uri: '{!! url('/api/pireps/'.$pirep->id.'/acars/geojson') !!}',
      route_points: {!! json_encode($map_features['planned_rte_points'])  !!},
      planned_route_line: {!! json_encode($map_features['planned_rte_line']) !!},
      actual_route_line: {!! json_encode($map_features['actual_route_line']) !!},
      actual_route_points: {!! json_encode($map_features['actual_route_points']) !!},
      aircraft_icon: '{!! public_asset('/assets/img/acars/aircraft.png') !!}',
      leafletOptions: {
        scrollWheelZoom: false,
        providers: {'OpenStreetMap.Mapnik': {},}
      }
    });
  </script>
@endsection
