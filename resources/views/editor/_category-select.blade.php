<div class="category-input">
<select id="tagcats" class="demo-default" name="category" multiple placeholder="{{ trans('addpost.categories') }}">
    @foreach (\App\Category::byMain()->byLanguage(isset($post) ? $post->language : null)
        ->when(get_buzzy_config('EditorCategoriesFilter') !== 'no', function($q) use ($post_type){
            return $q->byType($post_type);
        })
        ->byActive()
        ->byOrder()
        ->get() as $category)
    <optgroup label="{{ $category->name }}">
        <option value="{{ $category->id }}" {{ isset($post) && $post->categories()->find($category->id) ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
        @foreach ($category->children()->byActive()->orderBy('name')->get() as $child_cat)
            <option value="{{ $child_cat->id }}" {{ isset($post) && $post->categories()->find($child_cat->id) ? 'selected' : '' }}>
                <b>{{ $category->name }}</b> / {{ $child_cat->name }}
            </option>
            @foreach ($child_cat->children()->byActive()->orderBy('name')->get() as $child2_cat)
            <option value="{{ $child2_cat->id }}" {{ isset($post) && $post->categories()->find($child2_cat->id) ? 'selected' : '' }}>
                <strong>{{ $category->name }}</strong> / <b>{{ $child_cat->name }}</b> / {{ $child2_cat->name }}
            </option>
            @endforeach
        @endforeach
    </optgroup>
    @endforeach
</select>
</div>
