@extends('layout.master')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-grid gap-2">

                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Retribusi Operator</h5>
                        <button class="btn btn-primary mb-3 btn-sm" type="button" id="add-operator" data-bs-toggle="modal"
                            data-bs-target="#modal_add_retribusi">Tambah</button>
                        <table class="table table-hover table-bordered" id="table_retribusi">
                            <thead>
                                <tr>
                                    <th scope="col">Operator / Provider</th>
                                    <th scope="col">Site Name</th>
                                    <th scope="col">Site ID</th>
                                    <th scope="col">Retribusi</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Action</th>
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


    <div class="modal fade" id="modal_add_retribusi" tabindex="-1" data-bs-backdrop="static" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Retribusi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Site Operator</label>
                            <div class="col-sm-8">
                                <select name="id_site_operator" id="id_site_operator" class="form-select">
                                    <option value="">-- Pilih Site Operator --</option>
                                    @foreach ($data_site as $key => $value)
                                        <option value="{{ $value->id }}"> {{ $value->name }} - {{ $value->site_id }} -
                                            {{ $value->operators_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small id="id_site_operator_help" class="form-text"></small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Retribusi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="edit_id" id="edit_id">
                                <input type="text" class="form-control" name="retribusi" id="retribusi">
                                <small id="retribusi_help" class="form-text"></small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Tanggal</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="tanggal" id="tanggal">
                                <small id="tanggal_help" class="form-text"></small>
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

    <div class="modal fade" id="modal_edit_retribusi" tabindex="-1" data-bs-backdrop="static" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Operator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <label for="edit_id_site_operator" class="col-sm-4 col-form-label">Site Operator</label>
                            <div class="col-sm-8">
                                <select name="edit_id_site_operator" id="edit_id_site_operator" class="form-select">
                                    <option value="">-- Pilih Site Operator --</option>
                                    @foreach ($data_site as $key => $value)
                                        <option value="{{ $value->id }}"> {{ $value->name }} - {{ $value->site_id }} -
                                            {{ $value->operators_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small id="id_site_operator_help" class="form-text"></small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="edit_retribusi" class="col-sm-4 col-form-label">Retribusi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="edit_retribusi" id="edit_retribusi">
                                <small id="edit_retribusi_help" class="form-text"></small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="edit_tanggal" class="col-sm-4 col-form-label">Tanggal</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="edit_tanggal" id="edit_tanggal">
                                <small id="tanggal_help" class="form-text"></small>
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

    <div class="modal fade" id="modal_delete_retribusi" tabindex="-1" data-bs-backdrop="static" role="dialog">
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
    @include('admin.retribusi.js_retribusi')
@endpush
