@extends('layouts.adminapp')

@section('content')


    <div class="container">
        <h1>Events</h1>
        
        <hr>

        <div class="row">
            <div class="col-md-12">
                <a href="/admin/event"><button class="btn btn-primary" type="button">Add new Event</button></a>
            </div>
        </div>

        <hr>

        @include('tools.flash-message')
        <div class="clearfix"></div>
        <table class="table table-striped datatable" id="datatable">
            <thead>
                <tr>
                    <th>
                        active
                    </th>
                    <th class="col-md-7">
                        event name
                    </th>
                    <th class="col-md-2" style="min-width: 90px;"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="999">
                        Loading Records
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Item verwijderen</h4>
                    </div>
                    <div class="modal-body">
                        <p>Weet u zeker dat u dit item wilt verwijderen?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuleren</button>
                        <a class="btn btn-danger btn-ok submit-modal">Verwijderen</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function(){
        // Event listener to the two range filtering inputs to redraw on input
        $('#active_filter').on("change", function(){
            var dt = $("#datatable").DataTable();
            dt.ajax.reload();
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#datatable").DataTable( {
            "order": [[ 0, "asc" ]],
            "columns": [ 
                        {"sortable": true},
                        {"sortable": true},
                        {"sortable": false}
                    ],
            ajax: {
                    url: "/admin/event/Datatable_Events",
                    type: "POST",
                    data: function ( d ) {
                            d.active_filter = getFilters();
                    }
                }
            
        });				
    });

    function getFilters()
    {
        var filters;
        filters = $("select[name=active_filter]").val();
        return filters;
    }

</script>

@endsection