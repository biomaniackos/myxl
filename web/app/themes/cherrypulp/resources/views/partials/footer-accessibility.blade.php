<div class="footer-accessibility">
    @if ($menu_items)
        @foreach ($menu_items as $item)
            <div>
                <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                    {{ $item->title }}
                </h3>

                @if ($item->children)
                    <ul role="list" class="mx-0 mt-4 space-y-4">
                        @foreach ($item->children as $child)
                            <li>
                                <a class="text-base text-gray-300 hover:text-white" href="{{ $child->url }}">
                                    {{ $child->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    @endif

    @if ($menu_languages && $menu_languages['active'])
        <div>
            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                {{ __('Language') }}
            </h3>

            <div class="dropdown">
                <button class="dropdown-toggle" type="button" aria-expanded="false" aria-haspopup="true">
                    {{ $menu_languages['active']['native_name'] }}
                    <i class="fas fa-chevron-down -mr-1 ml-2 h-5 w-5"></i>
                </button>

                <div class="dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                        @foreach ($menu_languages['languages'] as $language)
                            <a class="text-gray-700 no-underline rounded-md block px-4 py-2 mx-1 text-sm hover:bg-gray-50" href="{{ $language['url'] }}" role="menuitem" tabindex="-1">
                                {{ $language['native_name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div><!-- /.footer-accessibility -->
