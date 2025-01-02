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
   /* Header styling */
.display-2 {
    font-size: 2.5rem;
    color: #00b894;
    font-weight: bold;
    margin-top: 2rem;
    padding-bottom: 1rem;
    position: relative;
    z-index: 1;
}

.main-header {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
}

/* Description text styling */
.description-text {
    font-size: 1.1rem;
    line-height: 1.6;
    color: #555;
}

/* Button styling */
.button-group .btn {
    padding: 0.5rem 1.25rem;
    font-size: 0.9rem;
}

/* Image styling */
.illustration {
    max-width: 100%;
    border-radius: 15px;
}

.jabatan-card img {
    max-width: 80px;
    height: auto;
    margin-bottom: 1rem;
}

/* Container styling */
.container {
    max-width: 800px;
}

/* Main header */
h1.text-center {
    font-size: 2.5rem;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    text-transform: uppercase;
}

/* Section Styling */
.detail-section, .kompetensi-section, .potensi-section, .method-section, .jabatan-section {
    background-color: #f8f9fa;
    padding: 2rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}

.detail-section:hover, .potensi-card:hover, .jabatan-card:hover, .competence-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Section Title */
h2.text-secondary, .kompetensi-section h2, .potensi-section h2 {
    font-size: 1.75rem;
    font-weight: bold;
    color: #00b894;
    margin-bottom: 1rem;
}

/* Method Title */
.method-title {
    font-size: 1.5rem;
    text-align: left;
    border-bottom: 3px solid #3498db;
    display: inline-block;
    padding-bottom: 5px;
    position: relative;
    margin-bottom: 1.5rem;
}

.method-title::after {
    content: "";
    display: block;
    width: 50px;
    height: 3px;
    background-color: #00b894;
    margin-top: 8px;
    border-radius: 2px;
}

/* List Styling */
.list-unstyled li {
    display: flex;
    align-items: center;
    font-size: 1rem;
    color: #34495e;
}

.list-unstyled li i {
    color: #00b894;
    margin-right: 10px;
    font-size: 1.25rem;
}

.list-with-dash li::before {
    content: "- ";
    color: #00b894;
    font-weight: bold;
}

/* Text and Color Adjustments */
.text-teal {
    color: #00b894;
}

.text-primary {
    color: #3498db;
}

.text-muted {
    color: #6c757d;
}

/* General Card Styling */
.method-card, .jabatan-card, .potensi-card, .competence-card {
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 1.25rem;
    transition: transform 0.3s ease;
}

/* Competence List Styling */
.kompetensi-list h5 {
    font-weight: bold;
    color: #00b894;
}

.kompetensi-list ul {
    font-size: 0.9rem;
    color: #555;
    list-style-type: none;
}

.kompetensi-list ul li {
    position: relative;
    padding-left: 25px;
    margin-bottom: 0.5rem;
}

/* Custom Bullet */
.kompetensi-list ul li::before {
    content: '•';
    position: absolute;
    left: 0;
    color: #00b894;
    font-size: 1.2rem;
}

/* Number, Title, and Description styling */
.number {
    font-size: 1.5rem;
    font-weight: bold;
    color: #00b894;
    margin-bottom: 0.5rem;
}

.title {
    font-size: 1rem;
    font-weight: 600;
    color: #333;
}

.description {
    font-size: 0.875rem;
    color: #666;
}

/* Shadow and Rounded Corners */
.shadow-sm {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
}

.rounded {
    border-radius: 8px;
}

.detail-section {
        background: #ffffff; /* White background for detail sections */
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Light shadow */
        transition: transform 0.3s;
    }

    .detail-section:hover {
        transform: scale(1.02); /* Slight enlarge on hover */
    }

    h2.text-secondary {
        font-size: 1.5rem; /* Adjust heading size */
        font-weight: bold;
        color: #00b894; /* Custom color */
        margin-bottom: 1rem; /* Space below the heading */
    }

    .detail-section p {
        color: #555; /* Text color */
        line-height: 1.6; /* Better spacing */
    }

/* Standar Kompetensi Manajerial Table */
table {
    width: 150%;
}

    
</style>


@section('content')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
<div class="container mt-5 pt-5 pb-5">
<div class="spacer" style="height: 10rem;"></div>
<!-- Main Header -->
<h1 class="main-header text-center mb-3">Detail Pelatihan SIMAPEKA</h2>

<!-- Description and Illustration Section -->
<div class="row align-items-center">
    <div class="col-md-6">
        <p class="description-text">
            Penilaian Kompetensi (Perka BKN 26/2019) adalah suatu proses
            pembandingan kompetensi yang dimiliki Pegawai dengan
            jabatannya yang dipersyaratkan dengan menggunakan
            metode Assessment Center atau metode penilaian lainnya.
        </p>

        <!-- Buttons -->
        <div class="button-group mt-3">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>
    <div class="col-md-6 text-center">
        <img src="{{ asset('assets/img/illustrations/PNS5.png') }}" alt="Asesmen Illustration" class="img-fluid illustration">
    </div>
