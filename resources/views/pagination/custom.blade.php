@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-end mt-4">
        <div class="flex items-center gap-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}" class="flex items-center justify-center px-2 sm:px-3 h-9 text-sm font-medium text-gray-400 bg-white border border-gray-200 rounded-md cursor-default">
                    <i class="fas fa-chevron-left sm:mr-1.5" style="font-size: 10px;"></i> <span class="hidden sm:inline">Prev</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex items-center justify-center px-2 sm:px-3 h-9 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-blue-600 hover:border-blue-300 transition-all duration-200" aria-label="{{ __('pagination.previous') }}">
                    <i class="fas fa-chevron-left sm:mr-1.5" style="font-size: 10px;"></i> <span class="hidden sm:inline">Prev</span>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span aria-disabled="true" class="flex items-center justify-center px-2 sm:px-3 h-9 text-sm font-medium text-gray-500 bg-transparent cursor-default">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="flex items-center justify-center min-w-[32px] sm:min-w-[36px] px-2 sm:px-3 h-9 text-sm font-bold text-white bg-blue-600 border border-blue-600 rounded-md shadow-sm cursor-default">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="flex items-center justify-center min-w-[32px] sm:min-w-[36px] px-2 sm:px-3 h-9 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-blue-600 hover:border-blue-300 transition-all duration-200" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex items-center justify-center px-2 sm:px-3 h-9 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-blue-600 hover:border-blue-300 transition-all duration-200" aria-label="{{ __('pagination.next') }}">
                    <span class="hidden sm:inline">Next</span> <i class="fas fa-chevron-right sm:ml-1.5" style="font-size: 10px;"></i>
                </a>
            @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}" class="flex items-center justify-center px-2 sm:px-3 h-9 text-sm font-medium text-gray-400 bg-white border border-gray-200 rounded-md cursor-default">
                    <span class="hidden sm:inline">Next</span> <i class="fas fa-chevron-right sm:ml-1.5" style="font-size: 10px;"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
