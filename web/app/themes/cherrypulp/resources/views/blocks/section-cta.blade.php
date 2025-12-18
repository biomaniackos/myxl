<x-section-cta
    classes="{{ $block->classes }} {{ $block->preview ? 'pointer-events-none' : '' }}"
    :content="$content"
    :image="$image"
    :options="$options"
    :title="$title"
/>
