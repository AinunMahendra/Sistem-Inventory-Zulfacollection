@if ($paginator->hasPages())
    <div class="pagination-container justify-content-center">
        <ul class="pagination justify-content-center">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:;" tabindex="-1">
                        <span class="material-icons">
                            keyboard_arrow_left
                        </span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1">
                        <span class="material-icons">
                            keyboard_arrow_left
                        </span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disable"><a class="page-link">{{ $element }}</a></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><a class="page-link"
                                    href="javascript:;">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link"
                                    href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="javascript:;">
                        <span class="material-icons">
                            keyboard_arrow_right
                        </span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            @else
                <li class="page-item disable">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                        <span class="material-icons">
                            keyboard_arrow_right
                        </span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            @endif

        </ul>
    </div>
@endif
