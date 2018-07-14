@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ __(session('success')) }}
    </div>
@endif
