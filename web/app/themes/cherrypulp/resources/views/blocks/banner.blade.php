<x-banner
    classes="{{ $block->classes }} {{ $block->preview ? 'pointer-events-none' : '' }}"
    :message="$message"
    :options="['actions' => $actions, 'closable' => $closable, 'style' => 'toast']"
    :type="$type"
/>
