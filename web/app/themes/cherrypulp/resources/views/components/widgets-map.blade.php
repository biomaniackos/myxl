<section @if(isset($first) && $first) id="page" @endif class="widget-map pt-10 pb-20">
    <div class="container-wide grid grid-cols-12 gap-4">
        
        <div class="col-span-12 md:col-span-6 lg:col-span-4 lg:col-start-2 flex justify-center items-center rounded-3xl">
        @if ($item['map'] && $item['map']['url'])
            <img src="{{ $item['map']['url'] }}" class="object-cover" alt="{{ $item['map']['title'] }}" data-aos="fade-up" data-aos-duration="500">
        @endif
        </div>

        <div class="col-span-12 md:col-span-6 md:col-start-7 text-center md:text-left flex flex-col justify-center">
            <div class="max-w-md">
                @if ($item['title'])
                <h2>{!! $item['title'] !!}</h2>
                @endif
            
                @if ($item['text'])
                <p style="font-size: 18px; font-size: 1.125rem;">{{ $item['text'] }}</p>
                @endif
            
                @if ($item['button']['url'])    
                <a href="{{ $item['button']['url'] }}" class="block w-max btn btn-basic btn-primary mt-6" target="{{ $item['button']['target'] }}">{{ $item['button']['title'] ? $item['button']['title'] : 'myxl clique' }}</a>
                @endif
            </div>
        </div>
    </div>
</section>