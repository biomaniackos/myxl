@php
    $color = get_field('color', $item) ?? '#3097F2';
    $icon = get_field('icon', $item);
    $icon_color = get_field('icon_color', $item);
    $negative = $negative ?? false;
    $small = $small ?? false;
@endphp
<div class="card-activity @if ($negative) negative @endif @if ($small) small @endif" style="background-color:{{ $negative ? '#FFFFFF' : $color }}; --data-color:{{ $color }};">
    <a href="{{ get_term_link($item) }}">{{ $item->name }}</a>
    <div class="card-wrapper">
        @if (isset($icon) && isset($icon['url']))
        <div class="image-wrapper">
            <img class="icon" src="{{ $icon['url'] }}" alt="{{ $item->name }} icon">
            @if (isset($icon_color['url']))
            <img class="icon-color" src="{{ $icon_color['url'] }}" alt="">
            @endif
        </div>
        @endif
        <div class="mt-5">
            <h2 class="flex items-end justify-between m-0" style="--data-color:{{ $color }};">
                <span style="word-break: break-word;">{{ $item->name }}</span>
                <div class="w-11 h-11 ml-3">
                    <svg width="100%" height="100%" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="22.5" cy="22.5" r="22.5" fill="{{ $negative ? $color : '#FFFFFF'  }}" style="--data-color:{{ $color }};"/>
                        <path d="M25 17L31 23L25 29" stroke="{{ $negative ? '#FFFFFF' : $color }}" stroke-width="2" stroke-linecap="round" style="--data-color:{{ $color }};"/>
                        <path d="M13 23H29" stroke="{{ $negative ? '#FFFFFF' : $color }}" stroke-width="2" stroke-linecap="round" style="--data-color:{{ $color }};"/>
                    </svg>
                </div>
            </h2>
        </div>
    </div>
</div>
