<div style="color: {{ $color }}">
    @if (session("$name"))
        {{ session("$name") }}<br>
    @endif
</div>
