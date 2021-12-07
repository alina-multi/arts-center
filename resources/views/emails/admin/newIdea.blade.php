New feedback posted:
<h1>{{$idea->title}}</h1>
@php
    echo (new \nadar\quill\Lexer($idea->body))->render();
@endphp