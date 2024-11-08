<span class="flex gap-1">
@foreach($works as $work)
    <a href="{{route('nova.pages.detail', ['works', $work->id])}}"><img class="" src="{{$work->preview?->src}}" style="max-height: 32px;"></a>
@endforeach
</span>