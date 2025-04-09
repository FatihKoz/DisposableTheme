@php
  $speed_margin = 20;
  $msl = $pirep->acars->where('gs', '>', $speed_margin)->pluck('altitude_msl');
  $agl = $pirep->acars->where('gs', '>', $speed_margin)->pluck('altitude_agl');
  $spd = $pirep->acars->where('gs', '>', $speed_margin)->pluck('gs');
  $ias = $pirep->acars->where('gs', '>', $speed_margin)->pluck('ias');
  $terr = [];
  foreach ($pirep->acars->where('gs', '>', $speed_margin) as $a) {
    $terr[] = ($a->altitude_msl - $a->altitude_agl) > 0 ? $a->altitude_msl - $a->altitude_agl : 0;
  }
@endphp
<div id="chart" class="p-1"></div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>	
var options = {
  chart: {
    fontFamily: 'Helvetica, Arial, sans-serif',
    height: 'auto',
    width: '100%',
    redrawOnParentResize: true,
    zoom: {
      enabled: true
    },
    toolbar: {
      show: true,
      offsetX: -10,
      offsetY: 0,
      tools: {
        download: true,
        selection: false,
        zoom: true,
        zoomin: true,
        zoomout: true,
        pan: false,
        reset: true | '<img src="/static/icons/reset.png" width="20">',
        customIcons: []
      }
    },
  },
  title: {
    text: '{!! $pirep->ident !!} Altitude and Speed Records',
    align: 'left',
    style: {
      fontWeight: 'bold'
    },
  },
  legend: {
    show: true,
    horizontalAlign: 'center',
    position: 'top',
  },
  tooltip: {
    x: {
      show: false,
    },
    fixed: {
      enabled: false,
      position: 'topLeft',
      offsetX: 60,
      offsetY: 80,
    }
  },
  series: [
    {
      name: 'Altitude (MSL)',
      type: 'line',
      color: '#191970',
      zIndex: 5,
      data: {!! json_encode($msl) !!},
    }, {
      name: 'Altitude (AGL)',
      type: 'line',
      color: '#66CDAA',
      hidden: true,
      zIndex: 4,
      data: {!! json_encode($agl) !!},
    }, {
      name: 'Speed (GS)',
      type: 'line',
      color: '#F70D1A',
      hidden: false,
      zIndex: 3,
      data: {!! json_encode($spd) !!},
    }, {
      name: 'Speed (IAS)',
      type: 'line',
      color: '#800080',
      hidden: false,
      zIndex: 2,
      data: {!! json_encode($ias) !!},
    }, {
      name: 'Terrain Elevation',
      type: 'area',
      color: '#8B4513',
      zIndex: 1,
      fill: {
        colors: ['#A0522D'],
        opacity: 0.6
      },
      data: {!! json_encode($terr) !!},
    }
  ],
  stroke: {
    width: 3,
    curve: 'monotoneCubic'
  },
  xaxis: {
    labels: {
      show: false,
    },
    tooltip: {
      enabled: false,
    },
    decimalsInFloat: 0
  },
  yaxis: [
    {
      title: {
        text: 'Altitude (MSL and AGL)',
      },
      forceNiceScale: true,
      decimalsInFloat: 0,
      seriesName: ['Altitude (MSL)', 'Altitude (AGL)']
    },
    {
      title: {
        text: 'Speed (IAS and GS)',
      },
      forceNiceScale: true,
      decimalsInFloat: 0,
      opposite: true,
      seriesName: ['Speed (GS)', 'Speed (IAS)']
    },
    {
      title: {
        text: 'Terrain Elevation',
      },
      forceNiceScale: true,
      decimalsInFloat: 0,
      seriesName: 'Terrain Elevation'
    }
  ]
}

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();
</script>