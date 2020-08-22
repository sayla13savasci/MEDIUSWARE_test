@extends('layouts.app')
@section('content')
    <div class="container-fluid app-body">
        <h3>Recent Post Sent to Buffer</h3>
        <hr>
        <form method="get" action="{{route('history2')}}">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="controls">
                            <input class="form-control post_date" type="text" name="date" id="post_date"
                                   value="{{ Session::get('date')}}"/>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <select class="form-control" name="group_id">
                        <option value="" selected>Select a group</option>
                        @foreach($groups as $group)
                            <option value="{{$group->id}}" {{Session::get('group_id') == $group->id ? "selected" : ""}}>{{$group->name}}</option>
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
        </form>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover social-accounts" id="post_list_table">
                    <thead>
                    <tr>
                        <th>Group Name</th>
                        <th>Group Type</th>
                        <th>Account Name</th>
                        <th>Post Text</th>
                        <th>Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{$post->groupInfo == null ? "N/A" : $post->groupInfo->name}}</td>
                            <td>{{$post->groupInfo == null ? "N/A" : $post->groupInfo->type}}</td>
                            <td><img src="{{$post->accountInfo == null ? "N/A" : $post->accountInfo->avatar}}"
                                     style="max-width: 50px"></td>
                            <td>{{$post->post_text}}</td>
                            <td>{{$post->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-right">
                    @if(Session::get('date') && Session::get('group_id'))
                        {{ $posts->appends(['date' => Session::get('date'), 'group_id' => Session::get('group_id')])->links() }}
                    @elseif(Session::get('date'))
                        {{ $posts->appends(['date' => Session::get('date')])->links() }}
                    @elseif(Session::get('group_id'))
                        {{ $posts->appends(['group_id' => Session::get('group_id')])->links() }}
                    @else
                        {{ $posts->appends(['group_id' => Session::get('group_id')])->links() }}
                    @endif
                </div>
                <br>
                <br>
                <br>
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
@endsection
