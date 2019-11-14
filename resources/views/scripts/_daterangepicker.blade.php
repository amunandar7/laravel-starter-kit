@push('scripts')
<script>
$('.input-daterange').datepicker({
    format : 'yyyy/mm/dd',
    <?= (array_key_exists('startDate', $input->getOptions())) ? 'startDate : "'.$input->getOptions()['startDate'].'",' : '' ?>
    <?= (array_key_exists('endDate', $input->getOptions())) ? 'endDate : "'.$input->getOptions()['endDate'].'",' : '' ?>
    autoclose: true,
    todayHighlight: true
});
</script>
@endpush