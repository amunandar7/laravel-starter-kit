@push('scripts')
<script>
    $('#{{$name}}').datetimepicker({
        format : 'YYYY-MM-DD',
        <?= (array_key_exists('minDate', $input->getOptions())) ? 'minDate : "'.$input->getOptions()['minDate'].'",' : '' ?>
        <?= (array_key_exists('maxDate', $input->getOptions())) ? 'maxDate : "'.$input->getOptions()['maxDate'].'",' : '' ?>
        <?= (array_key_exists('viewMode', $input->getOptions())) ? 'viewMode : "'.$input->getOptions()['viewMode'].'",' : '' ?>
        <?= (array_key_exists('daysOfWeekDisabled', $input->getOptions())) ? 'daysOfWeekDisabled : '.$input->getOptions()['daysOfWeekDisabled'].',' : '' ?>
        icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-calendar-o',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        },
        showClear: true,
        ignoreReadonly: true
    }).data('DateTimePicker').date("{{$input->getValue()}}");
</script>
@endpush