@extends('layouts/layoutMaster')

@section('title', 'Profile')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/apex-charts/apexcharts.js',
]) 
@endsection
 
@section('page-script')
@vite('resources/assets/js/profile.js')
@endsection

@php
    use Illuminate\Support\Facades\Auth;
@endphp


@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow h-100">
            <div class="card-header">
                <h5 class="m-0 pt-1 font-weight-bold">Profil</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('update-profil', Auth::user()->id) }}" method="post" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-2"><label for="nip" class="col-form-label">NIP</label></div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ Auth::user()->nip }}" readonly>
                            @error('nip') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2"><label for="name" class="col-form-label">Nama</label></div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $pegawai->nama }}" readonly>
                            @error('name') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2"><label for="jabatan" class="col-form-label">Jabatan</label></div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $pegawai->jabatan }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2"><label for="unit_kerja" class="col-form-label">Perangkat Daerah</label></div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('unit_kerja') is-invalid @enderror" id="unit_kerja" name="unit_kerja" value="{{ $pegawai->unit_kerja }}" readonly>
                            @error('unit_kerja') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2"><label for="uptd" class="col-form-label">Unit Kerja</label></div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('uptd') is-invalid @enderror" id="uptd" name="uptd" value="{{ $pegawai->uptd }}" readonly>
                            @error('uptd') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </form>
                <div class="form-group row justify-content-end">
                    <div class="col-sm-10">
                        <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#gantiPasswordModal">
                            Change Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ganti Password Modal -->
<div class="modal fade" id="gantiPasswordModal" tabindex="-1" role="dialog" aria-labelledby="gantiPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gantiPasswordModalLabel">Ganti Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update-password', ['user' => Auth::user()->nip]) }}" method="POST">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label for="password">Password Lama</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="password_baru">Password Baru</label>
                        <input type="password" class="form-control @error('password_baru') is-invalid @enderror" id="password_baru" name="password_baru">
                        @error('password_baru')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="konfirmasi_password">Konfirmasi Password</label>
                        <input type="password" class="form-control @error('konfirmasi_password') is-invalid @enderror" id="konfirmasi_password" name="konfirmasi_password">
                        @error('konfirmasi_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
                        <label class="form-check-label" for="showPassword">Show Password</label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

