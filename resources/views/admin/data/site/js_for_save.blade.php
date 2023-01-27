<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
    // variabel global marker
    var marker;

    function taruhMarker(peta, posisiTitik) {

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
        document.getElementById("titik_koordinat").value = posisiTitik.lat() + ' , ' + posisiTitik.lng();

    }

    function initialize() {
        var propertiPeta = {
            center: new google.maps.LatLng(-7.420092229169261, 109.80843764116938),
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);

        // even listner ketika peta diklik
        google.maps.event.addListener(peta, 'click', function(event) {
            taruhMarker(this, event.latLng);
        });

    }


    // event jendela di-load  
    var mapsnya = google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script>
    var table;
    $(document).ready(function() {
        table = $('#table_site_operator').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            paging: false,
            info: false,
            iDisplayLength: 5,
            order: [],
            ajax: "{{ route('site_operator.list') }}",
            columns: [{
                    data: 'name',
                    name: 'name',
                    orderable: false,
                },
                {
                    data: 'site_id',
                    name: 'site_id',
                    orderable: false,
                },
                {
                    data: 'alamat',
                    name: 'alamat',
                    orderable: false,
                },
                {
                    data: 'operators_name',
                    name: 'name_operator',
                    orderable: false,
                },
                {
                    data: 'titik_koordinat',
                    name: 'titik_koordinat',
                    orderable: false,
                },
                {
                    data: 'ketinggian',
                    name: 'ketinggian',
                    orderable: false,
                },
                {
                    data: 'tahun',
                    name: 'tahun',
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

    function reset_input_new() {
        $('#name').val('');
        $('#site_id').val('');
        $('#alamat').val('');
        $('#ketinggian').val('');
        $('#titik_koordinat').val('');
        $('#id_operator').prop('selectedIndex', 0);
        $('#tahun').prop('selectedIndex', 0);

        $('#id_operator_help').text('');
        $('#name_help').text('');
        $('#side_id_help').text('');
        $('#alamat_help').text('');
        $('#ketinggian_help').text('');
        $('#tahun_help').text('');
        $('#titik_koordinat_help').text('');
    }

    function reset_help_new() {
        $('#id_operator_help').text('');
        $('#name_help').text('');
        $('#side_id_help').text('');
        $('#alamat_help').text('');
        $('#ketinggian_help').text('');
        $('#tahun_help').text('');
        $('#titik_koordinat_help').text('');
    }

    $('#modal_add_operator_new').on('shown.bs.modal', function() {
        reset_input_new();
        $('#name').trigger('focus');
    });

    $(document).on("click", "#save", function() {
        reset_help_new();
        var id_operator = $('#id_operator').val();
        var name = $('#name').val();
        var site_id = $('#site_id').val();
        var alamat = $('#alamat').val();
        var ketinggian = $('#ketinggian').val();
        var tahun = $('#tahun').val();
        var titik_koordinat = $('#titik_koordinat').val();

        if (id_operator == '') {
            $('#id_operator').trigger('focus')
            $('#id_operator_help').text('Operator is Empty!');
        } else if (name == '') {
            $('#name').trigger('focus')
            $('#name_help').text('Name Operator is Empty!');
        } else if (site_id == '') {
            $('#site_id').trigger('focus')
            $('#site_id_help').text('Site ID is Empty!');
        } else if (alamat == '') {
            $('#alamat').trigger('focus')
            $('#alamat_help').text('Alamat is Empty!');
        } else if (ketinggian == '') {
            $('#ketinggian').trigger('focus')
            $('#ketinggian_help').text('Ketinggian is Empty!');
        } else if (tahun == '') {
            $('#tahun').trigger('focus')
            $('#tahun_help').text('Tahun is Empty!');
        } else if (titik_koordinat == '') {
            $('#titik_koordinat').trigger('focus')
            $('#titik_koordinat_help').text('Titik Koordinat is Empty!');
        } else {
            // processing ajax request
            $.ajax({
                url: "{{ route('save.site_operator') }}",
                type: 'POST',
                dataType: "json",
                data: {
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
                    $("#tutup").prop("disabled", true);
                    $("#save").prop("disabled", true);
                    $('#save').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                    );
                },
                success: function(result) {
                    // console.log(result);
                    if (result.status == true) {
                        $('#modal_add_operator_new').modal('hide');
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
                        $('#modal_add_operator_new').modal('hide');
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
</script>
