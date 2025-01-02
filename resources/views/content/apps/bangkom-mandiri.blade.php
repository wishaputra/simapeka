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
@vite('resources/assets/js/bangkom-mandiri.js')
@endsection

@php
    use Illuminate\Support\Facades\Auth;
@endphp


@section('content')
<!-- Begin Page Content -->
<div class="container">
    <div class="card shadow h-100">
        <div class="card-header">
            <h5 class="m-0 pt-1 font-weight-bold float-left">Bangkom Mandiri</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-2"><b>Nama</b></div>
                <div class="col-lg-10"><b>{{ $pegawai->nama }}</b></div>
            </div>
            <div class="row">
                <div class="col-lg-2"><b>NIP</b></div>
                <div class="col-lg-10"><b>{{ Auth::user()->nip }}</b></div>
            </div>
            <div class="row">
                <div class="col-lg-2"><b>Jabatan</b></div>
                <div class="col-lg-10"><b>{{ $pegawai->jabatan }}</b></div>
            </div>
            <div class="row">
                <div class="col-lg-2"><b>Perangkat Daerah</b></div>
                <div class="col-lg-10"><b>{{ $pegawai->unit_kerja }}</b></div>
            </div>
            <div class="row">
                <div class="col-lg-2"><b>Unit Kerja</b></div>
                <div class="col-lg-10"><b>{{ $pegawai->uptd }}</b></div>
            </div>
        </div>
    </div>

    <div class="card shadow h-100 mt-4">
        <div class="card-header">
            @php
                use Carbon\Carbon;
                $currentDate = Carbon::now();
                $compareDate = Carbon::create(2025, 11, 11);
            @endphp
            @if ($currentDate->greaterThan($compareDate))
                <h3 class="m-0 pt-1 font-weight-bold text-center"><span style="color: red">Pengisian Data Bangkom Sudah Ditutup </span></h3>
            @else
                <h5 class="m-0 pt-1 font-weight-bold float-left">Daftar Bangkom</h5>
            @endif
        </div>
        <div class="card-body">
            @if ($currentDate->greaterThan($compareDate))
                <iframe src="{{ asset('storage/files/surat_sekda.pdf') }}" width="100%" height="600px"></iframe>
            @else
                <form id="diklat-form">
                    @csrf
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Rencana Pengembangan Kompetensi Teknis</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTables will automatically populate this section -->
                            </tbody>
                        </table>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection

