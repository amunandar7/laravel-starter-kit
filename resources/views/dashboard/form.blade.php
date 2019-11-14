@extends('layouts.dashboard')
@section('title', $title)
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $title }}</h4>
            {!! form_start($form, ["class" => "form-horizontal"]) !!}
            @foreach($form->getFields() AS $field => $input)
            <div class="form-group {{ $errors->has($field) ? 'has-error' : ''}}">
                @if($input->getType() == "hidden")
                {!! form_widget($form->$field) !!}
                @else
                <div class="control-label col-md-3 col-sm-3">
                    {!! form_label($form->$field) !!}
                    {!! (array_key_exists("rules", $input->getOptions()) && is_string($input->getOptions()['rules']) && strpos($input->getOptions()['rules'], 'required') !== false) ? '<span style="color:red">*</span>' : '' !!}
                </div>
                @if(array_key_exists("inline", $input->getOptions()) && $input->getOptions()['inline'] == true)

                @else
                <div class="col-md-9 col-sm-9">
                    @endif
                    {!! form_widget($form->$field) !!}
                    @if($errors->has($field))
                    <span class="help-block">{{$errors->first($field)}}</span>
                    @endif
                    @if(array_key_exists("inline", $input->getOptions()) && $input->getOptions()['inline'] == true)

                    @else
                </div>
                @endif
                @endif
            </div>
            @endforeach
            <div class="form-group">
                <label class="control-label col-md-2 col-sm-2"></label>
                <div class="col-md-2 col-sm-10">
                    <button type="submit" class="btn btn-seehat">Submit</button>
                </div>
            </div>
            {!! form_end($form) !!}
        </div>
    </div>
</div>
@include('scripts/_form')
@endsection
