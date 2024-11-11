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
@vite('resources/assets/js/app-data-bangkom.js') <!-- Create this JS file for specific scripts if necessary -->
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Data Bangkom</h5>
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
@endsection

