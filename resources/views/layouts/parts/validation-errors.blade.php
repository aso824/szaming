@if(session()->has('errors'))
    <div class="alert alert-danger alert-dismissible">
        {{ __('An error(s) occured:') }}

        <ul>
            @foreach(session('errors')->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
