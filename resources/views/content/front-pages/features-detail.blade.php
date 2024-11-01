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

@section('content')
<div class="container mt-12">
    <h1 class="text-center mb-5">Detail Pelatihan SIMAPEKA</h1>

    <section class="mb-10">
        <h2>Pengembangan Mandiri</h2>
        <p>Pengembangan Mandiri menawarkan peserta pelatihan kesempatan untuk meningkatkan keterampilan pribadi mereka
            pada kecepatan masing-masing. Pelatihan ini dirancang untuk memfasilitasi pembelajaran individu yang
            proaktif, dengan modul yang dapat diakses kapan saja. Peserta dapat memilih dari berbagai topik sesuai
            kebutuhan dan minat profesional mereka.</p>
        <ul>
            <li>Mengakses modul pelatihan yang beragam dan interaktif.</li>
            <li>Menetapkan tujuan pembelajaran yang dapat disesuaikan dengan kebutuhan pribadi.</li>
            <li>Belajar dengan kecepatan dan waktu yang sesuai.</li>
        </ul>
    </section>

    <section class="mb-5">
        <h2>Pengembangan Terprogram</h2>
        <p>Pengembangan Terprogram memberikan jalur pembelajaran yang terstruktur dan terarah. Program ini mencakup
            kursus terjadwal dengan instruksi yang dipandu oleh para ahli dalam bidang tersebut. Peserta pelatihan
            diajak untuk mengikuti jadwal yang telah ditetapkan untuk memastikan pencapaian keterampilan yang
            diharapkan.</p>
        <ul>
            <li>Jadwal kursus yang telah ditentukan mengikuti standar industri.</li>
            <li>Instruksi dipandu oleh ahli dan profesional berpengalaman.</li>
            <li>Evaluasi dan feedback reguler untuk memonitor perkembangan peserta.</li>
        </ul>
    </section>

    <section class="mb-5">
        <h2>Berbagi Pengetahuan</h2>
        <p>Berbagi Pengetahuan berfokus pada kolaborasi dan pertukaran ide di antara peserta pelatihan. Melalui sesi
            interaktif, pelatihan ini mendorong diskusi dan berbagi pengalaman berharga yang dapat memperkaya pemahaman
            kolektif. Ini adalah platform di mana peserta dapat belajar dari satu sama lain dan mengembangkan jaringan
            profesional mereka.</p>
        <ul>
            <li>Sesi kolaborasi dan kelompok diskusi.</li>
            <li>Berbagi pengalaman dan metode terbaik.</li>
            <li>Membangun jaringan dan hubungan profesional yang kuat.</li>
        </ul>
    </section>

</div>
@endsection