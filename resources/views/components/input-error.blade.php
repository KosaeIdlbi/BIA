<div style="color: red">
    @if ($errors->has($input))
        @foreach ($errors->get($input) as $error)
            {{ $error }}<br>
        @endforeach
    @endif
</div>
