@extends('layout.master')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Settings Form</h5>

                        <!-- Horizontal Form -->
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">App Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="app_name" name="app_name"
                                    value="{{ $setting->app_name }}">
                                <small id="app_name_help"></small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-lg-3 col-form-label">Description</label>
                            <div class="col-md-8 col-lg-9">
                                <textarea name="description" class="form-control" id="description" style="height: 100px">{{ $setting->description }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Logo Image</label>
                            <div class="col-md-8 col-lg-9">
                                <div id="uploaded_image">
                                    <img id="view_logo" src="/assets/img/{{ $setting->logo }}" alt="Logo Image"
                                        class="col-md-12 col-lg-6 col-xl-4 mb-2">
                                </div>
                                <div class="pt-2">
                                    <input class="form-control" type="file" id="logo_image" name="logo_image"
                                        accept="image/*"
                                        onchange="document.getElementById('view_logo').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Favicon Image</label>
                            <div class="col-md-8 col-lg-9">
                                <div id="uploaded_favicon">
                                    <img id="view_favicon" src="/assets/img/{{ $setting->favicon }}" alt="Favicon"
                                        class="col-md-12 col-lg-2 col-xl-2 mb-2">
                                </div>
                                <div class="pt-2">
                                    <input class="form-control" type="file" id="favicon_image" name="favicon_image"
                                        accept="image/*"
                                        onchange="document.getElementById('view_favicon').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                            </div>
                        </div>

                        <div class=" text-center">
                            <button type="button" id="save_setting" name="save_setting"
                                class="btn btn-primary">Save</button>
                        </div>
                        <!-- End Horizontal Form -->

                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection

@push('custom-scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on("click", "#save_setting", function() {
            $("#app_name_help").text('');

            var app_name = $("#app_name").val();

            if (app_name == '') {
                $('#app_name').trigger('focus')
                $("#app_name_help").text('APP Name Masih Kosong');
                return
            }

            let formData = new FormData();
            formData.append('app_name', app_name);
            formData.append('description',  $("#description").val());

            if ($('#logo_image').get(0).files.length > 0) {
                formData.append('logo_image', $('#logo_image').prop('files')[0]);
            }

            if ($('#favicon_image').get(0).files.length > 0) {
                formData.append('favicon_image', $('#favicon_image').prop('files')[0]);
            }

            $.ajax({
                url: "{{ url('admin/save_settings') }}",
                type: 'POST',
                dataType: "json",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    /* Show image container */
                    $("#save_setting").prop("disabled", true);
                    $('#save_setting').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                    );
                },
                success: function(result) {
                    console.log(result);
                    if (result.status == true) {
                        swal({
                            text: result.info,
                            icon: 'success',
                            timer: 800,
                            buttons: false,
                        }).then(() => {
                            location.reload();
                        })
                    } else if (result.status === 'more') {
                        swal({
                            text: result.info,
                            icon: 'warning',
                            timer: 1200,
                            buttons: false,
                        })
                    } else {
                        swal("alert", "Data Not Save", "error");
                    }
                },
                complete: function(data) {
                    // Hide image container
                    $("#save_setting").prop("disabled", false);
                    $('#save_setting').html('Save');
                }
            });

        });
    </script>
@endpush
