<script>
    var table;
    $(document).ready(function() {
        table = $('#table_retribusi').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            info: false,
            iDisplayLength: 5,
            order: [],
            ajax: "{{ route('retribusi.list') }}",
            columns: [{
                    data: 'operator_name',
                    name: 'operator_name',
                    orderable: false,
                },
                {
                    data: 'site_name',
                    name: 'site_name',
                    orderable: false,
                },
                {
                    data: 'site_id',
                    name: 'site_id',
                    orderable: false,
                },
                {
                    data: 'retribusi',
                    name: 'retribusi',
                    orderable: false,
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp. ')
                },
                {
                    data: 'tanggal',
                    name: 'tanggal',
                    orderable: false,
                    render: function(data) {
                        var date = new Date(data);
                        var month = date.getMonth() + 1;
                        return date.getDate() + "-" + (month.length > 1 ? month : "0" + month) +
                            "-" + date.getFullYear();
                    }
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

    function reset_input_new() {
        $('#id_site_operator').prop('selectedIndex', 0);
        $('#retribusi').val('');
        $('#tanggal').val('');

        $('#id_site_operator_help').text('');
        $('#retribusi_help').text('');
        $('#tanggal_help').text('');
    }

    function reset_help_new() {
        $('#id_site_operator_help').text('');
        $('#retribusi_help').text('');
        $('#tanggal_help').text('');
    }

    $('#modal_add_retribusi').on('shown.bs.modal', function() {
        reset_input_new();
        $('#retribusi').trigger('focus');
    });

    var rupiah = document.getElementById('retribusi');
    rupiah.addEventListener('keyup', function(e) {
        rupiah.value = formatRupiah(this.value, 'Rp. ');
    });

    var edit_rupiah = document.getElementById('edit_retribusi');
    edit_rupiah.addEventListener('keyup', function(e) {
        edit_rupiah.value = formatRupiah(this.value, 'Rp. ');
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $(document).on("click", "#save", function() {
        reset_help_new();
        var id_site_operator = $('#id_site_operator').val();
        var retribusi = $('#retribusi').val();
        var tanggal = $('#tanggal').val();

        if (id_site_operator == '') {
            $('#id_site_operator').trigger('focus')
            $('#id_site_operator_help').text('Site Operator is Empty!');
        } else if (retribusi == '') {
            $('#retribusi').trigger('focus')
            $('#retribusi_help').text('Retribusi Operator is Empty!');
        } else if (tanggal == '') {
            $('#tanggal').trigger('focus')
            $('#tanggal_help').text('Tanggal is Empty!');
        } else {
            // processing ajax request
            $.ajax({
                url: "{{ route('save.retribusi') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    id_site_operator: id_site_operator,
                    retribusi: retribusi.replace(/[^\d]/g, ""),
                    tanggal: tanggal,
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
                        $('#modal_add_retribusi').modal('hide');
                        swal({
                                text: result.info,
                                icon: 'success',
                                timer: 800,
                                buttons: false,
                            })
                            .then(() => {
                                table.ajax.reload();
                            })
                    } else if (result.status == 'site_id') {
                        $('#site_id_help').text(result.info);
                    } else if (result.status === 'more') {
                        swal({
                            text: result.info,
                            icon: 'warning',
                            timer: 1200,
                            buttons: false,
                        })
                    } else {
                        swal("alert", "Data Not Save", "error");
                        $('#modal_add_retribusi').modal('hide');
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

    $(document).on("click", "#button_edit_retribusi", function() {
        var id = $(this).data('id');
        var id_site = $(this).data('id_site');
        var retribusi = $(this).data('retribusi');
        var tanggal = $(this).data('tanggal');

        $("#edit_id").val(id);
        $("#edit_id_site_operator").val(id_site);
        $("#edit_retribusi").val(retribusi);
        $("#edit_tanggal").val(tanggal);
    });

    $(document).on("click", "#edit_save", function() {
        var id = $('#edit_id').val();
        var id_site_operator = $('#edit_id_site_operator').val();
        var retribusi = $('#edit_retribusi').val();
        var tanggal = $('#edit_tanggal').val();

        if (id_site_operator == '') {
            $('#edit_id_site_operator').trigger('focus')
            $('#edit_id_site_operator_help').text('Site Operator is Empty!');
        } else if (retribusi == '') {
            $('#edit_retribusi').trigger('focus')
            $('#edit_retribusi_help').text('Retribusi Operator is Empty!');
        } else if (tanggal == '') {
            $('#edit_tanggal').trigger('focus')
            $('#edit_tanggal_help').text('Tanggal is Empty!');
        } else {
            // processing ajax request
            $.ajax({
                url: "{{ route('update.retribusi') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    id: id,
                    id_site_operator: id_site_operator,
                    retribusi: retribusi.replace(/[^\d]/g, ""),
                    tanggal: tanggal,
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
                        $('#modal_edit_retribusi').modal('hide');
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
                        $('#modal_edit_retribusi').modal('hide');
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

    $(document).on("click", "#button_delete_retribusi", function() {
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
                    url: "{{ url('admin/delete_retribusi') }}",
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
                            $('#modal_delete_retribusi').modal('hide');
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
                                    $('#modal_delete_retribusi').modal('hide');
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
