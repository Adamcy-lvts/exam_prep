@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
        class="flex flex-col sm:flex-row items-center justify-between bg-white dark:bg-zinc-800 px-4 py-3 rounded-md">

        {{-- Results Info --}}
        {{-- <div class="text-sm text-gray-400 leading-5 mb-2 sm:mb-0">
            Showing
            <span class="font-medium text-white">{{ $paginator->firstItem() }}</span>
            to
            <span class="font-medium text-white">{{ $paginator->lastItem() }}</span>
            of
            <span class="font-medium text-white">{{ $paginator->total() }}</span>
            results
        </div> --}}

        {{-- Pagination Links Container --}}
        <div class="relative z-0 inline-flex gap-3 shadow-sm rounded-md">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Previous
                </span>
            @else
                <button wire:click="previousPage" rel="prev"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:hover:bg-green-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Previous
                </button>
            @endif

            {{-- Pagination Elements --}}
            @php
                $start = max($paginator->currentPage() - 2, 1);
                $end = min(max($paginator->currentPage() + 2, 5), $paginator->lastPage());
            @endphp
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $paginator->currentPage())
                    <span aria-current="page"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-600 border rounded-md border-gray-300 cursor-default leading-5">
                        {{ $i }}
                    </span>
                @else
                    <a wire:click.prevent="gotoPage({{ $i }})"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-white dark:bg-zinc-700 rounded-md border border-gray-300 leading-5 hover:bg-green-600 hover:border-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-700 transition ease-in-out duration-150">
                        {{ $i }}
                    </a>
                @endif
            @endfor

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" rel="next"
                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:hover:bg-green-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white">
                    Next
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            @else
                <span
                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700">
                    Next
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif
