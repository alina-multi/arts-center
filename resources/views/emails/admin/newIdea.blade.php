New feedback posted:
<h1>{{$idea->title}}</h1>
@php
    echo new \nadar\quill\Lexer($idea->body)->render();
@endphp
<br>
<a href="https://arts.center/nova/resources/feedback">Validate it on admin page</a>