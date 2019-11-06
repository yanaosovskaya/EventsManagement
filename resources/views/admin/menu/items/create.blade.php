<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ trans('menu.item.items') }}</div>

            <div class="card-body">
                <menu-tabs
                        :has-page-module="{{ $hasPageModule ? 'true' : 'false' }}"
                        :menu-id="{{ $menu->id }}"
                        :types="{{ json_encode(array_keys(\App\Models\MenuItem::$types)) }}"
                        :items="{{ json_encode($items) }}"
                        :pages="{{ json_encode($pages) }}"
                        :visible-statuses="{{ json_encode(\App\Models\MenuItem::visibilityStatuses()) }}"
                        :visible-default="{{ \App\Models\MenuItem::VISIBLE_YES }}"
                        :prev="{{ $menu->id }}"
                >

                </menu-tabs>
            </div>
        </div>
    </div>
</div>
