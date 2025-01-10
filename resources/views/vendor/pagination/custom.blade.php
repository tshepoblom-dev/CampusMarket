@if ($paginator->hasPages())
                <nav class="pagination-wrap pt-60">
                    <ul class="pagination custom-pagination d-flex justify-content-center gap-md-3 gap-2">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                      <li class="page-item disabled">
                        <span class="page-link" tabindex="-1" >@lang('pagination.previous')</span>
                      </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1" >@lang('pagination.previous')</a>
                      </li>
                    @endif

                    {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page">
                        <span class="page-link">{{ $page }}</span>
                      </li>
                        @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">@lang('pagination.next')</a></li>
            @else
                <li class="page-item disabled"><span class="page-link" href="{{ $paginator->nextPageUrl() }}">@lang('pagination.next')</span></li>
            @endif
                    </ul>
                </nav>
                @endif