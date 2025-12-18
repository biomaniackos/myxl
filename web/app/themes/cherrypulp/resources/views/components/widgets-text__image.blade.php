@if ($item['image'] || $item['title'] || $item['text'])
<section @if(isset($first) && $first) id="page" @endif class="widget-text__image">
<div class="container-wide grid grid-cols-12 gap-4">

    
    <div class="wrapper-image col-span-12 md:col-span-6 {{ !$item['side'] ? 'order-last invert' : 'order-first' }}" data-aos="fade-up" data-aos-duration="500">
        <span class="decoration">
            <img src="@asset('images/pattern-dots.svg')" alt="">
        </span>
        @if ($item['image'] && $item['image']['url'])
        <img class="object-cover" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['title'] }}">
        @endif
    </div>

    @if ($item['title'] || $item['text'])
    <div class="wrapper-content col-span-12 md:col-span-6 px-10 {{ !$item['side'] ? 'order-first' : 'order-last' }}">
        @if ($item['title'])
        <h2>{!! $item['title'] !!}</h2>
        @endif

        @if ($item['text'])
        <div class="content">{!! $item['text'] !!}</div>
        @endif
    </div>
    @endif

</div>
</section>
@endif