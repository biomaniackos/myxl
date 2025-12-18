{{--
@example
<x-alert
    message="This is a test! <a href=''>something</a>"
    type="info"
></x-alert>

@example
<x-alert
    type="info"
    :options="['closable' => false]"
>
    This is a test! <a href="#">something</a>

    <x-slot name="actions">
        <a href="#" class="alert-button">
            Something else
        </a>
    </x-slot>
</x-alert>
@TODO - replace with https://tailwindui.com/components/application-ui/overlays/notifications
--}}
<div class="alert alert-{{ $type }}">
    <div class="alert-wrapper">
        <div class="alert-icon">
            <i class="far fa-{{ $options['icon'] }}" aria-hidden="true"></i>
        </div>
        <div class="alert-message">
            @if(!empty($message))
                {!! $message !!}
            @else
                {!! $slot !!}
            @endif
            @isset($actions)
                {!! $actions !!}
            @else
                @foreach ($options['actions'] as $action)
                    <a href="{{ $action['url'] }}" class="btn {{ $action['classes'] }}">
                        {{ $action['title'] }}
                    </a>
                @endforeach
            @endisset
        </div>
        @if ($options['closable'])
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button type="button" class="alert-close">
                        <span class="sr-only">{{ __('Dismiss') }}</span>
                        <i class="far fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
