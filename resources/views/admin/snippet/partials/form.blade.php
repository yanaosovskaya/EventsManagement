@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<label for="">{{ trans('snippet.fields.name') }}</label>
<input type="text" class="form-control" name="name" placeholder="{{ trans('snippet.fields.name') }}" value="{{ old('name', $snippet ? $snippet->name : "") }}" autofocus required>

<label for="">{{ trans('snippet.fields.content') }}</label>
<textarea rows="5" class="form-control" name="content" placeholder="{{ trans('snippet.fields.content') }}" required>{{ old('content', $snippet ? $snippet->content : "") }}</textarea>

<label for="">{{ trans('snippet.fields.location') }}</label>
<select class="form-control" name="location">
    @foreach(\App\Models\Snippet::locationStatuses() as $key => $value)
        <option value="{{ $key }}"
                {{ old('location', $snippet && ($snippet->location == $key)) ? 'selected' : '' }}>
            {{ $value }}
        </option>
    @endforeach
</select>

<snippet-visible
        page-on="{{ \App\Models\Snippet::VISIBLE_ON_PAGES }}"
        page-not="{{ \App\Models\Snippet::VISIBLE_NOT_PAGES }}"
        :show-slugs="{{ $snippet && ($snippet->visible == \App\Models\Snippet::VISIBLE_ON_PAGES || $snippet->visible == \App\Models\Snippet::VISIBLE_NOT_PAGES) ? 'true' : 'false' }}"
        start-visible = {{ empty($snippet) ? '1' : $snippet->visible }}
        inline-template>
    <div>
        <label for="">{{ trans('snippet.fields.visible') }}</label>
        <select class="form-control" name="visible" @change="ChangeVisible" v-model="visible">
            @foreach(\App\Models\Snippet::visibilityStatuses() as $key => $value)
                <option value="{{ $key }}"
                        {{ old('visible', (empty($snippet) && $key == \App\Models\Snippet::VISIBLE_ALL_PAGES) ? 'selected' : $snippet && ($snippet->visible == $key)) ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>

        <div v-if="showSlugs">
            <hr>

            <label for="">{{ trans('snippet.slugs') }}</label>
            <select size="10" class="form-control" name="slugs[]" multiple>
                @foreach($slugs as $slug)
                    <option value="{{ $slug->id }}"
                            {{ old('slug', $snippet && $snippet->slugs->contains('id', $slug->id)) ? 'selected' : '' }}>
                        {{ $slug->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</snippet-visible>
