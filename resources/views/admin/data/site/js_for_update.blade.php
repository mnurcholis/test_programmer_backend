<script>
    // variabel global marker
    var marker;

    function edit_taruhMarker(peta, posisiTitik) {

        if (marker) {
            // pindahkan marker
            marker.setPosition(posisiTitik);
        } else {
            // buat marker baru
            marker = new google.maps.Marker({
                position: posisiTitik,
                map: peta
            });
        }

        // isi nilai koordinat ke form
        document.getElementById("edit_titik_koordinat").value = posisiTitik.lat() + ' , ' + posisiTitik.lng();

    }

    function edit_initialize() {
        var propertiPeta = {
            center: new google.maps.LatLng(-7.420092229169261, 109.80843764116938),
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var peta = new google.maps.Map(document.getElementById("edit_googleMap"), propertiPeta);

        // even listner ketika peta diklik
        google.maps.event.addListener(peta, 'click', function(event) {
            edit_taruhMarker(this, event.latLng);
        });

    }


    // event jendela di-load  
    var mapsnya = google.maps.event.addDomListener(window, 'load', edit_initialize);

    $(document).on("click", "#button_edit_operator", function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var site_id = $(this).data('site_id');
        var alamat = $(this).data('alamat');
        var id_operator = $(this).data('id_operator');
        var ketinggian = $(this).data('ketinggian');
        var tahun = $(this).data('tahun');
        var titik_koordinat = $(this).data('titik_koordinat');

        $("#edit_id").val(id);
        $("#edit_name").val(name);
        $("#edit_site_id").val(site_id);
        $("#edit_alamat").val(alamat);
        $("#edit_id_operator").val(id_operator);
        $("#edit_ketinggian").val(ketinggian);
        $("#edit_tahun").val(tahun);
        $("#edit_titik_koordinat").val(titik_koordinat);
    });

    function reset_help_edit() {
        $('#edit_id_operator_help').text('');
        $('#edit_name_help').text('');
        $('#edit_side_id_help').text('');
        $('#edit_alamat_help').text('');
        $('#edit_ketinggian_help').text('');
        $('#edit_tahun_help').text('');
        $('#edit_titik_koordinat_help').text('');
    }

    $(document).on("click", "#edit_save", function() {
        reset_help_edit();
        var id = $('#edit_id').val();
        var id_operator = $('#edit_id_operator').val();
        var name = $('#edit_name').val();
        var site_id = $('#edit_site_id').val();
        var alamat = $('#edit_alamat').val();
        var ketinggian = $('#edit_ketinggian').val();
        var tahun = $('#edit_tahun').val();
        var titik_koordinat = $('#edit_titik_koordinat').val();

        if (id_operator == '') {
            $('#edit_id_operator').trigger('focus')
            $('#edit_id_operator_help').text('Operator is Empty!');
        } else if (name == '') {
            $('#edit_name').trigger('focus')
            $('#edit_name_help').text('Name Operator is Empty!');
        } else if (site_id == '') {
            $('#edit_site_id').trigger('focus')
            $('#edit_site_id_help').text('Site ID is Empty!');
        } else if (alamat == '') {
            $('#edit_alamat').trigger('focus')
            $('#edit_alamat_help').text('Alamat is Empty!');
        } else if (ketinggian == '') {
            $('#edit_ketinggian').trigger('focus')
            $('#edit_ketinggian_help').text('Ketinggian is Empty!');
        } else if (tahun == '') {
            $('#edit_tahun').trigger('focus')
            $('#edit_tahun_help').text('Tahun is Empty!');
        } else if (titik_koordinat == '') {
            $('#edit_titik_koordinat').trigger('focus')
            $('#edit_titik_koordinat_help').text('Titik Koordinat is Empty!');
        } else {
            // processing ajax request
            $.ajax({
                url: "{{ route('update.site_operator') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    id: id,
                    id_operator: id_operator,
                    name: name,
                    site_id: site_id,
                    alamat: alamat,
                    ketinggian: ketinggian,
                    tahun: tahun,
                    titik_koordinat: titik_koordinat,
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
                    } else if (result.status == 'site_id') {
                        $('#edit_site_id_help').text(result.info);
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
                url: "{{ url('admin/delete_site') }}",
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
