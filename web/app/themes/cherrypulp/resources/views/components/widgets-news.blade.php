@if ($item['title'] || $item['text'] || $item['button'] || $item['news_first'] || $item['news_second'])
@php
    $wave_top = $item['wave_top'] ?? true;
    $wave_bottom = $item['wave_bottom'] ?? true;
@endphp
<section @if(isset($first) && $first) id="page" @endif class="widget-news wave @if($wave_top !== 'no') wave-top @endif @if($wave_bottom !== 'no') wave-bottom @endif">
<div class="flex h-full items-center">
<div class="container-wide items-center grid grid-cols-12 gap-4">

    <div class="col-span-12 md:col-span-4 text-center md:text-left">
        @if ($item['title'])
        <h2>{!! $item['title'] !!}</h2>
        @endif

        @if ($item['text'])
        <p class="max-w-xs mt-6">{{ $item['text'] }}</p>
        @endif

        @if ($item['button'] && $item['button']['url'])
            <a class="btn btn-basic btn-white w-max block mt-11 mx-auto md:mx-0" href="{{ $item['button']['url'] }}" target="{{ $item['button']['target'] }}">{{ $item['button']['title'] ? $item['button']['title'] : 'clique myxl' }}</a>
        @endif
    </div>

    @php
        $news = [];
        if ($item['news_first'] && $item['news_second']) {
            $news = [$item['news_first'], $item['news_second']];

        } else if ($item['news_first']) {
            // get one auto news post and add it at index 1 on array
            $result = get_posts([
                'post_type' => 'post',
                'numberposts' => 1,
                'orderby' => 'date',
                'order' => 'DESC',
                'exclude' => $item['news_first']->ID,
            ]);

            $news = [$item['news_first']];

            if (!empty($result)) {
                $news[] = $result[0];
            }
        } else if ($item['news_second']) {
            // get one auto news post and add it at index 0 on array
            $result = get_posts([
                'post_type' => 'post',
                'numberposts' => 1,
                'orderby' => 'date',
                'order' => 'DESC',
                'exclude' => $item['news_second']->ID,
            ]);

            $news = [];

            if (!empty($result)) {
                $news[] = $result[0];
            }

            $news[] = $item['news_second'];
        } else {
            // get auto news post
            $result = get_posts([
                'post_type' => 'post',
                'numberposts' => 2,
                'orderby' => 'date',
                'order' => 'DESC',
            ]);
            $news = $result;
            // $news = [$post, $item['news_second']];
        }
    @endphp
    <div class="col-span-12 md:col-span-8 grid grid-cols-8 gap-8">
    @php
        $duration = 500;
    @endphp
    @foreach ($news as $result)
        <div class="col-span-8 md:col-span-4" data-aos="fade-up" data-aos-duration="{{ $duration }}">
            @include('components.card-news', ['item' => $result])
        </div>
        @php
            $duration = $duration + 250;
        @endphp
    @endforeach
    </div>

</div>
</div>
</section>
@endif
