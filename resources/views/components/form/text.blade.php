<div class="form-group row">
    {{ Form::label($label ?? $name, null, ['class' => 'col-sm-4 col-form-label text-md-right']) }}

    <div class="col-md-6">
        {{ Form::text($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}
    </div>
</div>
