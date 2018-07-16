@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('layouts.parts.validation-errors')
                @include('layouts.parts.success-message')

                <div class="card">
                    <div class="card-header">{{ __('Edit your profile') }}</div>

                    <div class="card-body">
                        {!! Form::model($user, ['route' => ['profile.update', $user->id], 'method' => 'patch']) !!}
                            {!! Form::bsText('name', null, __('Name'), ['autocomplete' => 'off', 'required']) !!}
                            {!! Form::bsText('email', null, __('E-mail Address'), ['autocomplete' => 'off', 'required']) !!}

                            {!! Form::bsSubmit(__('Save')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
