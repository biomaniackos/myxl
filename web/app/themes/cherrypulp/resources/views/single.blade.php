@extends('layouts.app', [
    'wave' => 'no',
])

@php
$image = get_the_post_thumbnail_url($post->ID, 'large', false);
@endphp

@section('content')
@include('components.single-hero', [
    'back' => [
        'url' => get_post_type_archive_link('post'),
        'title' => "Retour aux Actus",
    ],
    'image' => $image,
    'title' => [
        'primary' => $post->post_title,
    ],
])

<section class="py-32 px-3">
<div class="max-w-3xl mx-auto">

    @php
        $author = get_user_by('ID', $post->post_author)->data->user_nicename ?? 'Myxl';
    @endphp
    <p class="mb-6">par {{ $author }} - Le {{ date('d F Y', strtotime($post->post_date)) }}</p>

    <p class="max-w-lg mb-6">
        {!! apply_filters('the_content', $post->post_content) !!}
    </p>
        
    <!-- Your share button code -->
    <div class="flex flex-row justify-start items-center mt-10">
        <p class="uppercase font-bold m-0 leading-0">Partager</p>
        <ul class="socials-list flex flex-row justify-center items-center m-0 p-0 ml-5">
            <li class="m-0 mr-6">
                <a class="btn w-10 h-10 p-2 flex justify-center items-center min-w-max rounded-full" type="button" role="button" title="Partage sur facebook"
                href="https://www.facebook.com/sharer/sharer.php?u={{ get_permalink($post->ID) }}" target="_blank"
                rel="noopener">
                <i class="fab fa-facebook-f" style="--data-color:#B8EDFF;"></i>
                </a>
            </li>

            @if (isset($instagram) && $instagram)
            <li class="m-0 mr-6">
                <a class="btn w-10 h-10 p-2 flex justify-center items-center min-w-max rounded-full" type="button" role="button" title="Partage sur instagram"
                href="{{ $instagram }}" target="_blank"
                rel="noopener">
                <i class="fab fa-instagram" style="--data-color:#B8EDFF;"></i>
                </a>
            </li>
            @endif

            <li class="m-0 mr-6">
                <a class="btn w-10 h-10 p-2 flex justify-center items-center min-w-max rounded-full" type="button" role="button" title="Partage sur twitter"
                href="https://twitter.com/intent/tweet?url={{ get_permalink($post->ID) }}" target="_blank"
                rel="noopener">
                <i class="fab fa-twitter" style="--data-color:#B8EDFF;"></i>
                </a>
            </li>

            <li class="m-0 mr-6">
                <a class="btn w-10 h-10 p-2 flex justify-center items-center min-w-max rounded-full" type="button" role="button" title="Partage sur linkedin"
                href="http://www.linkedin.com/shareArticle?mini=true&url={{ get_permalink($post->ID) }}" target="_blank"
                rel="noopener">
                <i class="fab fa-linkedin-in" style="--data-color:#B8EDFF;"></i>
                </a>
            </li>
        </ul>
    </div>

</div>
</section>

@if (!empty($related_posts))
<section>
    @include('components.widgets-news', [
        'item' => [
            'title' => 'Consulter aussi',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras id eros pellentesque, accumsan nisi',
            'button' => [
                'url' => get_post_type_archive_link('post'),
                'title' => 'toutes les actus',
                'target' => null,
            ],
            'wave_bottom' => 'no',
            'news_first' => $related_posts[0],
            'news_second' => isset($related_posts[1]) ? $related_posts[1] : null,
        ],
    ])

    {{-- $item['title'] || $item['text'] || $item['button'] || $item['news_first'] || $item['news_second'] --}}
</section>
@endif
@endsection