</div>

<section>
<div class="container mt-5 pt-5">
    <h3 class="method-title text-primary font-weight-bold mb-4">Tujuan Penilaian Kompetensi</h1>

    <div class="row">
        <!-- Penetapan Section -->
        <div class="col-md-6 mb-4">
            <div class="detail-section p-4 shadow-sm rounded">
                <h2 class="text-secondary">Penetapan</h2>
                <p>Asesmen yang bertujuan untuk mengetahui profil kompetensi seseorang sesuai Standar Kompetensi Jabatan (SKJ) pada jabatan yang sedang diduduki sehingga dapat dilakukan program pengembangan kompetensi yang tepat individu bersangkutan. Misalnya, Asesmen dalam Pemetaan Kompetensi Jabatan Administrator, Pengawas, Pelaksana, dan Fungsional.</p>
            </div>
        </div>

        <!-- Pengisian Jabatan Section -->
        <div class="col-md-6 mb-4">
            <div class="detail-section p-4 shadow-sm rounded">
                <h2 class="text-secondary">Pengisian Jabatan</h2>
                <p>Asesmen yang bertujuan untuk mengukur kompetensi individu yang siap menduduki jabatan target tertentu. Misalnya, Asesmen dalam rangka Seleksi Terbuka.</p>
            </div>
        </div>
    </div>
</div>
</section>


    <!-- Metode Penilaian Kompetensi Section -->
<section class="method-section py-5">
    <div class="container">
        <!-- Section Title -->
        <h2 class="method-title text-primary font-weight-bold mb-4">Metode Penilaian Kompetensi</h2>
        
        <!-- Assessment Center Section -->
        <div class="method-card mb-4 p-4 rounded shadow-sm">
            <h4 class="text-teal font-weight-bold">Assessment Center</h4>
            <p>
                Metode terstandar yang dilakukan untuk mengukur kompetensi dan prediksi keberhasilan pegawai dalam suatu jabatan dengan menggunakan beberapa alat ukur atau simulasi berdasarkan kompetensi jabatan dan dilakukan oleh beberapa orang Assessor. Metode ini dapat dilakukan untuk seluruh jabatan.
            </p>
        </div>
        
        <!-- Other Methods Section -->
        <div class="method-card p-4 rounded shadow-sm">
            <h4 class="text-teal font-weight-bold">Metode Penilaian Lainnya</h4>
            <p>
                Metode selain metode Assessment Center yang digunakan dalam penilaian kompetensi pengetahuan peserta secara langsung dan dapat dilakukan dengan cara tertentu.
            </p>
        </div>
    </div>
</section>

<!-- Jabatan Section -->
<section class="jabatan-section py-5">
    <div class="container">
        <div class="row d-flex align-items-stretch">
            <!-- Jabatan Administrasi Card -->
            <div class="col-md-4 mb-4">
                <div class="jabatan-card p-4 rounded shadow-sm text-center h-100">
                    <img src="assets/img/illustrations/PNS3.png" alt="Jabatan Administrasi" class="img-fluid mb-3">
                    <h4 class="text-teal font-weight-bold">Jabatan Manajerial</h4>
                    <ul class="list-unstyled list-with-dash text-muted">
                        <li>Jabatan Pimpinan Tinggi</li>
                        <li>Jabatan Administrator</li>
                        <li>Jabatan Pengawas</li>
                    </ul>
                </div>
            </div>

            <!-- Jabatan Fungsional Keahlian Card -->
            <div class="col-md-4 mb-4">
                <div class="jabatan-card p-4 rounded shadow-sm text-center h-100">
                    <img src="assets/img/illustrations/PNS4.png" alt="Jabatan Fungsional Keahlian" class="img-fluid mb-3">
                    <h4 class="text-teal font-weight-bold">Jabatan Fungsional Ahli</h4>
                    <ul class="list-unstyled list-with-dash text-muted">
                        <li>JF Ahli Pertama</li>
                        <li>JF Ahli Muda</li>
                        <li>JF Ahli Madya</li>
                        <li>JF Ahli Utama</li>
                    </ul>
                </div>
            </div>

            <!-- Jabatan Fungsional Keterampilan Card -->
            <div class="col-md-4 mb-4">
                <div class="jabatan-card p-4 rounded shadow-sm text-center h-100">
                    <img src="assets/img/illustrations/PNS5.png" alt="Jabatan Fungsional Keterampilan" class="img-fluid mb-3">
                    <h4 class="text-teal font-weight-bold">Jabatan Fungsional Terampil</h4>
                    <ul class="list-unstyled list-with-dash text-muted">
                        <li>JF Pemula</li>
                        <li>JF Terampil</li>
                        <li>JF Mahir</li>
                        <li>JF Penyelia</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Potensi Section -->
