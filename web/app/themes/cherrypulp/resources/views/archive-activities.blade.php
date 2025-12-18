@extends('layouts.app')

@php
    $hero = null;
    if ($options['hero']) $hero = $options['hero'];
    $composer = null;
    if ($options['composer']) $composer = $options['composer'];
@endphp

@section('content')
@include('components.widgets-hero', ['is_front' => false])
@if ($activities && count($activities))
<section class="widget-activities">
<div class="container-wide items-center grid grid-cols-12 gap-4">

    <div class="col-span-12 flex justify-between items-start">
        @if ($options['title'])
            <h2>{!! $options['title'] !!}</h2>
        @endif
    </div>

    <div class="col-span-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
        @foreach ($activities as $activity)
            @include('components.card-activity', ['item' => $activity])
        @endforeach
    </div>

</div>
</section>
@endif
@include('components.composer')
@endsection
