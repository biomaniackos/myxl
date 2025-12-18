@if (isset($composer) && !empty($composer))
@php
    $first = false;
@endphp
@foreach ($composer as $item)

    @php
        if ($loop->index === 0) {
            $first = true;
        }
    @endphp

    @if ($item['acf_fc_layout'] === 'news')
    @include('components.widgets-news', ['item' => $item, 'first' => $first])

    @elseif($item['acf_fc_layout'] === 'activities')
    @include('components.widgets-activities', ['item' => $item, 'first' => $first])

    @elseif($item['acf_fc_layout'] === 'map')
    @include('components.widgets-map', ['item' => $item, 'first' => $first])

    @elseif($item['acf_fc_layout'] === 'marquee')
    @include('components.widgets-marquee', ['item' => $item, 'first' => $first])

    @elseif($item['acf_fc_layout'] === 'video')
    @include('components.widgets-video', ['item' => $item, 'first' => $first])

    @elseif($item['acf_fc_layout'] === 'text__image')
    @include('components.widgets-text__image', ['item' => $item, 'first' => $first])

    @elseif($item['acf_fc_layout'] === 'form')
    @include('components.widgets-form', ['item' => $item, 'first' => $first])

    @endif

@endforeach
@endif