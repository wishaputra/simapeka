@extends('layouts/layoutMaster')

@section('title', 'Data Bangkom - Pages')

@section('vendor-style')
@vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

@section('vendor-script')
@vite([
    'resources/assets/vendor/libs/moment/moment.js',
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/cleavejs/cleave.js',
    'resources/assets/vendor/libs/cleavejs/cleave-phone.js'
])
@endsection

@section('page-script')
@vite('resources/assets/js/app-data-bangkom.js')
@endsection

@php
    use Illuminate\Support\Facades\Auth;
@endphp

@section('content') 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<!-- Begin Page Content -->
<div class="container">
        <div class="card shadow h-100">
        <div class="card-header">
            <h5 class="m-0 pt-1 font-weight-bold float-left">Daftar Bangkom</h5>
            <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addModal" title="Buat Formulir">
                <i class="fas fa-plus"></i>
            </button>
            <h5 class="m-0 pt-1 font-weight-bold float-right mr-2">Tambah Bangkom</h5>
        </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Rencana Pengembangan Kompetensi Teknis</th>
                                <th>Perangkat Daerah</th>
                                <th>Unit Kerja</th>
                                <th>Tahun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTables will automatically populate this section -->
                        </tbody>
                    </table>                    
                </div>
            </div>
        </div>
    </div>


<!-- Modal for Adding Diklat -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Daftar Bangkom</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('data_bangkom.store') }}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="nama_diklat" class="float-right col-form-label">Nama Bangkom</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control @error('nama_diklat') is-invalid @enderror" id="nama_diklat" name="nama_diklat" required>
                            @error('nama_diklat') 
                                <span class="invalid-feedback" role="alert">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="unit_kerja" class="float-right col-form-label">Perangkat Daerah</label>
                        </div>
                        <div class="col-sm-8">
                            <select class="form-control @error('unit_kerja') is-invalid @enderror" id="unit_kerja" name="unit_kerja" required>
                                <option value="">-- Pilih Perangkat Daerah --</option>
                                @foreach($unit_kerjas as $unit_kerja)
                                    @if (Auth::user()->id_role == 1)
                                        <option value="{{ $unit_kerja->unit_kerja }}">{{ $unit_kerja->unit_kerja }}</option>
                                    @else
                                        <option readonly value="{{ $pegawai->unit_kerja }}">{{ $pegawai->unit_kerja }}</option>
                                        @break
                                    @endif
                                @endforeach
                            </select>
                            @error('unit_kerja') 
                                <span class="invalid-feedback" role="alert">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="id_uptd" class="float-right col-form-label">Nama Unit Kerja</label>
                        </div>
                        <div class="col-sm-8">
                            <select class="form-control @error('id_uptd') is-invalid @enderror" id="id_uptd" name="uptd">
                                <option value="">-- Pilih Nama Unit Kerja --</option>
                                @if (Auth::user()->id_role == 2)
                                    @foreach($uptds as $uptd)
                                        <option value="{{ $uptd->uptd }}">{{ $uptd->uptd }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('id_uptd') 
                                <span class="invalid-feedback" role="alert">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="tahun" class="float-right col-form-label">Tahun</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" required>
                            @error('tahun') 
                                <span class="invalid-feedback" role="alert">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row justify-content-end">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-success btn-block">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</div>

<!-- Modal for Editing Diklat -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Daftar Bangkom</h5>
            </div>
            <div class="modal-body">
                <form id="editForm" action="#" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group row">
                        <label for="edit_nama_diklat" class="col-sm-4 col-form-label">Nama Bangkom</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edit_nama_diklat" name="nama_diklat" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_unit_kerja" class="col-sm-4 col-form-label">Perangkat Daerah</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edit_unit_kerja" name="unit_kerja" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_uptd" class="col-sm-4 col-form-label">Nama Unit Kerja</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edit_uptd" name="uptd">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_tahun" class="col-sm-4 col-form-label">Tahun</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edit_tahun" name="tahun" required>
                        </div>
                    </div>
                    <div class="form-group row justify-content-end">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-success btn-block">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



 


@endsection