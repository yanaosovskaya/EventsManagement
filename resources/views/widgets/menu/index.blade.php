<nav class="navbar {{ $class }}">
    <div class="container">
        <a href="{{ $brand['url'] }}" class="navbar-brand">{{ $brand['name'] }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @include('widgets.menu.partials.menu', ['menu' => $menu])
        </div>
    </div>
</nav>
