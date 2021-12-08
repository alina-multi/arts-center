New feedback posted:
<h1>{{$idea->title}}</h1>
<ul>
    @if($idea->title)
        <li>Type: {{$idea->title}}</li>
    @endif
    @if($idea->category)
        <li>Category: {{$idea->category}}</li>
    @endif
</ul>
@php
    if ($idea->body) {
        echo (new \nadar\quill\Lexer($idea->body))->render();
    }
@endphp