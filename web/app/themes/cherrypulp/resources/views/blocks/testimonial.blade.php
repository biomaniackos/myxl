<x-testimony
    classes="{{ $block->classes }} {{ $block->preview ? 'pointer-events-none' : '' }}"
    :image="$image"
    :logo="$logo"
    :quote="$quote"
    :options="$options"
    :role="$role"
    :title="$title"
    :type="$type"
/>
