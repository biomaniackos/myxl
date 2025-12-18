<{{ $tag }} class="{{ $block->classes }}">
    <div {!! strpos($block->classes, 'alignfull') !== 0 ? 'class="container"' : '' !!}>
        <InnerBlocks />
    </div>
</{{ $tag }}>
