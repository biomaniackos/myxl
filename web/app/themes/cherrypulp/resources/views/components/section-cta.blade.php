{{--
@example
<x-section-cta
    title="This is a test"
    content="This is a test! <a href=''>something</a>"
    style="rounded"
></x-section-cta>

@example
<x-section-cta
    image="https://images.unsplash.com/photo-1525130413817-d45c1d127c42?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1920&q=60&blend=6366F1&sat=-100&blend-mode=multiply"
    title="This is a test"
>
    This is a test! <a href=''>something</a>
</x-section-cta>
--}}
<div class="section-cta {{ $classes }}" style="background-image: url({{ $image }})">
    <div class="section-cta-wrapper">
        <h2 class="section-cta-title">
            {{ $title }}
        </h2>
        @if(!empty($content))
            <div class="section-cta-body">
                {!! $content !!}
            </div>
        @else
            <div class="section-cta-body">
                {!! $slot !!}
            </div>
        @endif
        @isset($actions)
            {!! $actions !!}
        @else
            <div class="mt-8 flex justify-center">
                @foreach ($options['actions'] as $action)
                    <div class="inline-flex">
                        <a href="{{ $action['url'] }}" class="btn {{ $action['classes'] }}">
                            {{ $action['title'] }}
                        </a>
                    </div>
                @endforeach
            </div>
        @endisset
    </div>
</div>
