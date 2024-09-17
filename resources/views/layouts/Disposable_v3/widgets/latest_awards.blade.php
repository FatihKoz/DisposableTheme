@if($awards->count() > 0)
  @if(request()->routeIs('frontend.home'))
    {{-- Homepage Design --}}
    <div class="card mb-2">
      <div class="card-header p-1">
        <h5 class="m-1">Latest Awards<i class="fas fa-trophy float-end"></i></h5>
      </div>
    </div>
    @foreach($awards as $a)
      <div class="card mb-2">
        <div class="row g-0">
          <div class="col-3">
            @if (isset($a->user->avatar))
              <img class="img-fluid rounded-start border-end border-dark img-mh80" src="{{ $a->user->avatar->url }}" alt="">
            @else
              <img class="img-fluid rounded-start border-end border-dark img-mh80" src="{{ $a->user->gravatar(100) }}" alt="">
            @endif
          </div>
          <div class="col-6">
            <div class="card-body p-1">
              <h5 class="card-title m-0">
                <a href="{{ route('frontend.profile.show', [$a->user->id]) }}">{{ $a->user->name_private }}</a>
              </h5>
              <p class="card-text fw-bold m-0">{{ optional($a->award)->name }}</p>
              <span class="card-text m-0 small text-muted">{{ $a->created_at->diffForHumans() }}</span>
            </div>
          </div>
          <div class="col-3">
            @if (isset($a->award->image_url))
              <img class="img-fluid float-end rounded-end border-start border-dark img-mh80" src="{{ $a->award->image_url }}" alt="{{ $a->award->name }}">
            @endif
          </div>
        </div>
      </div>
    @endforeach
    {{-- End Latest Pilots --}}
  @else
    <div class="card mb-2">
      <div class="card-body p-0 table-responsive">
        <table class="table table-small table-borderless table-striped mb-0">
          <tr>
            <th>Ident</th>
            <th>Name</th>
            <th>Award</th>
            <th>Date</th>
          </tr>
          @foreach($awards as $a)
            <tr>
              <td>{{ optional($a->user)->ident }}</td>
              <td>{{ optional($a->user)->name_private }}</td>
              <td>{{ optional($a->award)->name }}</td>
              <td>{{ $a->created_at->format('d.M.Y H:i') }}</td>
            </tr>
          @endforeach
        </table>
      </div>
    </div>
  @endif
@endif