@if($paginator->total() > $paginator->perPage())
  <div class="row mt-1">
    <div class="col">
      <ul class="pagination justify-content-center text-center small">
        {{-- Previous Page Link --}}
        @if($paginator->onFirstPage())
          <li class="page-item disabled pag-items">
            <span class="page-link py-1 pag-items">&laquo;</span>
          </li>
        @else
          <li class="page-item pag-items">
            <a class="page-link py-1 pag-items" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
          </li>
        @endif
        {{-- Pagination Elements --}}
        @foreach($elements as $element)
          {{-- "Three Dots" Separator --}}
          @if(is_string($element))
            <li class="page-item disabled pag-items">
              <span class="page-link py-1 pag-items">{{ $element }}</span>
            </li>
          @endif
          {{-- Array Of Links --}}
          @if(is_array($element))
            @foreach ($element as $page => $url)
              @if ($page == $paginator->currentPage())
                <li class="page-item active pag-items-curr">
                  <span class="page-link py-1 pag-items-curr">{{ $page }}</span>
                </li>
              @else
                <li class="page-item pag-items">
                  <a class="page-link py-1 pag-items" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach
          @endif
        @endforeach
        {{-- Next Page Link --}}
        @if($paginator->hasMorePages())
          <li class="page-item pag-items">
            <a class="page-link py-1 pag-items" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
          </li>
        @else
          <li class="page-item disabled pag-items">
            <span class="page-link py-1 pag-items">&raquo;</span>
          </li>
        @endif
      </ul>
    </div>
  </div>
@endif