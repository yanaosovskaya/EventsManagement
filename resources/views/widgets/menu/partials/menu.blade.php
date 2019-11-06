@php
/**
* @var $menu \App\Models\MenuItem[]
**/
@endphp

@if($menu)
    <ul class="navbar-nav {{ $side === 'right' ? 'ml-auto' : 'mr-auto' }}">
        @foreach($menu as $item)
            @switch($item->visible)
                @case(\App\Models\MenuItem::VISIBLE_NOT_LOGGED)
                    @guest
                        @include('widgets.menu.partials.item', ['item' => $item])
                    @endguest
                @break

                @case(\App\Models\MenuItem::VISIBLE_LOGGED)
                    @auth
                        @include('widgets.menu.partials.item', ['item' => $item])
                    @endauth
                @break

                @case(\App\Models\MenuItem::VISIBLE_YES)
                    @include('widgets.menu.partials.item', ['item' => $item])
                @break

                @default

            @endswitch

        @endforeach
    </ul>
@endif
