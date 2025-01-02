@extends('layouts/layoutMaster')

@section('title', 'User List - Pages')

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
@vite('resources/assets/js/bangkom-bawahan.js')
@endsection

@php
    use Illuminate\Support\Facades\Auth;
@endphp

@section('content')
<!-- Begin Page Content -->
<div class="container">
    <div class="card shadow h-100">
        <div class="card-header">
            @php
                use Carbon\Carbon;
                $currentDate = Carbon::now();
                $compareDate = Carbon::create(2025, 11, 11);
            @endphp
            @if ($currentDate->greaterThan($compareDate))
                <h3 class="m-0 pt-1 font-weight-bold text-center"><span style="color: red">Pengisian Data Bangkom Sudah Ditutup</span></h3>
            @else
                <h5 class="m-0 pt-1 font-weight-bold float-left">Bangkom Bawahan</h5>
            @endif
        </div>
        <div class="card-body">
            @if ($currentDate->greaterThan($compareDate))
                <iframe src="{{ asset('storage/files/surat_sekda.pdf') }}" width="100%" height="600px"></iframe>
            @else
                <div class="mt-4 table-responsive">
                    <table id="penilaianTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="4" style="color: green; text-align:center">Daftar Pegawai</th>
                            </tr>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- No data will be displayed here, as we're using AJAX to fetch data --}}
                        </tbody>
                    </table>                    
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

