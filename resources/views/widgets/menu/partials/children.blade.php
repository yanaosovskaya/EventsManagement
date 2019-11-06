@php
    /**
    * @var $items \App\Models\MenuItem
    **/
@endphp

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ $item->name }}
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        @foreach($item->children as $model)
            @if ($model->children->isNotEmpty())
                @include('widgets.menu.partials.children', ['item' => $item])
            @else
                @switch($model->type)
                    @case(\App\Models\MenuItem::TYPE_LINK)
                        <a class="dropdown-item" href="{{ $model->content }}">{{ $model->name }}</a>
                    @break

                    @case(\App\Models\MenuItem::TYPE_TEXT)
                        <span class="dropdown-item">{{ $model->name }}</span>
                    @break

                    @case(\App\Models\MenuItem::TYPE_PAGE)
                        @if($hasPageModule && $item->page)
                            <a class="dropdown-item" href="/{{ $model->page->slug }}">{{ $model->name }}</a>
                        @endif
                    @break
                @endswitch

            @endif
        @endforeach
    </div>
</li>
