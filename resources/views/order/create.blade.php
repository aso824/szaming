@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('layouts.parts.validation-errors')
                @include('layouts.parts.success-message')

                <div class="card">
                    <div class="card-header">{{ __('Add new order') }}</div>

                    <div class="card-body">
                        {!! Form::open(['route' => 'order.store']) !!}
                            <div class="form-group row">
                                <div class="col-auto">
                                    {{ Form::label(__('Shop:'), null, ['class' => 'col-form-label']) }}
                                </div>

                                <div class="col">
                                    {{ Form::text('shop', '', ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <span class="h3">Positions:</span>
                            <hr>

                            <div id="orderPositions">
                                <div class="row form-group orderRow" data-row-id="0">
                                    <div class="col-lg-4">
                                        {!! Form::text('orders[0][name]', '', [
                                            'class' => 'form-control',
                                            'autocomplete' => 'off',
                                            'required',
                                            'placeholder' => __('Name'),
                                        ]) !!}
                                    </div>

                                    <div class="col">
                                        {!! Form::number('orders[0][price]', '', [
                                            'class' => 'form-control',
                                            'autocomplete' => 'off',
                                            'required',
                                            'placeholder' => __('Price'),
                                            'step' => '0.01',
                                            'min' => '0.00',
                                        ]) !!}
                                    </div>

                                    <div class="col">
                                        {!! Form::number('orders[0][quantity]', '', [
                                            'class' => 'form-control',
                                            'autocomplete' => 'off',
                                            'required',
                                            'placeholder' => __('Amount'),
                                            'step' => '1',
                                            'min' => '1',
                                        ]) !!}
                                    </div>

                                    <div class="col-lg-3">
                                        {!! Form::text('orders[0][people]', '', [
                                            'class' => 'form-control',
                                            'autocomplete' => 'off',
                                            'required',
                                            'placeholder' => __('People'),
                                        ]) !!}
                                    </div>

                                    <div class="col-auto">
                                        <a href="#"
                                           class="fa fa-2x fa-remove text-danger removeOrderPosition"
                                           style="line-height: 34px; visibility: hidden;"
                                           title="{{ __('Remove this position') }}"
                                        ></a>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                {!! Form::button(__('New position'), ['class' => 'btn btn-primary', 'id' => 'addOrderPosition']) !!}
                                {!! Form::submit(__('Save'), ['class' => 'btn btn-success']) !!}
                            </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
