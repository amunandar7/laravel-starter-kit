@push('scripts')
<script>
    $('#{{$name}}').select2({
        theme: "bootstrap",
        placeholder: "-",
        @if(array_key_exists('ajax', $input->getOptions()))
        ajax: {
                url: "{{url('select2/'.$input->getOptions()['ajax'])}}",
                dataType: "json",
                delay: 250,
                method: "get",
                data: function (params) {
                    return {
                        search: params.term,
                        page: params.page,
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: ((params.page * 10) < data.total)
                        }
                    };
                },
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            allowClear: true,
            minimumInputLength: 0
        @endif
    });
</script>
@endpush