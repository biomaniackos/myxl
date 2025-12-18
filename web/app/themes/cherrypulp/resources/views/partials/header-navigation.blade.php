<popover class="header-navigation" v-slot="{ open }">
    <div class="relative z-20">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-4 py-5 sm:px-6 sm:py-4 lg:px-8 md:justify-start md:space-x-10">
            <div>
                <a href="{{ home_url('/') }}" class="flex">
                    @if ($identity['logo'])
                        @php
                            $image = App\get_image($identity['logo']);
                        @endphp
                        <span class="sr-only">{{ $siteName }}</span>
                        <img class="h-8 w-auto sm:h-10" src="{{ $image['url'] }}" alt="{{ $image['alt'] ?? $siteName }}">
                    @else
                        {{ $siteName }}
                    @endif
                </a>
            </div>

            <div class="-mr-2 -my-2 md:hidden">
                <popover-button
                    aria-expanded="false"
                    class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                >
                    <span class="sr-only">Open menu</span>
                    <!-- Heroicon name: outline/menu -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </popover-button>
            </div>

            <div class="hidden md:flex-1 md:flex md:items-center md:justify-between">
                @if ($primary_navigation)
                    <nav class="flex space-x-10" role="navigation" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
                        @foreach ($primary_navigation as $item)
                            @if ($item['fields']['item_type'] === 'flyout_columns')
                                <div class="flyout">
                                    <!-- Item active: "text-gray-900", Item inactive: "text-gray-500" -->
                                    <button class="flyout-toggle" type="button" aria-expanded="false">
                                        <span>{{ $item['title'] }}</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>

                                    @if (!empty($item['children']))
                                        <div class="flyout-menu">
                                            @php
                                                $blocks = collect($item['children'])->filter(function ($child) {
                                                    return $child->fields['item_type'] === 'flyout_block';
                                                })->all();
                                            @endphp
                                            @if (count($blocks) > 0)
                                                <div class="flyout-blocks">
                                                    @foreach ($blocks as $child)
                                                        <a href="{{ $child->url }}" class="flyout-card">
                                                            <div>
                                                                <div class="flyout-card-content">
                                                                    <div>
                                                                        <p class="text-base font-bold text-gray-900">
                                                                            {{ $child->title }}
                                                                        </p>
                                                                        <p class="mt-1 text-sm text-gray-500">
                                                                            {{ $child->description }}
                                                                        </p>
                                                                    </div>
                                                                    <p class="mt-2 text-sm font-medium text-indigo-600 lg:mt-4">
                                                                        {{ $child->fields['cta'] }} <i class="fal fa-long-arrow-right" aria-hidden="true"></i>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @php
                                                $links = collect($item['children'])->filter(function ($child) {
                                                    return $child->fields['item_type'] === 'link';
                                                })->all();
                                            @endphp
                                            @if (count($links) > 0)
                                                <div class="flyout-links">
                                                    <div>
                                                        @foreach ($links as $child)
                                                            <div class="flow-root">
                                                                <a href="{{ $child->url }}" class="flyout-link">
                                                                    {{ $child->title }}
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @elseif ($item['fields']['item_type'] === 'dropout')
                                <div class="dropout">
                                    <!-- Item active: "text-gray-900", Item inactive: "text-gray-500" -->
                                    <button type="button" class="dropout-toggle" aria-expanded="false">
                                        <span>{{ $item['title'] }}</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>

                                    @if (!empty($item['children']))
                                        <div class="dropout-menu">
                                            <div>
                                                <div class="relative grid gap-6 bg-white px-5 py-8 sm:gap-8 sm:p-8">
                                                    @foreach ($item['children'] as $child)
                                                        <a href="{{ $child->url }}">
                                                            <p class="m-0 text-base font-medium text-gray-900">
                                                                {{ $child->title }}
                                                            </p>
                                                            @if ($child->description)
                                                                <p class="mt-1 mb-0 text-sm text-gray-500">
                                                                    {{ $child->description }}
                                                                </p>
                                                            @endif
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @elseif ($item['fields']['item_type'] === 'link')
                                <a href="{{ $item['url'] }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                                    {{ $item['title'] }}
                                </a>
                            @endif
                        @endforeach
                    </nav>
                @endif

                @if ($secondary_navigation)
                    <nav class="hidden md:flex items-center justify-end md:flex-1 lg:w-0" role="navigation" aria-label="{{ wp_get_nav_menu_name('secondary_navigation') }}">
                        @foreach ($secondary_navigation as $item)
                            <a href="{{ $item['url'] }}" class="ml-8 text-base font-medium text-gray-500 no-underline hover:text-gray-900">
                                {{ $item['title'] }}
                            </a>
                        @endforeach
                    </nav>
                @endif
            </div>
        </div>
    </div>

    <transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="translate-y-1 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-1 opacity-0"
    >
        <div class="absolute top-0 z-20 inset-x-0 p-2 transition transform origin-top-right md:hidden" v-if="open">
            <popover-panel class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50" static>
                <div class="pt-5 pb-6 px-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow">
                        </div>
                        <div class="-mr-2">
                            <popover-button
                                class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                                type="button"
                            >
                                <span class="sr-only">Close menu</span>
                                <!-- Heroicon name: outline/x -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </popover-button>
                        </div>
                    </div>
                </div>
                <div class="py-6 px-5">
                    @if ($primary_navigation)
                        <div class="grid gap-4">
                            @foreach ($primary_navigation as $item)
                                @if ($item['fields']['item_type'] === 'flyout_columns')
                                    <div class="text-gray-500 bg-white rounded-md inline-flex items-center text-base font-medium">
                                        {{ $item['title'] }}
                                    </div>
                                    @if (!empty($item['children']))
                                        @php
                                            $blocks = collect($item['children'])->filter(function ($child) {
                                                return $child->fields['item_type'] === 'flyout_block';
                                            })->all();
                                        @endphp
                                        @if (count($blocks) > 0)
                                            @foreach ($blocks as $child)
                                                <a class="no-underline -m-3 p-3 hover:bg-gray-100" href="{{ $child->url }}">
                                                    <div>
                                                        <p class="text-base font-bold text-gray-900">
                                                            {{ $child->title }}
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            {{ $child->description }}
                                                        </p>
                                                    </div>
                                                    <p class="mb-0 mt-2 text-sm font-medium text-indigo-600 lg:mt-4">
                                                        {{ $child->fields['cta'] }} <i class="fal fa-long-arrow-right" aria-hidden="true"></i>
                                                    </p>
                                                </a>
                                            @endforeach
                                        @endif

                                        @php
                                            $links = collect($item['children'])->filter(function ($child) {
                                                return $child->fields['item_type'] === 'link';
                                            })->all();
                                        @endphp
                                        @if (count($links) > 0)
                                            @foreach ($links as $child)
                                                <a href="{{ $child->url }}" class="-m-3 p-3 flex items-center rounded-md text-base font-medium text-gray-900 no-underline hover:bg-gray-100">
                                                    {{ $child->title }}
                                                </a>
                                            @endforeach
                                        @endif
                                    @endif
                                @elseif ($item['fields']['item_type'] === 'dropout')
                                    <div class="text-gray-500 bg-white rounded-md inline-flex items-center text-base font-medium">
                                        {{ $item['title'] }}
                                    </div>
                                    @if (!empty($item['children']))
                                        @foreach ($item['children'] as $child)
                                            <a class="no-underline -m-3 p-3 hover:bg-gray-100" href="{{ $child->url }}">
                                                <p class="m-0 text-base font-medium text-gray-900">
                                                    {{ $child->title }}
                                                </p>
                                                @if ($child->description)
                                                    <p class="mt-1 mb-0 text-sm text-gray-500">
                                                        {{ $child->description }}
                                                    </p>
                                                @endif
                                            </a>
                                        @endforeach
                                    @endif
                                @elseif ($item['fields']['item_type'] === 'link')
                                    <a href="{{ $item['url'] }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                                        {{ $item['title'] }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    @if ($secondary_navigation)
                        <div class="grid gap-4 mt-6">
                            @foreach ($secondary_navigation as $item)
                                <a href="{{ $item['url'] }}" class="text-base font-medium text-gray-500 no-underline hover:text-gray-900">
                                    {{ $item['title'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </popover-panel>
        </div>
    </transition>
</popover><!-- /.header-navigation -->
