@extends('dashboard.baselayout')
@section('title', $title)
@section('subtitle', $subtitle)
@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"></h3>
            <div class="box-tools pull-right">
                <a href="{{url('list/'.$entityName)}}" class="btn btn-box-tool"><i class="fa fa-reply"></i> Back</a>
            </div>
        </div>
        <div class="box-body">
            {!! form_start($form) !!}
            <div class="row">
            @foreach($form->getFields() AS $field => $input)

                    <div class="col-xs-12">
                    <div class="form-group {{ $errors->has($field) ? 'has-error' : ''}}">
                    @if($input->getType() == "hidden")
                    {!! form_widget($form->$field) !!}
                    @else
                        {!! form_label($form->$field) !!}
                        {!! (array_key_exists("rules", $input->getOptions()) && is_string($input->getOptions()['rules']) && strpos($input->getOptions()['rules'], 'required') !== false) ? '<span style="color:red">*</span>' : '' !!}
                    @if(array_key_exists("inline", $input->getOptions()) && $input->getOptions()['inline'] == true)

                    @else
                        @endif
                        {!! form_widget($form->$field) !!}
                        @if($errors->has($field))
                        <span class="help-block">{{$errors->first($field)}}</span>
                        @endif
                        @if(array_key_exists("inline", $input->getOptions()) && $input->getOptions()['inline'] == true)

                        @else
                    @endif
                    @endif
                    </div>
                    </div>
            @endforeach
            <div class="col-xs-12">
            <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </div>
            </div>
            {!! form_end($form) !!}
        </div>
    </div>
@include('scripts/_form')
@endsection
