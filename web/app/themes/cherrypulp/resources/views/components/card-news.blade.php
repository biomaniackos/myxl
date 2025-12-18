<div class="card-news" @if (isset($duration)) data-aos="fade-up" data-aos-duration="{{ $duration }}" @endif>
<a href="{{ get_the_permalink($item->ID) }}">{{ $item->post_title }}</a>
<div class="card-news-wrapper">
    {{-- <div class="h-1/2 object-cover"> --}}
        @if (get_the_post_thumbnail_url($item->ID, 'large', false))
            <img class="object-cover card-news-child card-news-child-top" src="{{ get_the_post_thumbnail_url($item->ID, 'large', false) }}" alt="{{ $item->post_title }} thumb">
        @else
            <img class="object-cover card-news-child card-news-child-top" src="@asset('images/thumbnail.png')" alt="{{ $item->post_title }} thumb">
        @endif
    {{-- </div> --}}
    <div class="card-news-child card-news-child-bottom">
        <small>{{ time_ago($item->post_date); }}</small>
        <p>{{ substr($item->post_title, 0, 18) }} @if (count_chars($item->post_title) > 18)...@endif</p>
        {{-- <p>{{ wp_trim_words($item->post_content, 18, '...') }}</p> --}}
        <div class="infos">
            @php
                $cat = get_the_category($item->ID);
                if (count($cat)) {
                    $cat = $cat[0];
                } else {
                    $cat = null;
                }
                $cat_name = !$cat || $cat->slug === 'uncategorized' ? '' : $cat->cat_name;
                $date = new DateTime($item->post_date);
                $date = date_format($date, 'M d, Y');
            @endphp
            <small>{{ $cat_name }}</small>
            <small>{{ $date }}</small>
            <small>{{ reading_time($item->post_content) }} lecture</small>
        </div>
    </div>
</div>
</div>