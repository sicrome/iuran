@if ($paginator->hasPages())
    <style>
        .pagination-custom {
            display: flex;
            gap: 4px;
            justify-content: center;
            margin-top: 12px;
            flex-wrap: wrap;
            padding: 0;
        }
        .pagination-custom .page-item {
            list-style: none;
        }
        .pagination-custom .page-link {
            padding: 3px 8px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 5px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 10px;
            display: inline-block;
            transition: all 0.2s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            min-width: 26px;
            text-align: center;
        }
        .pagination-custom .page-link:hover {
            background: rgba(102, 126, 234, 0.4);
            color: white;
        }
        .pagination-custom .active .page-link {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: transparent;
        }
        .pagination-custom .disabled .page-link {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>

    <ul class="pagination-custom">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">‹ Sebelumnya</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">‹ Sebelumnya</a></li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">Berikutnya ›</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">Berikutnya ›</span></li>
        @endif
    </ul>
@endif