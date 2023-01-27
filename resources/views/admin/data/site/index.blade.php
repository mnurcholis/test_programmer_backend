@extends('layout.master')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-grid gap-2">

                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Site Operator</h5>
                        <button class="btn btn-primary mb-3 btn-sm" type="button" id="add-operator" data-bs-toggle="modal"
                            data-bs-target="#modal_add_operator_new">Tambah Site Operator</button>
                        <table class="table table-hover table-bordered" id="table_site_operator">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 20%">Name Site</th>
                                    <th scope="col" style="width: 15%">Id Site</th>
                                    <th scope="col" style="width: 25%">Alamat</th>
                                    <th scope="col" style="width: 20%">Operator Telekomunikasi / Provider</th>
                                    <th scope="col" style="width: 20%">Titik Koordinat</th>
                                    <th scope="col" style="width: 10%">Ketinggian</th>
                                    <th scope="col" style="width: 10%">Tahun</th>
                                    <th scope="col" style="width: 10%">Action</th>
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


    <div class="modal fade" id="modal_add_operator_new" tabindex="-1" data-bs-backdrop="static" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Site Operator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-6">
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-4 col-form-label">Operator Name</label>
                                    <div class="col-sm-8">
                                        <select name="id_operator" id="id_operator" class="form-select">
                                            <option value="">-- Pilih Operator --</option>
                                            @foreach ($data_operator as $key => $value)
                                                <option value="{{ $value->id }}"> {{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        <small id="id_operator_help" class="form-text"></small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-4 col-form-label">Site Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="name" id="name">
                                        <small id="name_help" class="form-text"></small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-4 col-form-label">Site Id</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="site_id" id="site_id">
                                        <small id="site_id_help" class="form-text"></small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-4 col-form-label">Alamat</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="alamat" id="alamat"></textarea>
                                        <small id="alamat_help" class="form-text"></small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-4 col-form-label">Ketinggian</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="ketinggian" id="ketinggian">
                                        <small id="ketinggian_help" class="form-text"></small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-4 col-form-label">Tahun</label>
                                    <div class="col-sm-8">
                                        <select name="tahun" id="tahun" class="form-select">
                                            <option value="">-- Pilih Tahun --</option>
                                            <?php
                                            for ($i = date('Y'); $i >= date('Y') - 20; $i -= 1) {
                                                echo "<option value='$i'> $i </option>";
                                            }
                                            ?>
                                        </select>
                                        <small id="tahun_help" class="form-text"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row mb-3">
                                    <div id="googleMap" style="width:100%;height:280px;"></div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-4 col-form-label">Titik Koordinat</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="titik_koordinat"
                                            id="titik_koordinat">
                                        <small id="titik_koordinat_help" class="form-text"></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="tutup">Close</button>
                    <button type="button" class="btn btn-primary" id="save" name="save">Save</button>
                </div>
            </div>
        </div>
    </div><!-- End Add Links Name Modal-->

    <div class="modal fade" id="modal_edit_operator" tabindex="-1" data-bs-backdrop="static" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Site Operator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-6">
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-4 col-form-label">Operator Name</label>
                                    <div class="col-sm-8">
                                        <select name="edit_id_operator" id="edit_id_operator" class="form-select">
                                            <option value="">-- Pilih Operator --</option>
                                            @foreach ($data_operator as $key => $value)
                                                <option value="{{ $value->id }}"> {{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        <small id="edit_id_operator_help" class="form-text"></small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-4 col-form-label">Site Name</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" class="form-control" name="edit_id" id="edit_id">
                                        <input type="text" class="form-control" name="edit_name" id="edit_name">
                                        <small id="edit_name_help" class="form-text"></small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-4 col-form-label">Site Id</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="edit_site_id"
                                            id="edit_site_id">
                                        <small id="edit_site_id_help" class="form-text"></small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-4 col-form-label">Alamat</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="edit_alamat" id="edit_alamat"></textarea>
                                        <small id="edit_alamat_help" class="form-text"></small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-4 col-form-label">Ketinggian</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="edit_ketinggian"
                                            id="edit_ketinggian">
                                        <small id="edit_ketinggian_help" class="form-text"></small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-4 col-form-label">Tahun</label>
                                    <div class="col-sm-8">
                                        <select name="edit_tahun" id="edit_tahun" class="form-select">
                                            <option value="">-- Pilih Tahun --</option>
                                            <?php
                                            for ($i = date('Y'); $i >= date('Y') - 20; $i -= 1) {
                                                echo "<option value='$i'> $i </option>";
                                            }
                                            ?>
                                        </select>
                                        <small id="edit_tahun_help" class="form-text"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row mb-3">
                                    <div id="edit_googleMap" style="width:100%;height:280px;"></div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-4 col-form-label">Titik Koordinat</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="edit_titik_koordinat"
                                            id="edit_titik_koordinat">
                                        <small id="edit_titik_koordinat_help" class="form-text"></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="edit_tutup">Close</button>
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
    </script>
    @include('admin.data.site.js_for_save')
    @include('admin.data.site.js_for_update')
@endpush
