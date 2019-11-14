@extends('dashboard.baselayout')
@section('title', $title)
@section('subtitle', $subtitle)
@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">
            {{ $title }}
            @if($enable_add)
            <a href="{{url(str_replace("list","form",url()->current()))}}/create" class="btn btn-seehat pull-right">Tambah</a>
            @endif
        </h4>
        @if(sizeof($filters) > 0)
        <div class="row">
            @foreach($filters AS $idx => $data)
            <div class="col-12 col-sm-3">
                @if(!is_array($data[3]) && $data[3] == 'datepicker')
                <input id="dtFilter{{$idx}}" placeholder="{{$data[0]}}" class="form-control dt-datepicker" />
                @else
                <select id="dtFilter{{$idx}}" class="form-control dtFilter{{ is_array($data[3]) ? '' : ' select2Filter'}}">
                    <option value="">{{$data[0]}}</option>
                    @if(is_array($data[3]))
                    @foreach($data[3] AS $val => $text)
                    <option value="{{$val}}">{{$text}}</option>
                    @endforeach
                    @endif
                </select>
                @endif
            </div>
            @endforeach
        </div>
        <br>
        @endif
        <div class="table-responsive">
            <table  id="appTable" class="table table-striped">
                <thead>
                    <tr>
                        @foreach($columns AS $idx => $col)
                        @if(!in_array($idx, $hidden_columns))
                        <th>{{\App\Helpers\StringHelper::humanize($col)}}</th>
                        @endif
                        @endforeach
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalschedule" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="display:inline !important;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tabel Jadwal Dokter</h4>
            </div>
            <div class="modal-body">
                <table class="table table-stripped" id="jadwal-dokter">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Dari</th>
                            <th>Sampai</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-seehat" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('vendors//css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/datetimepicker/bootstrap-datetimepicker.css') }}">
@endpush


@push('scripts')
<script src="{{ asset('vendors/DataTables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendors/DataTables/media/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('vendors/DataTables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendors/js/moment.js') }}"></script>
<script src="{{ asset('vendors/datetimepicker/bootstrap-datetimepicker.js') }}"></script>

<script>
    $('#appTable').on('click', '.modal-schedule', function(){
        var value = $(this).data('value')
        
        $.ajax({
            url: "{{ url('schedule/get-all-schedule') }}/"+value,
            success: function(res) {
                var html = ''
                res.forEach(function(item) {
                    html += "<tr>" +
                                "<td>"+ item.hari.name +"</td>" +
                                "<td>"+ item.schedule_from +"</td>" +
                                "<td>"+ item.schedule_to +"</td>" +
                            "<tr>"
                })

                $('#jadwal-dokter > tbody').html(html)
            }
        })
    })
</script>

<script>
    var delay = (function(){
    var timer = 0;
    return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
    };
    })();
    var table = $('#appTable').DataTable({
    processing: true,
            serverSide: true,
            ajax: {
            url: '{{url(url()->current())}}/datatables',
                    data: function (d) {
                    d.dropdown_filter = [];
                    @foreach($filters AS $idx => $data)
                            d.dropdown_filter[{{ $idx }}] = $('#dtFilter{{ $idx }}').val();
                    @endforeach
                    }
            },
            columns: [
                    @foreach($columns AS $idx => $col)
                    @if (!in_array($idx, $hidden_columns))
            { data: '{{$col}}', name: '{{$table_db_columns[$idx]}}'{!! array_key_exists($idx, $attr_columns) ? ', '.$attr_columns[$idx] : '' !!} },
                    @endif
                    @endforeach
            { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
            ],
            order: [[ {{$default_order_by}}, "{{$default_order}}" ]]
            });
    $("#appTable_wrapper").removeClass('form-inline');
    $('.dtFilter').change(function() {
        refreshTable();
    });
    @foreach($filters AS $idx => $data)
    @if(!is_array($data[3]) && $data[3] != 'datepicker')
    $('#dtFilter{{$idx}}').select2({
        theme: "bootstrap",
        placeholder: "{{$data[0]}}",
        ajax: {
                url: "{{url('select2/'.$data[3])}}",
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
    });
    @endif
    @endforeach
    function refreshTable(){
        delay(function(){
        table.ajax.reload();
        }, 500 );
    }

    $('body').on('click', '[data-click="delete"]', function() {
    var id = $(this).attr('data-id');
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
            function(isConfirm) {
            if (isConfirm) {
            $.ajax({
            method: 'POST',
                    url: '{{url(str_replace("list","form",url()->current()))}}/delete',
                    data: {_token: '{{csrf_token()}}', id: id}
            }).done(function (result) {
            location.reload();
            });
            }
            });
    });

    $('.dt-datepicker').datetimepicker({
            format : 'YYYY-MM-DD',
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
        });

    $('.dt-datepicker').on('dp.change', function(){ refreshTable(); })

</script>
@endpush