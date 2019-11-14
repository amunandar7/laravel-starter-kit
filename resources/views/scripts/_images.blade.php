@push('scripts')
<script>
    $('[data-click="default"]').live('click', function () {
        var uuid = $(this).attr('data-uuid');
        swal({
            title: "Are you sure?",
            text: "set this image as default?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-primary",
            confirmButtonText: "Yes, set as default!",
            cancelButtonText: "No, cancel!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            method: 'POST',
                            url: '{{url(url()->current())}}/default',
                            data: {_token: '{{csrf_token()}}', uuid: uuid}
                        }).done(function (result) {
                            location.reload();
                        });
                    }
                });
    });
    $('[data-click="delete"]').live('click', function () {
        var uuid = $(this).attr('data-uuid');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            method: 'POST',
                            url: '{{url(url()->current())}}/delete',
                            data: {_token: '{{csrf_token()}}', uuid: uuid}
                        }).done(function (result) {
                            location.reload();
                        });
                    }
                });
    });
    $("#newImage").on("change", function (ev) {
        $("#imageForm").submit();
    });
</script>
@endpush