@if($user->awards)
  <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6">
    @foreach($user->awards as $award)
      <div class="col">
        <div class="card mb-2">
          <div class="card-body text-center p-1">
            @if($award->image_url)
              <img class="img-mh150" src="{{ $award->image_url }}" alt="{{ $award->name }}" title="{{ $award->description }}">
            @endif
          </div>
          <div class="card-footer p-0 small text-center fw-bold">
            {{ $award->name }}
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endif