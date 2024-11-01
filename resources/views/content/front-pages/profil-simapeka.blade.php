@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Profil SIMAPEKA - Detailed')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
    'resources/assets/vendor/libs/nouislider/nouislider.scss',
    'resources/assets/vendor/libs/swiper/swiper.scss'
])
@endsection

<!-- Page Styles -->
@section('page-style')
@vite(['resources/assets/vendor/scss/pages/front-page-detail.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
    'resources/assets/vendor/libs/nouislider/nouislider.js',
    'resources/assets/vendor/libs/swiper/swiper.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/assets/js/front-page-detail.js'])
@endsection

@section('content')
<div class="container my-12">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="display-4">Profil SIMAPEKA</h1>
        <p class="lead">Pelajari lebih lanjut tentang misi, tujuan, dan fitur utama dari platform SIMAPEKA.</p>
    </div>

    <!-- Introduction Section -->
    <section class="mb-12">
        <h2 class="mb-4">Maksud dan Tujuan</h2>
        <p class="lead">SIMAPEKA bertujuan untuk meningkatkan kualitas dan kuantitas pelatihan yang diterima oleh PNS.
            Program ini membantu memastikan relevansi pelatihan dengan kebutuhan organisasi, serta mendorong pegawai
            untuk terus mengembangkan kompetensinya.</p>
        <p>Dengan SIMAPEKA, setiap PNS dapat secara mandiri mengakses berbagai program pelatihan yang tersedia,
            mengikuti modul-modul terstruktur, dan mencapai peningkatan karir yang signifikan.</p>
    </section>

    <!-- Objective Section -->
    <section class="mb-5">
        <h2 class="mb-4">Tujuan Didirikannya SIMAPEKA</h2>
        <p class="lead">SIMAPEKA didirikan untuk menciptakan sistem pengelolaan pelatihan yang lebih efisien,
            menyediakan akses mudah bagi PNS untuk berpartisipasi dalam pelatihan, dan menciptakan lingkungan
            pembelajaran yang produktif serta menyenangkan.</p>
        <p>Dengan SIMAPEKA, organisasi dapat meningkatkan kinerja melalui pelatihan yang terstruktur, mempercepat
            pengembangan kompetensi, dan mendukung kolaborasi antar pegawai.</p>
    </section>

    <!-- Features Section -->
    <section class="mb-5">
        <h2 class="mb-4">Fitur Utama SIMAPEKA</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-box text-center p-4 shadow-sm rounded">
                    <h3>Pengembangan Mandiri</h3>
                    <p>Pilih modul pelatihan yang sesuai dengan kebutuhan pribadi, kapan saja dan di mana saja.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-box text-center p-4 shadow-sm rounded">
                    <h3>Pengembangan Terprogram</h3>
                    <p>Jalur pembelajaran yang terstruktur dan terarah, mendukung pengembangan kompetensi terprogram.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-box text-center p-4 shadow-sm rounded">
                    <h3>Berbagi Pengetahuan</h3>
                    <p>Mendorong kolaborasi antar peserta untuk berbagi pengalaman dan pengetahuan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="text-center py-5 bg-light">
        <h2 class="mb-4">Mulai Tingkatkan Karir Anda Sekarang!</h2>
        <p class="lead">Jangan lewatkan kesempatan untuk meningkatkan kompetensi dan membawa karir Anda ke level
            berikutnya.</p>
        <a href="{{ url('auth/login-basic') }}" class="btn btn-lg btn-primary">Login Sekarang</a>
    </section>
</div>
@endsection