<section class="potensi-section py-5">
    <div class="container">
        <h2 class="mb-4 text-teal font-weight-bold">Potensi</h2>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="potensi-card p-3 rounded shadow-sm text-center h-100">
                    <h4 class="number text-teal">01</h4>
                    <h6 class="title mb-2">Kemampuan Intelijensi</h6>
                    <p class="description">Mengukur dan mengelola kompetensi dalam situasi tertentu.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="potensi-card p-3 rounded shadow-sm text-center h-100">
                    <h4 class="number text-teal">02</h4>
                    <h6 class="title mb-2">Kemampuan Interpersonal</h6>
                    <p class="description">Menjalin hubungan dengan rekan kerja dan pihak lain.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="potensi-card p-3 rounded shadow-sm text-center h-100">
                    <h4 class="number text-teal">03</h4>
                    <h6 class="title mb-2">Kecerdasan Emosional</h6>
                    <p class="description">Memahami dan mengelola emosi diri sendiri dan orang lain.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="potensi-card p-3 rounded shadow-sm text-center h-100">
                    <h4 class="number text-teal">04</h4>
                    <h6 class="title mb-2">Kemampuan Berpikir Kritis</h6>
                    <p class="description">Menghadapi masalah dengan pemikiran analitis.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="potensi-card p-3 rounded shadow-sm text-center h-100">
                    <h4 class="number text-teal">05</h4>
                    <h6 class="title mb-2">Kemampuan Memecahkan Masalah</h6>
                    <p class="description">Mencari solusi efektif dan efisien.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="potensi-card p-3 rounded shadow-sm text-center h-100">
                    <h4 class="number text-teal">06</h4>
                    <h6 class="title mb-2">Kemampuan Belajar Cepat</h6>
                    <p class="description">Beradaptasi dengan cepat terhadap informasi baru.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="potensi-card p-3 rounded shadow-sm text-center h-100">
                    <h4 class="number text-teal">07</h4>
                    <h6 class="title mb-2">Kemampuan Beradaptasi</h6>
                    <p class="description">Cepat beradaptasi dalam situasi yang berubah.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="potensi-card p-3 rounded shadow-sm text-center h-100">
                    <h4 class="number text-teal">08</h4>
                    <h6 class="title mb-2">Minat dan Komitmen</h6>
                    <p class="description">Menyelesaikan pekerjaan dengan komitmen tinggi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kompetensi Section -->
<section class="kompetensi-section py-5">
    <div class="container">
        <h2 class="mb-4 text-teal font-weight-bold">Kompetensi</h2>
        <div class="row">
            <!-- Competence List -->
            <div class="col-md-7">
                <div class="kompetensi-list mb-3">
                    <h5 class="text-success mb-3">Kompetensi Manajerial</h5>
                    <ul class="list-unstyled">
                        <li>Kepemimpinan di satu atau beberapa unit kerja.</li>
                        <li>Merumuskan, mengevaluasi, dan memetakan instansi.</li>
                    </ul>
                </div>
                <div class="kompetensi-list mb-3">
                    <h5 class="text-success mb-3">Kompetensi Sosial Kultural</h5>
                    <ul class="list-unstyled">
                        <li>Mampu menyesuaikan diri dengan kebudayaan di lingkungan kerja.</li>
                        <li>Membangun komunikasi efektif dan sinergi tim.</li>
                    </ul>
                </div>
                <div class="kompetensi-list">
                    <h5 class="text-success mb-3">Kompetensi Teknis</h5>
                    <ul class="list-unstyled">
                        <li>Penguasaan teknis bidang pekerjaan.</li>
                        <li>Pengembangan inovasi dan kreativitas di bidang pekerjaannya.</li>
                    </ul>
                </div>
            </div>
            
            <!-- Visualization -->
            <div class="col-md-5 text-center">
                <img src="assets/img/illustrations/tablet.png" alt="Illustration" class="img-fluid">
            </div>
        </div>

        <!-- Competence Highlight Card List -->
        <div class="row mt-4">
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="competence-card p-3 shadow-sm text-center rounded">
                    <h4 class="number text-teal">01</h4>
                    <h6 class="title">Integritas</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="competence-card p-3 shadow-sm text-center rounded">
                    <h4 class="number text-teal">02</h4>
                    <h6 class="title">Kerja Sama</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="competence-card p-3 shadow-sm text-center rounded">
                    <h4 class="number text-teal">03</h4>
                    <h6 class="title">Orientasi pada Hasil</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="competence-card p-3 shadow-sm text-center rounded">
                    <h4 class="number text-teal">04</h4>
                    <h6 class="title">Pelayanan Publik</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="competence-card p-3 shadow-sm text-center rounded">
                    <h4 class="number text-teal">05</h4>
                    <h6 class="title">Mengelola Perubahan</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="competence-card p-3 shadow-sm text-center rounded">
                    <h4 class="number text-teal">06</h4>
                    <h6 class="title">Pengambilan Keputusan</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="competence-card p-3 shadow-sm text-center rounded">
                    <h4 class="number text-teal">07</h4>
                    <h6 class="title">Komunikasi</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="competence-card p-3 shadow-sm text-center rounded">
                    <h4 class="number text-teal">08</h4>
                    <h6 class="title">Perekat Bangsa</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Standar Kompetensi Manajerial  -->
