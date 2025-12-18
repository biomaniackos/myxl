@if ($item['text'])
<section @if(isset($first) && $first) id="page" @endif class="widget-marquee">
    <div class="marquee">
        <div class="marquee__inner" aria-hidden="true">
            <span>{{ $item['text'] }} &nbsp;&nbsp;&nbsp;</span>
            <span>{{ $item['text'] }} &nbsp;&nbsp;&nbsp;</span>
            <span>{{ $item['text'] }} &nbsp;&nbsp;&nbsp;</span>
            <span>{{ $item['text'] }} &nbsp;&nbsp;&nbsp;</span>
        </div>
    </div>
</section>
@endif