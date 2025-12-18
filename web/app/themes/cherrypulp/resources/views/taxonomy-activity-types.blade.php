@extends('layouts.app')

@php
$category = get_queried_object();
// var(s)
$color = get_field('color', $category) ?? '#3097F2';
$icon = get_field('icon', $category);
// $icon_color = get_field('icon_color', $category);
$image = get_field('thumbnail', $category);
if ($image) {
    $image = $image['url'];
}

// posts
$items = get_posts([
    'post_type' => 'activities',
    'numberposts' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => [
        [
            'taxonomy' => 'activity-types',
            'field' => 'term_id',
            'terms' => $category->term_id,
        ]
    ],
]);

$related_associations = [];
foreach ($items as $item) {
    $obj = get_field('associations', $item->ID);
    if (is_array($obj) && $obj[0] && !isset($related_associations[$obj[0]->ID])) {
        $related_associations[$obj[0]->ID] = $obj[0];
    }
}
@endphp

@section('content')
@include('components.single-hero', [
    'back' => [
        'url' => '/activites',
        'title' => 'Activités',
    ],
    'fullscene' => true,
    'color' => $color,
    'image' => $image,
    'icon' => $icon,
    'title' => [
        'primary' => 'Activités',
        'secondary' => $category->name,
    ],
])


<section class="grid grid-cols-12">
<div class="col-span-12 lg:col-span-4 relative flex justify-start lg:justify-center py-5 px-5 pt-24 pb-28 lg:py-10 lg:px-0 lg:pt-24 lg:pb-28 text-white" style="background-color: {{ $color }};">

    <div class="w-full mx-auto max-w-xs">
        @if (count($related_associations))
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
        @endif
    </div>

</div>

<div class="col-span-12 lg:col-span-8 p-5 pt-24 pb-28 lg:p-10 lg:pl-16 lg:pr-20 lg:pt-24 lg:pb-28">

    <div class="max-w">
        <p class="max-w-lg mb-6 font-normal">Toutes les activités socio-culturelles se trouvent ici, Affine ta recherche en sélectionnant un dossier</p>

        @if ($items && count($items))
        <ul class="p-0 m-0 space-y-6">
            @foreach ($items as $item)
            <li>
            @include('components.card-post-activity', ['item' => $item])
            </li>
            @endforeach
        </ul>        
        @else
        <p>pas de posts</p>
        @endif
    </div>

</div>
</section>
@endsection