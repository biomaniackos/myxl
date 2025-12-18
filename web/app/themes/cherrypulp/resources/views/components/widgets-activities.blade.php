@php
    $activities = get_terms(array(
        'taxonomy' => 'activity-types',
        'hide_empty' => false,
        'orderby' => 'meta_value_num',
        'meta_query' => [[
            'key' => 'order',
            'type' => 'NUMERIC',
        ]],
    ));
@endphp
@if ($activities && count($activities))
<section @if(isset($first) && $first) id="page" @endif class="widget-activities py-32">
<div class="relative z-10 container-wide items-center grid grid-cols-12 gap-4">

    <div class="col-span-12 flex justify-between items-start">
        @if ($item['title'])
        <h2>{!! $item['title'] !!}</h2>
        @endif

        @if (isset($item['button']) && !empty($item['button']) && $item['button']['url'])  
        <a href="{{ $item['button']['url'] }}" class="btn btn-basic btn-primary" target="{{ $item['button']['target'] }}">{{ $item['button']['title'] ? $item['button']['title'] : 'Voir tout' }}</a>
        @endif
    </div>

    <div class="col-span-12 grid-cols-12 grid gap-4 mt-6">
        @php
            $duration = 500;
        @endphp
        @foreach ($activities as $activity)
            <div class="col-span-12 sm:col-span-6 lg:col-span-4"
                 data-aos="fade-up"
                 data-aos-duration="{{ $duration }}">
                <div class="max-w-sm md:max-w-none mx-auto">
                @include('components.card-activity', ['item' => $activity])
                </div>
            </div>
            @php
                $duration =  $duration + 200;
            @endphp
        @endforeach
    </div>

</div>
<div class="elem-scene">
    {{-- cube(s) --}}
    <img src="@asset('images/elem-cube-3.png')" data-depth="0.2" class="elem_cube-01 absolute" alt="">
    {{-- triangle(s) --}}
    <img src="@asset('images/elem-triangle-2.png')" data-depth="0.4" class="elem_triangle-01 absolute" alt="">
</div>
</section>
@endif