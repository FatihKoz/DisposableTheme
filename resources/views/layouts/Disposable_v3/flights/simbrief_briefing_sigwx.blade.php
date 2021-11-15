<div class="row row-cols-2">
  @foreach($simbrief->images as $image)
    @if($image['name'] === 'Route' || $image['name'] === 'Vertical profile')
      <div class="col">
        <div class="card mb-2">
          <div class="card-body p-1">
            <img class="img-fluid rounded" src="{{ $image['url'] }}"/>
          </div>
          <div class="card-footer p-1 text-center small">
            {{ $image['name'] }}
          </div>
        </div>
      </div>
    @endif
  @endforeach
</div>

<div class="row row-cols-2">
  @foreach($simbrief->images as $image)
    @if(strpos($image['name'], 'SigWx') !== false)
      <div class="col">
        <div class="card mb-2">
          <div class="card-body p-1">
            <img class="img-fluid rounded" src="{{ $image['url'] }}"/>
          </div>
          <div class="card-footer p-1 text-center small">
            {{ $image['name'] }}
          </div>
        </div>
      </div>
    @endif
  @endforeach
</div>

<div class="row row-cols-2">
  @foreach($simbrief->images as $image)
    @if(strpos($image['name'], 'UAD') !== false)
      <div class="col">
        <div class="card mb-2">
          <div class="card-body p-1">
            <img class="img-fluid rounded" src="{{ $image['url'] }}"/>
          </div>
          <div class="card-footer p-1 text-center small">
            {{ $image['name'] }}
          </div>
        </div>
      </div>
    @endif
  @endforeach
</div>