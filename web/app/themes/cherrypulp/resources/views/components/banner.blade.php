{{--
@example
<x-banner
    message="This is a test! <a href=''>something</a>"
    type="info"
></x-banner>

@example
<x-banner
    type="info"
    :options="['style'=>'toast']"
>
    This is a test! <a href=''>something</a>
</x-banner>

@example
<x-banner
    type="info"
    :options="['style'=>'toast']"
>
    This is a test! <a href="#">something</a>

    <x-slot name="actions">
        <div class="order-3 mt-2 flex-shrink-0 w-full sm:order-2 sm:mt-0 sm:w-auto sm:ml-3">
            <a href="#" class="banner-button">
                Something else
            </a>
        </div>
    </x-slot>
</x-banner>
--}}
<div class="banner banner-{{ $type }} banner-{{ $options['style'] }}">
    <div class="banner-wrapper">
        <div class="flex items-center justify-between flex-wrap">
            <div class="flex flex-1 items-center">
                <span class="banner-icon">
                    <i class="far fa-{{ $options['icon'] }}" aria-hidden="true"></i>
                </span>
                <span class="banner-message">
                    @if(!empty($message))
                        {!! $message !!}
                    @else
                        {!! $slot !!}
                    @endif
                </span>
            </div>
            @isset($actions)
                {!! $actions !!}
            @else
                @foreach ($options['actions'] as $action)
                    <div class="order-3 mt-2 flex-shrink-0 w-full sm:order-2 sm:mt-0 sm:w-auto sm:ml-3">
                        <a href="{{ $action['url'] }}" class="btn {{ $action['classes'] }}">
                            {{ $action['title'] }}
                        </a>
                    </div>
                @endforeach
            @endisset
            @if ($options['closable'])
                <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-3">
                    <button type="button" class="banner-close">
                        <span class="sr-only">{{ __('Dismiss') }}</span>
                        <i class="far fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
