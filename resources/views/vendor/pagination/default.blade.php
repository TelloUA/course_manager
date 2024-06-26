@if ($paginator->hasPages())
    <nav>
        <ul class="pagination" style="margin-bottom: 0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="m-1 disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="m-1">
                    <a href="{{ $paginator->previousPageUrl() }}{{ request()->has('group_id') ? '&group_id='.request()->input('group_id') : '' }}"
                       rel="prev"
                       aria-label="@lang('pagination.previous')">
                        &lsaquo;
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active m-1" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li class="m-1">
                                <a href="{{ $url }}{{ request()->has('group_id') ? '&group_id='.request()->input('group_id') : '' }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="m-1">
                    <a href="{{ $paginator->nextPageUrl() }}{{ request()->has('group_id') ? '&group_id='.request()->input('group_id') : '' }}"
                       rel="next"
                       aria-label="@lang('pagination.next')">
                        &rsaquo;
                    </a>
                </li>
            @else
                <li class="m-1 disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
