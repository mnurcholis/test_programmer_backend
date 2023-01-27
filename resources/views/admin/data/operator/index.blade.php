@extends('layout.master')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="d-grid gap-2">

                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Operator</h5>
                        <button class="btn btn-primary mb-3 btn-sm" type="button" id="add-operator" data-bs-toggle="modal"
                            data-bs-target="#add_operator_new">Tambah Operator</button>
                        <table class="table table-hover table-bordered" id="table_operator">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 80%">Operator Telekomunikasi / Provider</th>
                                    <th scope="col" style="width:20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <div class="modal fade" id="add_operator_new" tabindex="-1" data-bs-backdrop="static" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Operator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="name">
                                <small id="name_help" class="form-text"></small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="tutup">Close</button>
                    <button type="button" class="btn btn-primary" id="save" name="save">Save</button>
                </div>
            </div>
        </div>
    </div><!-- End Add Links Name Modal-->

    <div class="modal fade" id="modal_edit_operator" tabindex="-1" data-bs-backdrop="static" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Operator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input type="hidden" class="form-control" name="edit_id" id="edit_id">
                                <input type="text" class="form-control" name="edit_name" id="edit_name">
                                <small id="edit_name_help" class="form-text"></small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="edit_tutup">Close</button>
                    <button type="button" class="btn btn-primary" id="edit_save" name="edit_save">Save</button>
                </div>
            </div>
        </div>
    </div><!-- End Add Links Name Modal-->

    <div class="modal fade" id="modal_delete_operator" tabindex="-1" data-bs-backdrop="static" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Operator ?? <b id="delete_name"></b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <input type="hidden" class="form-control" name="delete_id" id="delete_id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="close">Close</button>
                    <button type="button" class="btn btn-primary" id="delete" name="delete">Delete</button>
                </div>
            </div>
        </div>
    </div><!-- End Delete Links Name Modal-->
@endsection

@push('custom-scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table;
        $(document).ready(function() {
            table = $('#table_operator').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                paging: false,
                info: false,
                iDisplayLength: 5,
                order: [],
                ajax: "{{ route('operator.list') }}",
                columns: [{
                        data: 'name',
                        name: 'name',
                        orderable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },
                ]
            });
        });

        $('#add_operator_new').on('shown.bs.modal', function() {
            $('#name').val('');
            $('#name_help').text('');
            $('#name').trigger('focus');
        })

        $(document).on("blur", "#name", function() {
            $('#name_help').text('');
        });

        $(document).on("click", "#save", function() {
            var name = $('#name').val();
            if (name == '') {
                $('#name').trigger('focus')
                $('#name_help').text('Name Operator is Empty!');
            } else {
                // processing ajax request
                $.ajax({
                    url: "{{ route('save.operator') }}",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        name: name
                    },
                    beforeSend: function() {
                        /* Show image container */
                        $("#tutup").prop("disabled", true);
                        $("#save").prop("disabled", true);
                        $('#save').html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                        );
                    },
                    success: function(result) {
                        // console.log(result);
                        if (result.status == true) {
                            $('#add_operator_new').modal('hide');
                            swal({
                                    text: result.info,
                                    icon: 'success',
                                    timer: 800,
                                    buttons: false,
                                })
                                .then(() => {
                                    table.ajax.reload();
                                })
                        } else if (result.status == false) {
                            $('#links_name_help').text(result.info);
                        } else if (result.status === 'more') {
                            swal({
                                text: result.info,
                                icon: 'warning',
                                timer: 1200,
                                buttons: false,
                            })
                        } else {
                            swal("alert", "Data Not Save", "error");
                            $('#add_operator_new').modal('hide');
                        }
                    },
                    complete: function(data) {
                        // Hide image container
                        $("#tutup").prop("disabled", false);
                        $("#save").prop("disabled", false);
                        $('#save').html('Save');
                    }
                });
            }

        });

        $(document).on("click", "#button_edit_operator", function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            $("#edit_id").val(id);
            $("#edit_name").val(name);
        });

        $(document).on("click", "#edit_save", function() {
            var id = $('#edit_id').val();
            var name = $('#edit_name').val();
            if (name == '') {
                $('#edit_name').trigger('focus')
                $('#edit_name_help').text('Name Operator is Empty!');
            } else {
                // processing ajax request
                $.ajax({
                    url: "{{ route('update.operator') }}",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        id: id,
                        name: name
                    },
                    beforeSend: function() {
                        /* Show image container */
                        $("#edit_tutup").prop("disabled", true);
                        $("#edit_save").prop("disabled", true);
                        $('#edit_save').html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                        );
                    },
                    success: function(result) {
                        // console.log(result);
                        if (result.status == true) {
                            $('#modal_edit_operator').modal('hide');
                            swal({
                                    text: result.info,
                                    icon: 'success',
                                    timer: 800,
                                    buttons: false,
                                })
                                .then(() => {
                                    table.ajax.reload();
                                })
                        } else if (result.status == false) {
                            $('#edit_name_help').text(result.info);
                        } else if (result.status === 'more') {
                            swal({
                                text: result.info,
                                icon: 'warning',
                                timer: 1200,
                                buttons: false,
                            })
                        } else {
                            swal("alert", "Data Not Save", "error");
                            $('#modal_edit_operator').modal('hide');
                        }
                    },
                    complete: function(data) {
                        // Hide image container
                        $("#edit_tutup").prop("disabled", false);
                        $("#edit_save").prop("disabled", false);
                        $('#edit_save').html('Save');
                    }
                });
            }

        });


        $(document).on("click", "#button_delete_operator", function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            $("#delete_id").val(id);
            $("#delete_name").text(name);
        });

        $(document).on("click", "#delete", function() {
            var id = $('#delete_id').val();
            if (id == '') {
                swal({
                        text: 'Can\'t Delete This Item..',
                        timer: 800,
                        buttons: false,
                    })
                    .then(() => {
                        $('#modal_delete_operator').modal('hide');
                    })
            } else {
                // processing ajax request
                $.ajax({
                    url: "{{ url('admin/delete_operator') }}",
                    type: 'DELETE',
                    dataType: "json",
                    data: {
                        id: id
                    },
                    beforeSend: function() {
                        /* Show image container */
                        $("#delete").prop("disabled", true);
                        $("#close").prop("disabled", true);
                        $('#delete').html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                        );
                    },
                    success: function(result) {
                        // console.log(result);
                        if (result.status == true) {
                            $('#modal_delete_operator').modal('hide');
                            swal({
                                    text: result.info,
                                    icon: 'success',
                                    timer: 800,
                                    buttons: false,
                                })
                                .then(() => {
                                    table.ajax.reload();
                                })
                        } else {
                            swal({
                                    text: 'Error.. Can\'t Delete',
                                    timer: 800,
                                    buttons: false,
                                })
                                .then(() => {
                                    $('#modal_delete_operator').modal('hide');
                                })
                        }
                    },
                    complete: function(data) {
                        // Hide image container
                        $("#close").prop("disabled", false);
                        $("#delete").prop("disabled", false);
                        $('#delete').html('Delete');
                    }
                });
            }

        });
    </script>
@endpush
