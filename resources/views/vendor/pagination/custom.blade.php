@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        <ul class="inline-flex items-center -space-x-px">
            @if ($paginator->onFirstPage())
                <li class="cursor-not-allowed">
                    <span class="px-3 py-2 ml-0 leading-tight text-gray-400 bg-gray-100 border border-gray-300 rounded-l-lg">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 ml-0 leading-tight text-green-600 bg-white border border-gray-300 rounded-l-lg hover:bg-green-50 hover:text-green-800 transition duration-300">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="cursor-not-allowed">
                        <span class="px-3 py-2 leading-tight text-gray-400 bg-gray-100 border border-gray-300">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="px-3 py-2 leading-tight text-white bg-green-600 border border-gray-300">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="px-3 py-2 leading-tight text-green-600 bg-white border border-gray-300 hover:bg-green-50 hover:text-green-800 transition duration-300">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 leading-tight text-green-600 bg-white border border-gray-300 rounded-r-lg hover:bg-green-50 hover:text-green-800 transition duration-300">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="cursor-not-allowed">
                    <span class="px-3 py-2 leading-tight text-gray-400 bg-gray-100 border border-gray-300 rounded-r-lg">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
