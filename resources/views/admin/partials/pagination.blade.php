@if ($paginator->total() > 0)
    <nav class="admin-pagination" role="navigation" aria-label="Pagination">
        <p class="admin-pagination__summary">
            Showing <strong>{{ $paginator->firstItem() }}</strong>–<strong>{{ $paginator->lastItem() }}</strong>
            of <strong>{{ $paginator->total() }}</strong> {{ \Illuminate\Support\Str::plural($itemLabel ?? 'record', $paginator->total()) }}
        </p>

        @if ($paginator->hasPages())
            <ul class="admin-pagination__list">
                @if ($paginator->onFirstPage())
                    <li><span class="admin-page-link is-disabled" aria-disabled="true">Prev</span></li>
                @else
                    <li>
                        <a class="admin-page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                            Prev
                        </a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li><span class="admin-page-link is-dots">{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li><span class="admin-page-link is-active" aria-current="page">{{ $page }}</span></li>
                            @else
                                <li><a class="admin-page-link" href="{{ $url }}" aria-label="Go to page {{ $page }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li>
                        <a class="admin-page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page">
                            Next
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    </li>
                @else
                    <li><span class="admin-page-link is-disabled" aria-disabled="true">Next</span></li>
                @endif
            </ul>
        @endif
    </nav>
@endif