<section>
<div class="container mt-5 pt-5">
    <h4 class="method-title text-primary font-weight-bold mb-4">Standar Kompetensi Manajerial dan Sosial Kultural Penerapan Kompetensi ASN Jabatan Pimpinan Tinggi dan Administrator</h4>
    <p>Permenpan RB Nomor 38 Tahun 2017 tentang Standar Kompetensi Jabatan PNS</p>
    
    <div clasble-responsive">
        <table id="myTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kompetensi</th>
                    <th class="text-center">Jabatan Manajerial</th>
                    <th colspan="3" class="text-center">Jabatan Administrasi</th> <!-- Group Header -->
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th>JPTP</th>
                    <th>Administrator</th>
                    <th>Pengawas</th>
                    <th>Pelaksana</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Integritas</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Kepercayaan</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Komunikasi</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Orientasi Pada Hasil</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Pelayanan Publik</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Mengelola Perubahan</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Pengambilan Keputusan</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Perekat Bangsa</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
              
                </tr>
            </tbody>
        </table>
    </div>
</div>
</section>


<!-- Standar Kompetensi Manajerial Tingkat Keahlian Dan Keterampilan  -->
<section>
<div class="container mt-5 pt-5">
    <h4 class="method-title text-primary font-weight-bold mb-4">Standar Kompetensi Manajerial dan Sosial Kultural Penilaian Kompetensi ASN Jabatan Fungsional Tingkat Ahli Dan Terampil</h4>
    <p>Permenpan RB Nomor 38 Tahun 2017 tentang Standar Kompetensi Jabatan PNS</p>
    
    <div clasble-responsive">
        <table id="myTable" class="table table-striped table-hover">
            <thead>
            <tr>
                    <th>#</th>
                    <th>Kompetensi</th>
                    <th colspan="3" class="text-center">Jabatan Fungsional Ahli</th>
                    <th colspan="4" class="text-center">Jabatan Fungsional Terampil</th> <!-- Group Header -->
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Madya</th>
                    <th>Muda</th>
                    <th>Pertama</th>
                    <th>Penyelia</th>
                    <th>Mahir</th>
                    <th>Terampil</th>
                    <th>Pemula</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="background-color: lightgreen;"></td>
                    <td class="text-white mb-3" style="background-color: lightgreen;">Manajerial</td>
                    <td style="background-color: lightgreen;"></td>
                    <td style="background-color: lightgreen;"></td>
                    <td style="background-color: lightgreen;"></td>
                    <td style="background-color: lightgreen;"></td>
                    <td style="background-color: lightgreen;"></td>
                    <td style="background-color: lightgreen;"></td>
                    <td style="background-color: lightgreen;"></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Integritas</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>3</td>
                    <td>2</td>
                    <td>2</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Kerjasama</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>3</td>
                    <td>2</td>
                    <td>2</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Komunikasi</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Orientasi Pada Hasil</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Pelayanan Publik</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Pengembangan Diri dan Orang Lain</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Mengelola Perubahan/td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Pengambilan Keputusan</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
                    <td>1</td>           
                </tr>
                <tr>
                    <td style="background-color: lightgreen;"></td>
                    <td class="text-white mb-3" style="background-color: lightgreen;">Kompetensi Sosial Kultural</td>
                    <td style="background-color: lightgreen;"></td>
                    <td style="background-color: lightgreen;"></td>
                    <td style="background-color: lightgreen;"></td>
                    <td style="background-color: lightgreen;"></td>
                    <td style="background-color: lightgreen;"></td>
                    <td style="background-color: lightgreen;"></td>
                    <td style="background-color: lightgreen;"></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>Perekat Bangsa</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>3</td>
                    <td>2</td>
                    <td>2</td>
                    <td>1</td>           
                </tr>
            </tbody>
        </table>
    </div>
</div>
</section>


    </div>

@endsection
