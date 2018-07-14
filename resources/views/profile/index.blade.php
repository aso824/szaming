@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit your profile') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {!! Form::model($user, ['route' => ['profile.update', $user->id]]) !!}
                            {!! Form::bsText('name', null, __('Name')) !!}
                            {!! Form::bsText('email', null, __('E-mail Address')) !!}

                            {!! Form::bsSubmit(__('Save')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
