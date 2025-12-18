<nav class="border-t border-gray-200 px-4 flex items-center justify-between sm:px-0">
    @if ($previous && $max > 1)
        <div class="-mt-px w-0 flex-1 flex">
            @if ($current > 1)
                <a href="{{ $base }}/page/{{ $current - 1 }}" class="border-t-2 border-transparent pt-4 pr-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <svg class="mr-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    {{ $previous }}
                </a>
            @endif
        </div>
    @endif
    <div class="hidden md:-mt-px md:flex">
        @if ($max > 6)
            @foreach (range(1, 3) as $num)
                @if ($num === $current)
                    <a href="{{ $base }}/page/{{ $num }}" class="border-indigo-500 text-indigo-600 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium" aria-current="page">
                        {{ $num }}
                    </a>
                @else
                    <a href="{{ $base }}/page/{{ $num }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium">
                        {{ $num }}
                    </a>
                @endif
            @endforeach
            <span class="border-transparent text-gray-500 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium">
                ...
            </span>
            @foreach (range($max - 2, $max) as $num)
                @if ($num === $current)
                    <a href="{{ $base }}/page/{{ $num }}" class="border-indigo-500 text-indigo-600 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium" aria-current="page">
                        {{ $num }}
                    </a>
                @else
                    <a href="{{ $base }}/page/{{ $num }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium">
                        {{ $num }}
                    </a>
                @endif
            @endforeach
        @else
            @foreach (range(1, $max) as $num)
                @if ($num === $current)
                    <a href="{{ $base }}/page/{{ $num }}" class="border-indigo-500 text-indigo-600 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium" aria-current="page">
                        {{ $num }}
                    </a>
                @else
                    <a href="{{ $base }}/page/{{ $num }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium">
                        {{ $num }}
                    </a>
                @endif
            @endforeach
        @endif
    </div>
    @if ($next && $max > 1)
        <div class="-mt-px w-0 flex-1 flex justify-end">
            @if ($current < $max)
                <a href="{{ $base }}/page/{{ $current + 1 }}" class="border-t-2 border-transparent pt-4 pl-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    {{ $next }}
                    <svg class="ml-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif
        </div>
    @endif
</nav>
