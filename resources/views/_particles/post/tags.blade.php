@if($tags && get_buzzy_config('ShowTags') !== 'no')
<div class="content-tags hide-mobiles">
    @foreach($tags as $tag)
    <span class="tagy"><a href="{{ route('tag.show', ['tag' => $tag->slug]) }}">{{$tag->name}}</a></span>
    @endforeach
</div>
@endif
