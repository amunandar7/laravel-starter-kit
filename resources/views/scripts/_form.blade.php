<?php
use App\Http\Forms\Fields\Types;

$js  = [];
$css = [];
foreach ($form->getFields() AS $name => $input) {
    if (in_array($input->getType(), [Types::DATEPICKER, Types::TIMEPICKER, Types::HOURPICKER, Types::DATETIMEPICKER])) {
        $js['moment']      = 'vendors/js/moment.js';
        $css['datepicker'] = 'vendors/datetimepicker/bootstrap-datetimepicker.css';
        $js['datepicker']  = 'vendors/datetimepicker/bootstrap-datetimepicker.js';
    } else if ($input->getType() == Types::SELECT2) {
        $css['select2'] = 'vendors/css/select2.css';
//        $js['select2']  = 'vendors/select2/dist/js/select2.min.js';
    } else if ($input->getType() == Types::CKEDITOR) {
        $js['ckeditor'] = 'vendors/ckeditor-4.11.4/ckeditor.js';
    }
}
?>

@push('css')
@foreach($css AS $url)
<link href="{{asset($url)}}" rel="stylesheet" />
@endforeach
@endpush

@push('scripts')
@foreach($js AS $url)
<script src="{{asset($url)}}"></script>
@endforeach
@endpush

@foreach($form->getFields() AS $name => $input)
@if(in_array($input->getType(), [Types::IMAGE, Types::DATETIMEPICKER, Types::DATEPICKER, Types::TIMEPICKER, Types::HOURPICKER, Types::SELECT2, Types::CKEDITOR]))
@include('scripts/_'.$input->getType())
@endif
@endforeach