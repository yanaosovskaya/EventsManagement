@php
    /**
    * @var $item \App\Models\MenuItem
    **/
@endphp

@if($item->type == \App\Models\MenuItem::TYPE_CUSTOM_HTML)
    @php
        $content = \App\Services\MenuItem::bladeCompile($item->content)
    @endphp

    {!! $content !!}
@elseif ($item->children->isNotEmpty())
    @include('widgets.menu.partials.children', ['item' => $item])
@else
    <li class="nav-item">
        @switch($item->type)
            @case(\App\Models\MenuItem::TYPE_LINK)
            <a class="nav-link" href="{{ $item->content }}">{{ $item->name }}</a>
            @break

            @case(\App\Models\MenuItem::TYPE_TEXT)
            <span class="nav-link">{{ $item->name }}</span>
            @break

            @case(\App\Models\MenuItem::TYPE_PAGE)
            @if($hasPageModule && $item->page)
                <a class="nav-link" href="/{{ $item->page->slug }}">{{ $item->name }}</a>
            @endif
            @break
        @endswitch
    </li>
@endif
