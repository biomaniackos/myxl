@if ($item['url'])
<section @if(isset($first) && $first) id="page" @endif class="widget-video" @if ($item['section_id']) id="{{ $item['section_id'] }}" @endif>
    @php
        $id = uniqid();
        // $base_url = get_site_url();
        $url = $item['url'];
        if(strpos($item['url'], "https") !== false) {
            if(strpos($item['url'], "embed") !== false) {
                $url = $item['url'];
            }
            if(strpos($item['url'], "?v=") !== false) {
                $string = explode("?v=", $item['url']);
                $url = "https://www.youtube.com/embed/" . $string[1];
            }
        } else {
            $url = "https://www.youtube.com/embed/" . $item['url'];
        }
    @endphp
    <iframe id={{ $id }}
            width="100%"
            height="auto"
            src="{{ $url }}"
            title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
    @if ($item['image'])
    <div class="image-placeholder show" data-videoplayer>

        <span class="btn-video btn-dark w-max mt-8 md:mt-0 ml-0 md:ml-6" href="#">
            <span class="play"><img src="@asset('images/play-white.svg')" alt=""></span>
            <span class="sr-only">Video</span>
        </span>

        <img src="{{ $item['image']['url'] }}" alt="{{ $item['image']['title'] }}">
    </div>
    @endif
</section>
@endif