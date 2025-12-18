@php
$associations = get_field('associations', $item);
@endphp
<div class="card-post-activity">
    <a href="{{ get_permalink($item) }}">{{ $item->post_title }}</a>
    <h4>{{ $item->post_title }}</h4>
    @if ($associations && count($associations))
    <div class="wrapper-bottom">
        <div class="wrapper-bottom-img">
            @if ($thumbnail = get_the_post_thumbnail_url($item->ID, 'thumbnail', false))
                <img src="{{ $thumbnail }}" alt="{{ $item->post_title }}">
            @else
                <img src="@asset('images/thumbnail.png')" alt="{{ $item->post_title }}">
            @endif    
        </div>
        <h4>{{ $associations[0]->post_title }}</h4>
    </div>
    @endif
</div>
