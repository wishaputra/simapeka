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
@endsection

<style>
    .text-center {
        clear: both;
        padding-top: 2rem;
        margin-bottom: 2rem;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .display-2 {
        font-size: 2.5rem;
        color: #00b894;
        font-weight: bold;
        margin-top: 2rem;
        padding-bottom: 1rem;
        position: relative;
        z-index: 1;
    }

    .lead {
        font-size: 1.25rem;
        line-height: 1.6;
        color: #555;
        max-width: 750px;
        margin: 0 auto; /* Center lead text */
    }

    q {
        quotes: "“" "”" "‘" "’";
        font-style: italic;
        display: block;
        margin: 20px auto;
        width: 85%;
        max-width: 800px;
        color: #666;
        font-size: 1.1rem;
        background-color: #f0f9f9;
        padding: 15px;
        border-radius: 8px;
    }

    .feature-box {
        background-color: #ffffff;
        min-height: 280px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        border-radius: 10px;
        text-align: center;
        padding: 30px;
    }

    .feature-box:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        transform: translateY(-8px);
        background-color: #f4fcfc; /* Light background on hover */
    }

    .icon-wrapper {
        text-align: center;
        background-color: #e6f7f7;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: #008080;
    }

    h2.section-title {
        color: #005555;
        font-weight: bold;
        font-size: 1.75rem;
        text-transform: uppercase;
        margin-bottom: 25px;
    }
</style>

@section('content')
<div class="container my-12">
    <!-- Page Header -->
    <div class="text-center mb-11">
        <h1 class="display-2">SIMAPEKA</h1>
        <p class="lead mb-4">
            <q>SIMAPEKA adalah sistem pembelajaran inovatif yang dirancang untuk mendukung pengembangan kompetensi ASN secara berkelanjutan. Melalui pendekatan pembelajaran yang terintegrasi, sistem ini menggabungkan self-learning, pembelajaran kolaboratif, dan pembelajaran berbasis pengalaman untuk mempersiapkan ASN menghadapi tantangan pekerjaan dan menguasai keterampilan yang dibutuhkan.</q>
        </p>
    </div>

    <!-- Objectives Section -->
    <section class="mb-5">
        <h2 class="section-title text-left">Tujuan Kami</h2>
        <div class="row justify-content-center">
            <!-- First Feature Box -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-box">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-lightbulb fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-teal">Arah Strategis</h4>
                    <p class="text-muted">Mendorong strategi transformasi pelatihan ASN agar sejalan dengan perkembangan teknologi dan tuntutan profesionalisme, memastikan setiap ASN memiliki keterampilan yang relevan dan terkini.</p>
                </div>
            </div>

            <!-- Second Feature Box -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-box">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-teal">Pengembangan Kapasitas</h4>
                    <p class="text-muted">Meningkatkan kompetensi ASN dalam bidang spesifik dan soft skills, sehingga mereka dapat memberikan pelayanan publik yang berkualitas tinggi dan efektif.</p>
                </div>
            </div>

            <!-- Third Feature Box -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-box">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-comments fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-teal">Budaya Kolaborasi</h4>
                    <p class="text-muted">Membangun ekosistem berbagi pengetahuan dan pengalaman di antara ASN, sehingga memperkuat jaringan profesional dan memperkaya wawasan secara kolektif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Phases Section -->
    <section class="mb-5">
        <h2 class="section-title text-left">Tahapan Pembelajaran</h2>
        <div class="row justify-content-center">
            <!-- First Phase Box -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-box">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-teal">Identifikasi Kebutuhan</h4>
                    <p class="text-muted">Mengidentifikasi kebutuhan kompetensi spesifik untuk berbagai peran ASN, sehingga setiap pelatihan dapat disesuaikan dengan kebutuhan aktual di lapangan.</p>
                </div>
            </div>

            <!-- Second Phase Box -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-box">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-cogs fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-teal">Pengembangan Program</h4>
                    <p class="text-muted">Menyusun program pelatihan terstruktur yang dirancang berdasarkan hasil identifikasi, sehingga memberikan pelatihan yang relevan dan praktis bagi ASN.</p>
                </div>
            </div>

            <!-- Third Phase Box -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-box">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-teal">Evaluasi dan Pengembangan</h4>
                    <p class="text-muted">Melakukan evaluasi terhadap efektivitas program pelatihan dan memberikan perbaikan berkelanjutan untuk meningkatkan kualitas serta hasil dari setiap sesi pelatihan.</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
