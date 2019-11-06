@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($packages as $item)
                @userCan($item['menu']['permission'])
                    <div class="col-lg-6">
                        <a href="{{ route($item['menu']['route']) }}"><h3>{{ ucfirst($item['module']) }}</h3></a>
                        <div>
                            @if (isset($item['dashboard']))
                                @foreach($item['dashboard'] as $k => $badge)
                                    <span>{{ $k }}</span> <span class="badge badge-pill badge-primary">{{ $badge }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endUserCan
            @endforeach
        </div>
    </div>
@endsection
