{{--
  Template Name: Map Template
--}}
@php
    $wave = 'no';
    // dd($places);
    // dd($actitiesType);
@endphp
@extends('layouts.app')

@section('content')
<section class="map-wrapper">
  
  <div class="side-wrapper">

    <div class="side-search px-10">
      <h3 class="mb-0">Activités et lieu sur la map</h3>
      <input class="mt-6" id="search-map" type="text" placeholder="Entrez votre recherche">

      @if (isset($actitiesType) && $actitiesType && count($actitiesType))
      <label class="block mt-3" for="activities-map">Types d'activités</label>
      <select id="activities-map" class="select mt-2">
        <option data-placeholder="true">Sélectionnez une activitée</option>
        @foreach ($actitiesType as $item)
        <option value="{{ $item->term_id }}">{{ $item->name }}</option>
        @endforeach
      </select>
      @endif
    </div>

    <ul class="side-list">
      @foreach ($places as $item)
      @php
          $terms = get_the_terms($item->ID, 'activity-types');
          $lat = get_field('lat', $item);
          $lgt = get_field('lgt', $item);
          $phone = get_field('phone', $item);
          $address = get_field('address', $item);
          // dd($lat, $lgt, $phone, $address);
      @endphp
      <li class="side-list-item visible"
          data-post-id="{{ $item->ID }}"
          data-search="@if (isset($terms) && $terms && count($terms))
                         @foreach ($terms as $term)
                         {{ $term->term_id }}@if($loop->index !== count($terms) -1),@endif
                         @endforeach
                       @endif">
        @if ($item->post_type == 'places')
            <p class="mb-4">Lieu</p>
        @elseif ($item->post_type == 'activities')
            <p class="mb-4">Activitée</p>
        @endif

          @if (isset($terms) && $terms && count($terms))
          <ul class="flex flex-wrap items-center p-0 m-0 mb-4">  
            @foreach ($terms as $term)
            <li><a class="btn btn-basic btn-primary mr-4" href="{{ get_term_link($term) }}">{{ $term->name }}</a></li>
            @endforeach
          </ul>
          @endif

          <div class="flex flex-row justify-between items-end">
            <div>
            @if ($phone)
              <p class="m-0">{{ $phone }}</p>
            @endif
            @if (isset($address['street']) && $address['street'])
            <p class="m-0">{{ $address['street'] }}</p>
            @endif
            @if (isset($address['city']) && $address['city'])
            <p class="m-0">{{ $address['city'] }}</p>
            @endif
            </div>

            @if ($lat && $lgt)
            <button class="openpopup" data-item-id="marker_{{ $item->ID }}">Plus d’infos +</button>
            @endif
          </div>
      </li>
      @endforeach
    </ul>
  </div>

  <div class="side-map">
    <div id="map">
      <div class="flex justify-center items-center w-full h-full">
        <p>no data ...</p>
      </div>
    </div>
    <div id="map-infos">
      <span id="map-infos-overlay"></span>
      <div id="map-infos-wrapper">
        <div id="map-infos-box">
          <button id="close-map-infos">fermer <span class="close-icon"></span></button>
          <div id="map-infos-content"></div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection