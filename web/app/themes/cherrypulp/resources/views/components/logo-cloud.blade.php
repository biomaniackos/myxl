<div class="logo-cloud logo-cloud-{{ $type }} {{ $classes }}">
    @if ($type === 'grid')
        <div class="mt-6 grid grid-cols-2 gap-0.5 md:grid-cols-3 lg:mt-8">
            @if(!empty($items))
                @foreach (collect($items)->take(6) as $item)
                    @if ($item['link'])
                        <a class="col-span-1 flex justify-center py-8 px-8 bg-gray-50" href="{{ $item['link'] }}">
                            <img class="max-h-12" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] }}">
                        </a>
                    @else
                        <div class="col-span-1 flex justify-center py-8 px-8 bg-gray-50">
                            <img class="max-h-12" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] }}">
                        </div>
                    @endif
                @endforeach
            @else
                {!! $slot !!}
            @endif
        </div>
    @elseif ($type === 'line')
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-5">
                @if(!empty($items))
                    @foreach (collect($items)->take(5) as $item)
                        @if ($item['link'])
                            <a class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1" href="{{ $item['link'] }}">
                                <img class="h-12" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] }}">
                            </a>
                        @else
                            <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
                                <img class="h-12" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] }}">
                            </div>
                        @endif
                    @endforeach
                @else
                    {!! $slot !!}
                @endif
            </div>
        </div>
    @endif
</div>
