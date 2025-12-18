@extends('layouts.app')

@php
$post = get_queried_object();
$association = get_field('associations', $post)[0];

$terms = get_the_terms($post->ID, 'activity-types');
$term = null;
$back = null;
if (is_array($terms) && count($terms)) {
    $term = $terms[0];
    $back['url'] = get_term_link($term);
    $back['title'] = 'Activité ' . $term->name;
}
$image = get_the_post_thumbnail_url($post->ID, 'large', false);
$color = get_field('color', $term) ?? '#3097F2';

$term_posts = get_posts([
    'post_type' => 'activities',
    'numberposts' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => [
        [
            'taxonomy' => 'activity-types',
            'field' => 'term_id',
            'terms' => $term->term_id,
        ]
    ],
]);

$related_posts = get_posts([
    'post_type' => 'activities',
    'numberposts' => 4,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => [
        [
            'taxonomy' => 'activity-types',
            'field' => 'term_id',
            'terms' => $term->term_id,
        ]
    ],
    'exclude' => $post->ID,
]);

$related_associations = [];
foreach ($term_posts as $term_post) {
    $obj = get_field('associations', $term_post->ID);
    if (is_array($obj) && $obj[0] && !isset($related_associations[$obj[0]->ID])) {
        $related_associations[$obj[0]->ID] = $obj[0];
    }
}
@endphp

@section('content')
@include('components.single-hero', [
    'back' => [
        'url' => $back['url'],
        'title' => $back['title'],
    ],
    'color' => $color,
    'image' => $image,
    'title' => [
        'primary' => $post->post_title,
    ],
])

<section class="grid grid-cols-12">
<div class="col-span-12 lg:col-span-4 relative flex justify-start lg:justify-center py-5 px-5 pt-24 pb-28 lg:py-10 lg:px-0 lg:pt-24 lg:pb-28 text-white" style="background-color: {{ $color }};">

    <div class="w-full mx-auto max-w-xs">
        <div>
        <h4>Associations relatives</h4>
    
        <ul class="p-0 m-0 space-y-6">
            @foreach ($related_associations as $association)
            @php
                $url = get_permalink($association);
            @endphp
            <li>
            <a href="{{ $url }}" class="flex justify-start items-center no-underline text-white hover:underline focus:underline hover:text-white focus:text-white">
                @if (get_the_post_thumbnail_url($association->ID, 'large', false))
                <div class="w-20 h-20 overflow-hidden rounded-lg"
                     style="min-width: 5rem; min-height: 5rem;
                            max-width: 5rem; max-height: 5rem;">
                <img class="object-cover w-full h-full" src="{{ get_the_post_thumbnail_url($association->ID, 'large', false) }}" alt="">
                </div>
                @else
                <div class="w-20 h-20 overflow-hidden rounded-lg"
                     style="min-width: 5rem; min-height: 5rem;
                            max-width: 5rem; max-height: 5rem;">
                <img class="object-cover w-full h-full" src="@asset('images/thumbnail.png')" alt="">
                </div>
                @endif
                <p class="grow m-0 ml-6">{{ $association->post_title }}</p>
            </a>
            </li>
            @endforeach
        </ul>
        </div>

        <div class="mt-10">
        <h4>Consulte aussi :</h4>

        <ul class="p-0 m-0 space-y-6">
            @foreach ($related_posts as $related_post)
            @php
                $url = get_permalink($related_post);
            @endphp
            <li>
            <a href="{{ $url }}" class="flex justify-between items-center p-4 no-underline bg-white text-primary-800 rounded-lg hover:text-primary-800 focus:text-primary-800">
                <p class="m-0">{{ $related_post->post_title }}</p>
                <img src="@asset('images/round-elipse.png')" class="ml-20" width="25" alt="">
            </a>
            </li>
            @endforeach
        </ul>
        </div>

        <div class="mt-10">
        <h4>Retour aux activités</h4>
    
        @include('components.card-activity', [
            'item' => $term,
            'negative' => true,
            'small' => true,
        ])
        </div>
    </div>

</div>

<div class="col-span-12 lg:col-span-8 p-5 pt-24 pb-28 lg:p-10 lg:pl-16 lg:pr-20 lg:pt-24 lg:pb-28">

    <div class="max-w">
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
                    <i class="fab fa-facebook-f" style="--data-color:{{ $color }};"></i>
                    </a>
                </li>

                @if (isset($instagram) && $instagram)
                <li class="m-0 mr-6">
                    <a class="btn w-10 h-10 p-2 flex justify-center items-center min-w-max rounded-full" type="button" role="button" title="Partage sur instagram"
                    href="{{ $instagram }}" target="_blank"
                    rel="noopener">
                    <i class="fab fa-instagram" style="--data-color:{{ $color }};"></i>
                    </a>
                </li>
                @endif

                <li class="m-0 mr-6">
                    <a class="btn w-10 h-10 p-2 flex justify-center items-center min-w-max rounded-full" type="button" role="button" title="Partage sur twitter"
                    href="https://twitter.com/intent/tweet?url={{ get_permalink($post->ID) }}" target="_blank"
                    rel="noopener">
                    <i class="fab fa-twitter" style="--data-color:{{ $color }};"></i>
                    </a>
                </li>

                <li class="m-0 mr-6">
                    <a class="btn w-10 h-10 p-2 flex justify-center items-center min-w-max rounded-full" type="button" role="button" title="Partage sur linkedin"
                    href="http://www.linkedin.com/shareArticle?mini=true&url={{ get_permalink($post->ID) }}" target="_blank"
                    rel="noopener">
                    <i class="fab fa-linkedin-in" style="--data-color:{{ $color }};"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>
</section>
@endsection