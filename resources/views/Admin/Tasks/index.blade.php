@extends('AdminLayout')

@section('title', 'Tasks')
@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('assets/editor/css/editor.bootstrap4.css') }}" rel="stylesheet" type="text/css">



    <style>

        .filepond--item {
            width: calc(50% - 0.5em);
        }

        @media (min-width: 30em) {
            .filepond--item {
                width: calc(50% - 0.5em);
            }
        }

        @media (min-width: 50em) {
            .filepond--item {
                width: calc(33.33% - 0.5em);
            }
        }

        /* use a hand cursor intead of arrow for the action buttons */
        .filepond--file-action-button {
            cursor: pointer;
        }

        /* the text color of the drop label*/
        .filepond--drop-label {
            color: #555;
        }

        /* underline color for "Browse" button */
        .filepond--label-action {
            text-decoration-color: #aaa;
        }

        /* the background color of the filepond drop area */
        .filepond--panel-root {
            background-color: #eee;
        }

        /* the border radius of the drop area */
        .filepond--panel-root {
            border-radius: 0.5em;
        }

        /* the border radius of the file item */
        .filepond--item-panel {
            border-radius: 0.5em;
        }

        /* the background color of the file and file panel (used when dropping an image) */
        .filepond--item-panel {
            background-color: #555;
        }

        /* the background color of the drop circle */
        .filepond--drip-blob {
            background-color: #999;
        }

        /* the background color of the black action buttons */
        .filepond--file-action-button {
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* the icon color of the black action buttons */
        .filepond--file-action-button {
            color: white;
        }

        /* the color of the focus ring */
        .filepond--file-action-button:hover,
        .filepond--file-action-button:focus {
            box-shadow: 0 0 0 0.125em rgba(255, 255, 255, 0.9);
        }

        /* the text color of the file status and info labels */
        .filepond--file {
            color: white;
        }

        /* error state color */
        [data-filepond-item-state*='error'] .filepond--item-panel,
        [data-filepond-item-state*='invalid'] .filepond--item-panel {
            background-color: red;
        }

        [data-filepond-item-state='processing-complete'] .filepond--item-panel {
            background-color: green;
        }

        /* bordered drop area */
        .filepond--panel-root {
            background-color: transparent;
            border: 2px solid #2c3340;
        }
    </style>
    <style>
        .dt-button-collection {
            left: 0 !important;
            min-width: 82px !important;
        }
    </style>
@endsection


@section('content')

    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
                    <!--end::Page Title-->
                    <!--begin::Actions-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                    <span class="text-muted font-weight-bold mr-4">#XRS-45670</span>
                    <button id="addTaskBtn" class="btn btn-light-warning font-weight-bolder btn-sm">Add New</button>
                    <!--end::Actions-->
                </div>

            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="card card-custom">
                    <div class="card-body">


                        <div style="text-align: right;" class="btn-group" id="dtButtons" role="group"
                             aria-label="Button group with nested dropdown">
                        </div>

                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-foot-custom table-checkable"
                               id="kt_datatable" style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th><input type="checkbox" name="main_checkbox"><label></label></th>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Priority</th>
                                <th>Due Date</th>
                                <th>Actions
                                    <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">Delete All</button>
                                </th>
                            </tr>
                            </thead>
                        </table>
                        <!--end: Datatable-->

                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->


    @include('Admin.Tasks.edit-product')

    @include('Admin.Tasks.add-product')

@endsection



@section('scripts')

    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/toastr/toastr.min.js') }}"></script>

    <script>


        toastr.options.preventDuplicates = true;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function (e) {


            //GET ALL Tasks

            var table = $('#kt_datatable').DataTable({
                processing: true,
                info: true,
                ajax: "{{ route('get.tasks.list') }}",
                "pageLength": 5,
                "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                columns: [
                    //  {data:'id', name:'id'},
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'priority', name: 'priority'},
                    {data: 'due_date', name: 'due_date'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                ]
            }).on('draw', function () {
                $('input[name="task_checkbox"]').each(function () {
                    this.checked = false;
                });
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllBtn').addClass('d-none');
            });


            // Select Multiple checkbox and delete

            $(document).on('click', 'input[name="main_checkbox"]', function () {
                if (this.checked) {
                    $('input[name="task_checkbox"]').each(function () {
                        this.checked = true;
                    });
                } else {
                    $('input[name="task_checkbox"]').each(function () {
                        this.checked = false;
                    });
                }
                toggledeleteAllBtn();
            });

            $(document).on('change', 'input[name="task_checkbox"]', function () {

                if ($('input[name="task_checkbox"]').length == $('input[name="task_checkbox"]:checked').length) {
                    $('input[name="main_checkbox"]').prop('checked', true);
                } else {
                    $('input[name="main_checkbox"]').prop('checked', false);
                }
                toggledeleteAllBtn();
            });


            function toggledeleteAllBtn() {
                if ($('input[name="task_checkbox"]:checked').length > 0) {
                    $('button#deleteAllBtn').text('Delete (' + $('input[name="task_checkbox"]:checked').length + ')').removeClass('d-none');
                } else {
                    $('button#deleteAllBtn').addClass('d-none');
                }
            }

            //DELETE Product RECORD
            $(document).on('click', '#deleteTaskBtn', function () {
                var task_id = $(this).data('id');
                var url = '<?= route("delete.task") ?>';

                swal.fire({
                    title: 'Are you sure?',
                    html: 'You want to <b>delete</b> this Task',
                    showCancelButton: true,
                    showCloseButton: true,
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonColor: '#d33',
                    confirmButtonColor: '#556ee6',
                    width: 300,
                    allowOutsideClick: false
                }).then(function (result) {
                    if (result.value) {
                        $.post(url, {task_id: task_id}, function (data) {
                            if (data.code == 1) {
                                $('#kt_datatable').DataTable().ajax.reload(null, false);
                                toastr.success(data.msg);
                            } else {
                                toastr.error(data.msg);
                            }
                        }, 'json');
                    }
                });

            });

            $(document).on('click', 'button#deleteAllBtn', function () {
                var checkedTasks = [];
                $('input[name="task_checkbox"]:checked').each(function () {
                    checkedTasks.push($(this).data('id'));
                });

                var url = '{{ route("delete.selected.tasks") }}';
                if (checkedTasks.length > 0) {
                    swal.fire({
                        title: 'Are you sure?',
                        html: 'You want to delete <b>(' + checkedTasks.length + ')</b> tasks',
                        showCancelButton: true,
                        showCloseButton: true,
                        confirmButtonText: 'Yes, Delete',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#556ee6',
                        cancelButtonColor: '#d33',
                        width: 300,
                        allowOutsideClick: false
                    }).then(function (result) {
                        if (result.value) {
                            $.post(url, {task_ids: checkedTasks}, function (data) {
                                if (data.code == 1) {
                                    $('#kt_datatable').DataTable().ajax.reload(null, true);
                                    toastr.success(data.msg);
                                }
                            }, 'json');
                        }
                    })
                }
            });


            // Show Create Product Model

            $(document).on('click', '#addTaskBtn', function () {
                $('.addTask').find('form')[0].reset();
                $('.addTask').find('span.error-text').text('');
                $('.addTask').modal('show');
            });


            $('#create-task-form').on('submit', function(e){
                e.preventDefault();
                var form = this;
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    showCancelButton: true,
                    allowOutsideClick: true,
                    contentType:false,
                    beforeSend:function(){
                        $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                        if(data.code == 0){
                            $.each(data.error, function(prefix, val){
                                $(form).find('span.'+prefix+'_error').text(val[0]);
                            });
                        }else{
                            $(form)[0].reset();
                            $('.addTask').modal('hide');
                            $('#kt_datatable').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);

                        }
                    }
                });
            });



            //    Edit Task

            $(document).on('click','#editTaskBtn', function(){

                var task_id = $(this).data('id');
                $('.editTask').find('form')[0].reset();
                $('.editTask').find('span.error-text').text('');

                $.post('<?= route("get.task.details") ?>',{task_id:task_id}, function(data){

                    $('.editTask').find('input[name="task_id"]').val(data.details.id);
                    $('.editTask').find('input[name="due_date"]').val(data.details.due_date);
                    $('.editTask').find('input[name="priority"]').val(data.details.priority);
                    $('.editTask').find('input[name="title"]').val(data.details.title);
                    $('.editTask').find('textarea[name="description"]').val(data.details.description);

                    $('.editTask').modal('show');

                },'json');
            });

            $('#update-task-form').on('submit', function(e){
                e.preventDefault();
                var form = this;
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend: function(){
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data){
                        if(data.code == 0){
                            $.each(data.error, function(prefix, val){
                                $(form).find('span.'+prefix+'_error').text(val[0]);
                            });
                        }else{
                            $('#kt_datatable').DataTable().ajax.reload(null, false);
                            $('.editTask').modal('hide');
                            $('.editTask').find('form')[0].reset();
                            toastr.success(data.msg);
                        }
                    }
                });
            });


        });


    </script>
@endsection
