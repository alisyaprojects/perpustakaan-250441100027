@if (session('status'))
    <div class="flash">{{ session('status') }}</div>
@endif
@if ($errors->any())
    <div class="flash flash-error">
        @foreach ($errors->all() as $e)
            <div>{{ $e }}</div>
        @endforeach
    </div>
@endif