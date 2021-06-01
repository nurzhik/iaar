@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link pag first">{{ __('main.Backward')}}</span></li>
        @else
            <li class="page-item"><a class="page-link pag first" href="{{ $paginator->previousPageUrl() }}" rel="prev">{{ __('main.Backward')}}</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link pag">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item "><a href="#" class="active pag">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link pag" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link pag last" href="{{ $paginator->nextPageUrl() }}" rel="next">{{ __('main.Forward')}}</a></li>
        @else
            <li class="page-item disabled"><span class="page-link pag last">{{ __('main.Forward')}}</span></li>
        @endif
    </ul>
@endif
