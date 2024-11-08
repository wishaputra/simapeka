@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Landing - Front Pages')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
    'resources/assets/vendor/libs/nouislider/nouislider.scss',
    'resources/assets/vendor/libs/swiper/swiper.scss'
])
@endsection

<!-- Page Styles -->
@section('page-style')
@vite(['resources/assets/vendor/scss/pages/front-page-landing.scss'])
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
@vite(['resources/assets/js/front-page-landing.js'])
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
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
<div class="container mt-5 pt-5 pb-5">

    <!-- Main Heading -->
    <h1 class="text-center mb-5 display-4 text-primary font-weight-bold">Detail Pelatihan SIMAPEKA</h1>

    <!-- Pengembangan Mandiri Section -->
    <section class="mb-10 p-4 shadow-sm rounded" style="background: linear-gradient(135deg, #e0f7fa, #ffffff)
;           ">
        <h2 class="text-secondary font-weight-bold">Pengembangan Mandiri</h2>
        <p class="text-muted">Pengembangan Mandiri menawarkan peserta pelatihan kesempatan untuk meningkatkan keterampilan pribadi mereka
            pada kecepatan masing-masing. Pelatihan ini dirancang untuk memfasilitasi pembelajaran individu yang
            proaktif, dengan modul yang dapat diakses kapan saja. Peserta dapat memilih dari berbagai topik sesuai
            kebutuhan dan minat profesional mereka.</p>

                       <ul class="list-unstyled mt-3">

                           <li class="mb-2"><i class="ri-check-line text-primary me-2"></i> Mengakses modul pelatihan yang beragam 
d               an interaktif.</li>
            <li class="mb-2"><i class="ri-check-line text-primary me-2"></i> Menetapkan tujuan pembelajaran yang dapat disesuaikan dengan kebutuhan pribadi.</li>
            <li class="mb-2"><i class="ri-check-line text-primary me-2"></i> Belajar dengan kecepatan dan waktu yang sesuai.</li>
        </ul>
    </section>

    <!-- Pengembangan Terprogram Section -->
    <section class="mb-10 p-4 shadow-sm rounded" style="background: linear-gradient(135deg, #e0f2f1, #ffffff);">
           
        <h2 class="text-secondary font-weight-bold">Pengembangan Terprogram</h2>
        <p class="text-muted">Pengembangan Terprogram memberikan jalur pembelajaran yang terstruktur dan terarah. Program ini mencakup
            kursus terjadwal dengan instruksi yang dipandu oleh para ahli dalam bidang tersebut. Peserta pelatihan
            diajak untuk mengikuti jadwal yang telah ditetapkan untuk memastikan pencapaian keterampilan yang
            diharapkan.</p>

                       <ul class="list-unstyled mt-3">

                           <li class="mb-2"><i class="ri-check-line text-primary me-2"></i> Jadwal kursus yang telah ditentukan
                mengikuti standar industri.</li>
            <li class="mb-2"><i class="ri-check-line text-primary me-2"></i> Instruksi dipandu oleh ahli dan profesional berpengalaman.</li>
            <li class="mb-2"><i class="ri-check-line text-primary me-2"></i> Evaluasi dan feedback reguler untuk memonitor perkembangan peserta.</li>
        </ul>
    </section>

    <!-- Berbagi Pengetahuan Section -->
    <section class="mb-10 p-4 shadow-sm rounded" style="background: linear-gradient(135deg, #e8f5e9, #ffffff);"
           >
        <h2 class="text-secondary font-weight-bold">Berbagi Pengetahuan</h2>
        <p class="text-muted">Berbagi Pengetahuan berfokus pada kolaborasi dan pertukaran ide di antara peserta pelatihan. Melalui sesi
            interaktif, pelatihan ini mendorong diskusi dan berbagi pengalaman berharga yang dapat memperkaya pemahaman
            kolektif. Ini adalah platform di mana peserta dapat belajar dari satu sama lain dan mengembangkan jaringan
            profesional mereka.</p>
        <ul class="list-unstyled mt-3">
            <li class="mb-2"><i class="ri-check-line text-primary me-2"></i> Sesi kolaborasi dan kelompok diskusi.</li>

                           <li class="mb-2"><i class="ri-check-line text-primary me-2"></i> Berbagi pengalaman dan metode terbaik.</li>
            <li class="mb-2"><i class="ri-check-line text-primary me-2"></i> Membangun jaringan dan hubungan profesional yang kuat.</li>
        </ul>
    </section>

</div>
@endsection
