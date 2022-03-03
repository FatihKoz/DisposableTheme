<div class="row row-cols-lg-2">
  {{-- Origin --}}
  <div class="col-lg">
    <div class="card mb-1">
      <div class="card-body p-0">
        <iframe id="origin-frame"
          class="m-0 p-0"
          style="border-top-left-radius: 4px; border-top-right-radius: 4px; display:block" height="600px" width="100%"
          src="https://embed.windy.com/embed2.html?lat={{ $simbrief->xml->origin->pos_lat }}&lon={{ $simbrief->xml->origin->pos_long }}&detailLat={{ $simbrief->xml->origin->pos_lat }}&detailLon={{  $simbrief->xml->origin->pos_long }}&zoom=6&level=surface&overlay=thunder&product=ecmwf&marker=true&message=true&calendar=now&pressure=true&type=map&location=coordinates&metricWind=kt&metricTemp=%C2%B0C&radarRange=-1"
          frameborder="0">
        </iframe>
      </div>
      <div class="card-footer p-1 small">
        {{ $simbrief->xml->weather->orig_metar }}
      </div>
      <div class="card-footer p-1 small">
        {{ $simbrief->xml->weather->orig_taf }}
      </div>
    </div>
  </div>
  {{-- Destination --}}
  <div class="col-lg">
    <div class="card mb-1">
      <div class="card-body p-0">
        <iframe id="destination-frame" 
          class="m-0 p-0"
          style="border-top-left-radius: 4px; border-top-right-radius: 4px; display:block" height="600px" width="100%"
          src="https://embed.windy.com/embed2.html?lat={{ $simbrief->xml->destination->pos_lat }}&lon={{ $simbrief->xml->destination->pos_long }}&detailLat={{ $simbrief->xml->destination->pos_lat }}&detailLon={{ $simbrief->xml->destination->pos_long }}&zoom=6&level=surface&overlay=thunder&product=ecmwf&marker=true&message=true&calendar=now&pressure=true&type=map&location=coordinates&metricWind=kt&metricTemp=%C2%B0C&radarRange=-1"
          frameborder="0">
        </iframe>
      </div>
      <div class="card-footer p-1 small">
        {{ $simbrief->xml->weather->dest_metar }}
      </div>
      <div class="card-footer p-1 small">
        {{ $simbrief->xml->weather->dest_taf }}
      </div>
    </div>
  </div>
  {{-- Alternate Raw WX Only --}}
  @if(filled($simbrief->xml->weather->altn_metar))
    <div class="col-lg"></div>
    <div class="col-lg">
      <div class="card mb-1">
        <div class="card-footer p-1 small">
          {{ $simbrief->xml->weather->altn_metar }}
        </div>
        <div class="card-footer p-1 small">
          {{ $simbrief->xml->weather->altn_taf }}
        </div>
      </div>
    </div>
  @endif
</div>