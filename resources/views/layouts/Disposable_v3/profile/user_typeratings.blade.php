<div class="row row-cols-6">
  @foreach($user->typeratings as $tr)
    <div class="col">
      <div class="card text-center mb-2">
        <div class="card-body p-2">
          @if(filled($tr->image_url))
            <img class="img-fluid rounded" src="{{ $tr->image_url }}" title="{{ $tr->description }}"  alt="">
          @else
            <span title="{{ $tr->description }}">{{ $tr->name }}</span>
          @endif
        </div>
        <div class="card-footer p-0 small fw-bold">
          {{ $tr->type }}
        </div>
      </div>
    </div>
  @endforeach
</div>