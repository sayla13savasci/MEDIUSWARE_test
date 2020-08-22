@extends('layouts.app')
@section('content')
    <div class="container-fluid app-body">
        <h3>Recent Post Sent to Buffer</h3>
        <hr>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="controls">
                        <input class="form-control post_date" type="text" name="post_date" id="post_date" value=""/>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <select class="form-control" name="group_id">
                    <option value="" selected>Select a group</option>
                    @foreach($groups as $group)
                        <option value="{{$group->id}}">{{$group->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-4">
                <!--button-->
                <div class="text-left pl-4">
                    <button type="text" id="btnFiterSubmitSearch" class="btn btn-info"><i
                                class="fa fa-search">&nbsp;</i>Filter
                    </button>
                </div>
            </div>
            <!--button ends-->
        </div>
        <!-- filter ends-->
        <hr>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover social-accounts" id="post_list_table">
                    <thead>
                    <tr>
                        <th>Account Name</th>
                        <th>Group Name</th>
                        <th>Group Type</th>
                        <th>Post Text</th>
                        <th>Time</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section("post-js")
    <script src={{asset("assets/admin_panel/vendors/datatables.net/js/jquery.dataTables.min.js")}}></script>
    <script src={{asset("assets/admin_panel/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js")}}></script>
    <script src={{asset("assets/admin_panel/vendors/datatables.net-dt/js/dataTables.dataTables.min.js")}}></script>
    <script src={{asset("assets/admin_panel/vendors/datatables.net-buttons/js/dataTables.buttons.min.js")}}></script>
    <script
            src={{asset("assets/admin_panel/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js")}}></script>
    <script src={{asset("assets/admin_panel/vendors/datatables.net-buttons/js/buttons.flash.min.js")}}></script>
    <script src={{asset("assets/admin_panel/vendors/jszip/dist/jszip.min.js")}}></script>
    <script src={{asset("assets/admin_panel/vendors/pdfmake/build/pdfmake.min.js")}}></script>
    <script src={{asset("assets/admin_panel/vendors/pdfmake/build/vfs_fonts.js")}}></script>
    <script src={{asset("assets/admin_panel/vendors/datatables.net-buttons/js/buttons.html5.min.js")}}></script>
    <script src={{asset("assets/admin_panel/vendors/datatables.net-buttons/js/buttons.print.min.js")}}></script>
    <script
            src={{asset("assets/admin_panel/vendors/datatables.net-responsive/js/dataTables.responsive.min.js")}}></script>
    <script src={{asset("assets/admin_panel/dist/js/dataTables-data.js")}}></script>

    <script src={{asset("assets/admin_panel/vendors/moment/min/moment.min.js")}}></script>
    <script src={{asset("assets/admin_panel/vendors/daterangepicker/daterangepicker.js")}}></script>
    <script src={{asset("assets/admin_panel/dist/js/daterangepicker-data.js")}}></script>
    <!-- data table-->
    <script>
        $(document).ready(function () {
            $('#post_list_table').DataTable({
                dom: 'lfrtip',
                language: {
                    search: "",
                    searchPlaceholder: "Search",
                },
                "language": {
                    "processing": "Loading. Please wait..."
                },
                "lengthMenu": [[10, 50, 100, 500, 10000], [10, 50, 100, 500, "All"]],
                "bPaginate": true,
                "info": true,
                "bFilter": true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('history.get') }}",
                    data: function (d) {
                        d.group_id = $('select[name=group_id] option:selected').val();
                        d.post_date = $('#post_date').val();
                    }
                },

                columns: [
                    {
                        'render': function (data, type, row) {
                            return '<img style="max-width: 50px" src="' + row.account_info.avatar + '">';
                        },
                    },

                    {data: 'group_info.name', name: 'group_info.name'},
                    {data: 'group_info.type', name: 'group_info.type'},
                    {data: 'post_text', name: 'post_text'},
                    {data: 'created_at', name: 'created_at'},

                ],

                "drawCallback":

                    function () {
                        $('.dt-buttons > .btn').addClass('btn-outline-light btn-sm');
                    }

                ,
            });

        })
        ;

        //for filtered datatable draw
        $('#btnFiterSubmitSearch').on("click", function () {
            $('#post_list_table').DataTable().draw(true);
        });

        $('.post_date').daterangepicker({
            autoUpdateInput: false,
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            }
        });

        $('#post_date').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });

    </script>

    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
