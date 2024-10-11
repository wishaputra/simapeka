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
  .features-icon img {
  width: 80px; /* Adjust this value as needed */
  height: auto; /* Maintain aspect ratio */
  max-width: 100%; /* Make sure image doesn't overflow its container */
}
.features-box {
    border: 1px solid #e0e0e0; /* Light gray border */
    border-radius: 8px; /* Rounded corners */
    background-color: #f9f9f9; /* Light background color */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* subtle shadow */
}

.features-icon {
    margin: 0 auto; /* Center content */
}

.btn-primary {
    margin-top: 1.5rem; /* Space above the button */
}

.section-py {
    padding-top: 40px; /* Adjust based on design */
    padding-bottom: 40px; /* Adjust based on design */
}


</style>

@section('content')
<div data-bs-spy="scroll" class="scrollspy-example">
<!-- Hero: Start -->
<section id="landingHero" class="section-py landing-hero position-relative">
    <img src="{{asset('assets/img/front-pages/backgrounds/hero-bg-'.$configData['style'].'.png') }}" alt="hero background" class="position-absolute top-0 start-0 w-100 h-100 z-n1" data-speed="1" data-app-light-img="front-pages/backgrounds/hero-bg-light.png" data-app-dark-img="front-pages/backgrounds/hero-bg-dark.png" />
    <div class="container">
      <div class="hero-text-box text-center">
        <h3 class="text-primary hero-title fs-2">Unlock Your Potential with Professional Training</h3>
        <h2 class="h6 mb-8">
          Transform your skills and elevate your career.<br />
          Join us in building a competent, future-ready workforce for the public sector.<br />
          SIMAPEKA is your gateway to continuous growth and success.<br />
        </h2>
        <a href="{{url('front-pages/landing')}}#landingFeatures" class="btn btn-lg btn-primary">Discover More</a>
      </div>
      <div class="position-relative hero-animation-img">
        <a href="{{url('front-pages/landing')}}#landingFeatures" target="_blank">
          <div class="hero-dashboard-img text-center">
            <img src="{{asset('assets/img/front-pages/landing-page/hero-dashboard-'.$configData['style'].'.png')}}" alt="hero dashboard" class="animation-img" data-speed="2" data-app-light-img="front-pages/landing-page/hero-dashboard-light.png" data-app-dark-img="front-pages/landing-page/hero-dashboard-dark.png" />
          </div>
          <div class="position-absolute hero-elements-img">
            <img src="{{asset('assets/img/front-pages/landing-page/hero-elements-'.$configData['style'].'.png')}}" alt="hero elements" class="animation-img" data-speed="4" data-app-light-img="front-pages/landing-page/hero-elements-light.png" data-app-dark-img="front-pages/landing-page/hero-elements-dark.png" />
          </div>
        </a>
      </div>
    </div>
</section>
<!-- Hero: End -->




  <!-- SIMAPEKA Features: Start -->
<section id="landingFeatures" class="section-py landing-features">
  <div class="container">
    <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
      <img src="{{asset('assets/img/front-pages/icons/section-tilte-icon.png')}}" alt="ikon judul bagian" class="me-3" />
      <span class="text-uppercase">Fitur SIMAPEKA</span>
    </h6>
    <h5 class="text-center mb-2">
      <span class="display-5 fs-4 fw-bold">Pengembangan diri</span> untuk PNS
    </h5>
    <p class="text-center fw-medium mb-4 mb-md-12">
      SIMAPEKA membentuk sumber daya manusia aparatur yang kompeten untuk pencapaian Visi Misi Pemerintah Kota Tangerang Selatan.
    </p>
    
    <!-- Features Box Start -->
    <div class="features-box p-4 border rounded">
      <div class="features-icon-wrapper row gx-0 gy-12 gx-sm-6">
        <div class="col-lg-4 col-sm-12 text-center features-icon-box">
          <div class="features-icon mb-4">
            <img src="{{asset('assets/img/front-pages/icons/mandiri.png')}}" alt="Pengembangan Mandiri" />
          </div>
          <h5 class="mb-2">Pengembangan Mandiri</h5>
          <p class="features-icon-description">
            Pengembangan Mandiri untuk meningkatkan keterampilan pribadi sesuai kecepatan Anda sendiri.
          </p>
        </div>
        <div class="col-lg-4 col-sm-12 text-center features-icon-box">
          <div class="features-icon mb-4">
            <img src="{{asset('assets/img/front-pages/icons/programmed.png')}}" alt="Pengembangan Terprogram" />
          </div>
          <h5 class="mb-2">Pengembangan Terprogram</h5>
          <p class="features-icon-description">
            Pengembangan Terprogram yang menyediakan jalur pembelajaran terstruktur.
          </p>
        </div>
        <div class="col-lg-4 col-sm-12 text-center features-icon-box">
          <div class="features-icon mb-4">
            <img src="{{asset('assets/img/front-pages/icons/berbagi.png')}}" alt="Berbagi Pengetahuan" />
          </div>
          <h5 class="mb-2">Berbagi Pengetahuan</h5>
          <p class="features-icon-description">
            Berbagi Pengetahuan untuk mendorong kolaborasi dan pembelajaran di antara rekan-rekan.
          </p>
        </div>
      </div>
      <!-- View More Link -->
      <div class="text-center mt-4">
        <a href="#" class="btn btn-primary">Lihat Selengkapnya</a>
      </div>
    </div>
    <!-- Features Box End -->
  </div>
</section>
<!-- SIMAPEKA Features: End -->

<!-- Profil SIMAPEKA: Start -->
<section id="profilSimapeka" class="section-py profil-simapeka">
  <div class="container">
    <!-- Title and icon -->
    <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
      <img src="{{asset('assets/img/front-pages/icons/section-tilte-icon.png')}}" alt="ikon judul bagian" class="me-3" />
      <span class="text-uppercase">Profil SIMAPEKA</span>
    </h6>

    <div class="d-flex align-items-center justify-content-between flex-column flex-lg-row">
      <div class="profil-image col-lg-6 text-center mb-4 mb-lg-0"> <!-- Moved image div first -->
        <img src="{{asset('assets/img/front-pages/landing-page/hero-dashboard-'.$configData['style'].'.png')}}" alt="Profil SIMAPEKA" class="img-fluid rounded" />
      </div>
      <div class="profil-text col-lg-6 text-center text-lg-start p-3">
        <h2 class="mb-4">Profil SIMAPEKA</h2>
        <p class="mb-4">
        SIMAPEKA (Sistem Manajemen Pengembangan Kompetensi ASN) merupakan platform yang dirancang untuk mendukung pengembangan kompetensi pegawai negeri sipil (PNS) di lingkungan Pemerintah Kota Tangerang. Melalui SIMAPEKA, pegawai dapat mengakses berbagai program pelatihan dan pengembangan yang sesuai dengan kebutuhan kinerja dan pengembangan diri. Platform ini juga berperan dalam memastikan bahwa pelaksanaan pelatihan dilakukan secara terintegrasi dan berkesinambungan, didukung dengan manajemen pengetahuan (knowledge management) yang bertujuan meningkatkan kompetensi, profesionalisme, dan efektivitas kerja PNS.
        </p>
        <a href="#" class="btn btn-lg btn-primary">Selengkapnya</a>
      </div>
    </div>
  </div>
</section>
<!-- Profil SIMAPEKA: End -->





  <!-- Our great team: Start -->
  <!-- <section id="landingTeam" class="section-py landing-team">
    <div class="container bg-icon-right position-relative">
      <img src="{{asset('assets/img/front-pages/icons/bg-right-icon-'.$configData['style'].'.png')}}" alt="section icon" class="position-absolute top-0 end-0" data-speed="1" data-app-light-img="front-pages/icons/bg-right-icon-light.png" data-app-dark-img="front-pages/icons/bg-right-icon-dark.png" />
      <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
        <img src="{{asset('assets/img/front-pages/icons/section-tilte-icon.png')}}" alt="section title icon" class="me-3" />
        <span class="text-uppercase">our great team</span>
      </h6>
      <h5 class="text-center mb-2"><span class="display-5 fs-4 fw-bold">Supported</span> by Real People</h5>
      <p class="text-center fw-medium mb-4 mb-md-12 pb-7">Who is behind these great-looking interfaces?</p>
      <div class="row gy-lg-5 gy-12 mt-2">
        <div class="col-lg-3 col-sm-6">
          <div class="card card-hover-border-primary mt-4 mt-lg-0 shadow-none">
            <div class="bg-label-primary position-relative team-image-box">
              <img src="{{asset('assets/img/front-pages/landing-page/team-member-1.png')}}" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
            </div>
            <div class="card-body text-center">
              <h5 class="card-title mb-1">Sophie Gilbert</h5>
              <p class="card-text mb-3">Project Manager</p>
              <div class="text-center team-media-icons">
                <a href="javascript:void(0);" class="text-heading" target="_blank">
                  <i class="tf-icons ri-facebook-circle-line ri-22px me-1"></i>
                </a>
                <a href="javascript:void(0);" class="text-heading" target="_blank">
                  <i class="tf-icons ri-twitter-line ri-22px me-1"></i>
                </a>
                <a href="javascript:void(0);" class="text-heading" target="_blank">
                  <i class="tf-icons ri-linkedin-box-line ri-22px"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card card-hover-border-danger mt-4 mt-lg-0 shadow-none">
            <div class="bg-label-danger position-relative team-image-box">
              <img src="{{asset('assets/img/front-pages/landing-page/team-member-2.png')}}" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
            </div>
            <div class="card-body text-center">
              <h5 class="card-title mb-1">Nannie Ford</h5>
              <p class="card-text mb-3">Development Lead</p>
              <div class="text-center team-media-icons">
                <a href="javascript:void(0);" class="text-heading" target="_blank">
                  <i class="tf-icons ri-facebook-circle-line ri-22px me-1"></i>
                </a>
                <a href="javascript:void(0);" class="text-heading" target="_blank">
                  <i class="tf-icons ri-twitter-line ri-22px me-1"></i>
                </a>
                <a href="javascript:void(0);" class="text-heading" target="_blank">
                  <i class="tf-icons ri-linkedin-box-line ri-22px"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card card-hover-border-success mt-4 mt-lg-0 shadow-none">
            <div class="bg-label-success position-relative team-image-box">
              <img src="{{asset('assets/img/front-pages/landing-page/team-member-3.png')}}" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
            </div>
            <div class="card-body text-center">
              <h5 class="card-title mb-1">Chris Watkins</h5>
              <p class="card-text mb-3">Marketing Manager</p>
              <div class="text-center team-media-icons">
                <a href="javascript:void(0);" class="text-heading" target="_blank">
                  <i class="tf-icons ri-facebook-circle-line ri-22px me-1"></i>
                </a>
                <a href="javascript:void(0);" class="text-heading" target="_blank">
                  <i class="tf-icons ri-twitter-line ri-22px me-1"></i>
                </a>
                <a href="javascript:void(0);" class="text-heading" target="_blank">
                  <i class="tf-icons ri-linkedin-box-line ri-22px"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card card-hover-border-info mt-4 mt-lg-0 shadow-none">
            <div class="bg-label-info position-relative team-image-box">
              <img src="{{asset('assets/img/front-pages/landing-page/team-member-4.png')}}" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
            </div>
            <div class="card-body text-center">
              <h5 class="card-title mb-1">Paul Miles</h5>
              <p class="card-text mb-3">UI Designer</p>
              <div class="text-center team-media-icons">
                <a href="javascript:void(0);" class="text-heading" target="_blank">
                  <i class="tf-icons ri-facebook-circle-line ri-22px me-1"></i>
                </a>
                <a href="javascript:void(0);" class="text-heading" target="_blank">
                  <i class="tf-icons ri-twitter-line ri-22px me-1"></i>
                </a>
                <a href="javascript:void(0);" class="text-heading" target="_blank">
                  <i class="tf-icons ri-linkedin-box-line ri-22px"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  <!-- Our great team: End -->

  <!-- Pricing plans: Start -->
  <!-- <section id="landingPricing" class="section-py bg-body landing-pricing">
    <div class="container bg-icon-left position-relative">
      <img src="{{asset('assets/img/front-pages/icons/bg-left-icon-'.$configData['style'].'.png')}}" alt="section icon" class="position-absolute top-0 start-0" data-speed="1" data-app-light-img="front-pages/icons/bg-left-icon-light.png" data-app-dark-img="front-pages/icons/bg-left-icon-dark.png" />
      <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
        <img src="{{asset('assets/img/front-pages/icons/section-tilte-icon.png')}}" alt="section title icon" class="me-3" />
        <span class="text-uppercase">pricing plans</span>
      </h6>
      <h5 class="text-center mb-2"><span class="display-5 fs-4 fw-bold">Tailored pricing plans</span> designed for you</h5>
      <p class="text-center fw-medium mb-10 mb-md-12 pb-lg-4">
        All plans include 40+ advanced tools and features to boost your product.<br />
        the best plan to fit your needs.
      </p>
      <div id="slider-pricing" class="mb-10 mb-md-12"></div>
      <div class="row gy-6 pt-md-4">
        
        <div class="col-xl-4 col-lg-6">
          <div class="card shadow-none border">
            <div class="card-header border-0 p-6 p-sm-8">
              <h4 class="mb-2 pb-1 text-center">Basic Plan</h4>
              <div class="d-flex align-items-center">
                <h5 class="d-flex mb-0"><sup class="h5 mt-4">$</sup><span class="display-3 fw-bold">20</span></h5>
                <div class="ms-2 ps-1">
                  <h6 class="mb-1">Per month</h6>
                  <p class="small mb-0 text-body">10% off for yearly subscription</p>
                </div>
              </div>
              <img src="{{asset('assets/img/front-pages/icons/smiling-icon.png')}}" alt="smiling icon" />
            </div>
            <div class="card-body p-6 p-sm-8 pt-0">
              <ul class="list-unstyled">
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Timeline
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Basic search
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Live chat widget
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Email marketing
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Custom Forms
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Traffic analytics
                  </h5>
                </li>
              </ul>
              <hr />
              <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="me-1">
                  <h6 class="mb-1">Basic Support</h6>
                  <p class="small mb-0">Only Email</p>
                </div>
                <span class="badge bg-label-primary rounded-pill">AVG. Time: 24h</span>
              </div>
              <div class="text-center mt-6 pt-2">
                <a href="{{url('/front-pages/payment')}}" class="btn btn-outline-primary w-100">Get Started</a>
              </div>
            </div>
          </div>
        </div> -->
        <!-- Basic Plan: End -->

        <!-- Favourite Plan: Start -->
        <!-- <div class="col-xl-4 col-lg-6">
          <div class="card border-primary border-2 shadow-none">
            <div class="card-header border-0 p-6 p-sm-8">
              <h4 class="mb-2 pb-1 text-center">Favourite Plan</h4>
              <div class="d-flex align-items-center">
                <h5 class="d-flex mb-0"><sup class="h5 mt-4">$</sup><span class="display-3 fw-bold">51</span></h5>
                <div class="ms-2 ps-1">
                  <h6 class="mb-1">Per month</h6>
                  <p class="small mb-0 text-body">10% off for yearly subscription</p>
                </div>
              </div>
              <img src="{{asset('assets/img/front-pages/icons/smiling-icon.png')}}" alt="smiling icon" />
            </div>
            <div class="card-body p-6 p-sm-8 pt-0">
              <ul class="list-unstyled">
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Everything in basic
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Timeline with database
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Advanced search
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Marketing automation
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Advanced chatbot
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Campaign management
                  </h5>
                </li>
              </ul>
              <hr />
              <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="me-1">
                  <h6 class="mb-1">Standard Support</h6>
                  <p class="small mb-0">Email & Chat</p>
                </div>
                <span class="badge bg-label-primary rounded-pill">AVG. Time: 6h</span>
              </div>
              <div class="text-center mt-6 pt-2">
                <a href="{{url('/front-pages/payment')}}" class="btn btn-primary w-100">Get Started</a>
              </div>
            </div>
          </div>
        </div>
        

        
        <div class="col-xl-4 col-lg-6">
          <div class="card shadow-none border">
            <div class="card-header border-0 p-6 p-sm-8">
              <h4 class="mb-2 pb-1 text-center">Standard Plan</h4>
              <div class="d-flex align-items-center">
                <h5 class="d-flex mb-0"><sup class="h5 mt-4">$</sup><span class="display-3 fw-bold">99</span></h5>
                <div class="ms-2 ps-1">
                  <h6 class="mb-1">Per month</h6>
                  <p class="small mb-0 text-body">10% off for yearly subscription</p>
                </div>
              </div>
              <img src="{{asset('assets/img/front-pages/icons/smiling-icon.png')}}" alt="smiling icon" />
            </div>
            <div class="card-body p-6 p-sm-8 pt-0">
              <ul class="list-unstyled">
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Everything in premium
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Timeline with database
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Fuzzy search
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    A/B testing sanbox
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Custom permissions
                  </h5>
                </li>
                <li>
                  <h5 class="mb-3">
                    <img src="{{asset('assets/img/front-pages/icons/list-arrow-icon.png')}}" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                    Social media automation
                  </h5>
                </li>
              </ul>
              <hr />
              <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="me-1">
                  <h6 class="mb-1">Exclusive Support</h6>
                  <p class="small mb-0">Email, Chat & Google Meet</p>
                </div>
                <span class="badge bg-label-primary rounded-pill">Live Support</span>
              </div>
              <div class="text-center mt-6 pt-2">
                <a href="{{url('/front-pages/payment')}}" class="btn btn-outline-primary w-100">Get Started</a>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </section> -->
  <!-- Pricing plans: End -->

  <!-- Fun facts: Start -->
  <section id="landingFunFacts" class="section-py landing-fun-facts py-12 my-4">
    <div class="container">
      <div class="row gx-0 gy-6 gx-sm-6">
        <div class="col-md-3 col-sm-6 text-center">
          <span class="badge rounded-pill bg-label-hover-primary fun-facts-icon mb-6 p-5"><i class="tf-icons ri-layout-line ri-42px"></i></span>
          <h2 class="fw-bold mb-0 fun-facts-text">137+</h2>
          <h6 class="mb-0 text-body">Completed Sites</h6>
        </div>
        <div class="col-md-3 col-sm-6 text-center">
          <span class="badge rounded-pill bg-label-hover-success fun-facts-icon mb-6 p-5"><i class="tf-icons ri-time-line ri-42px"></i></span>
          <h2 class="fw-bold mb-0 fun-facts-text">1,100+</h2>
          <h6 class="mb-0 text-body">Working Hours</h6>
        </div>
        <div class="col-md-3 col-sm-6 text-center">
          <span class="badge rounded-pill bg-label-hover-warning fun-facts-icon mb-6 p-5"><i class="tf-icons ri-user-smile-line ri-42px"></i></span>
          <h2 class="fw-bold mb-0 fun-facts-text">137+</h2>
          <h6 class="mb-0 text-body">Happy Customers</h6>
        </div>
        <div class="col-md-3 col-sm-6 text-center">
          <span class="badge rounded-pill bg-label-hover-info fun-facts-icon mb-6 p-5"><i class="tf-icons ri-award-line ri-42px"></i></span>
          <h2 class="fw-bold mb-0 fun-facts-text">23+</h2>
          <h6 class="mb-0 text-body">Awards Winning</h6>
        </div>
      </div>
    </div>
  </section>
  <!-- Fun facts: End -->

  <!-- FAQ: Start -->
  <section id="landingFAQ" class="section-py bg-body landing-faq">
    <div class="container bg-icon-right">
      <img src="{{asset('assets/img/front-pages/icons/bg-right-icon-'.$configData['style'].'.png')}}" alt="section icon" class="position-absolute top-0 end-0" data-speed="1" data-app-light-img="front-pages/icons/bg-right-icon-light.png" data-app-dark-img="front-pages/icons/bg-right-icon-dark.png" />
      <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
        <img src="{{asset('assets/img/front-pages/icons/section-tilte-icon.png')}}" alt="section title icon" class="me-3" />
        <span class="text-uppercase">faq</span>
      </h6>
      <h5 class="text-center mb-2">Frequently asked<span class="display-5 fs-4 fw-bold"> questions</span></h5>
      <p class="text-center fw-medium mb-4 mb-md-12 pb-4">
        Browse through these FAQs to find answers to commonly asked questions.
      </p>
      <div class="row gy-5">
        <div class="col-lg-5">
          <div class="text-center">
            <img src="{{asset('assets/img/front-pages/landing-page/sitting-girl-with-laptop.png')}}" alt="sitting girl with laptop" class="faq-image scaleX-n1-rtl" />
          </div>
        </div>
        <div class="col-lg-7">
          <div class="accordion" id="accordionFront">
            <div class="accordion-item">
              <h2 class="accordion-header" id="head-One">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                  Do you charge for each upgrade?
                </button>
              </h2>

              <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionFront" aria-labelledby="accordionOne">
                <div class="accordion-body">
                  Lemon drops chocolate cake gummies carrot cake chupa chups muffin topping. Sesame snaps icing
                  marzipan gummi bears macaroon dragée danish caramels powder. Bear claw dragée pastry topping
                  soufflé. Wafer gummi bears marshmallow pastry pie.
                </div>
              </div>
            </div>
            <div class="accordion-item previous-active">
              <h2 class="accordion-header" id="head-Two">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">
                  Do I need to purchase a license for each website?
                </button>
              </h2>
              <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="accordionTwo" data-bs-parent="#accordionFront">
                <div class="accordion-body">
                  Dessert ice cream donut oat cake jelly-o pie sugar plum cheesecake. Bear claw dragée oat cake
                  dragée ice cream halvah tootsie roll. Danish cake oat cake pie macaroon tart donut gummies. Jelly
                  beans candy canes carrot cake. Fruitcake chocolate chupa chups.
                </div>
              </div>
            </div>
            <div class="accordion-item active">
              <h2 class="accordion-header" id="head-Three">
                <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionThree" aria-expanded="true" aria-controls="accordionThree">
                  What is regular license?
                </button>
              </h2>
              <div id="accordionThree" class="accordion-collapse collapse show" aria-labelledby="accordionThree" data-bs-parent="#accordionFront">
                <div class="accordion-body">
                  Regular license can be used for end products that do not charge users for access or service(access
                  is free and there will be no monthly subscription fee). Single regular license can be used for
                  single end product and end product can be used by you or your client. If you want to sell end
                  product to multiple clients then you will need to purchase separate license for each client. The
                  same rule applies if you want to use the same end product on multiple domains(unique setup). For
                  more info on regular license you can check official description.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="head-Four">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFour" aria-expanded="false" aria-controls="accordionFour">
                  What is extended license?
                </button>
              </h2>
              <div id="accordionFour" class="accordion-collapse collapse" aria-labelledby="accordionFour" data-bs-parent="#accordionFront">
                <div class="accordion-body">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis et aliquid quaerat possimus maxime!
                  Mollitia reprehenderit neque repellat deleniti delectus architecto dolorum maxime, blanditiis
                  earum ea, incidunt quam possimus cumque.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="head-Five">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFive" aria-expanded="false" aria-controls="accordionFive">
                  Which license is applicable for SASS application?
                </button>
              </h2>
              <div id="accordionFive" class="accordion-collapse collapse" aria-labelledby="accordionFive" data-bs-parent="#accordionFront">
                <div class="accordion-body">
                  Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi molestias exercitationem ab cum
                  nemo facere voluptates veritatis quia, eveniet veniam at et repudiandae mollitia ipsam quasi
                  labore enim architecto non!
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- FAQ: End -->

  <!-- CTA: Start -->
  <section id="landingCTA" class="section-py landing-cta p-lg-0 pb-0 position-relative">
    <img src="{{asset('assets/img/front-pages/backgrounds/cta-bg.png')}}" class="position-absolute bottom-0 end-0 scaleX-n1-rtl h-100 w-100 z-n1" alt="cta image" />
    <div class="container">
      <div class="row align-items-center gy-5 gy-lg-0">
        <div class="col-lg-6 text-center text-lg-start">
          <h3 class="display-5 text-primary fw-bold mb-1 h3">Ready to Get Started?</h3>
          <p class="fw-medium mb-6 mb-md-8">Start your project with a 14-day free trial</p>
          <a href="{{url('/front-pages/payment')}}" class="btn btn-primary">Get Started<i class="ri-arrow-right-line ri-16px ms-2 scaleX-n1-rtl"></i></a>
        </div>
        <div class="col-lg-6 pt-lg-12">
          <img src="{{asset('assets/img/front-pages/landing-page/cta-dashboard.png')}}" alt="cta dashboard" class="img-fluid" />
        </div>
      </div>
    </div>
  </section>
  <!-- CTA: End -->

  <!-- Contact Us: Start -->
  <section id="landingContact" class="section-py bg-body landing-contact">
    <div class="container bg-icon-left position-relative">
      <img src="{{asset('assets/img/front-pages/icons/bg-left-icon-'.$configData['style'].'.png')}}" alt="section icon" class="position-absolute top-0 start-0" data-speed="1" data-app-light-img="front-pages/icons/bg-left-icon-light.png" data-app-dark-img="front-pages/icons/bg-left-icon-dark.png" />
      <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
        <img src="{{asset('assets/img/front-pages/icons/section-tilte-icon.png')}}" alt="section title icon" class="me-3" />
        <span class="text-uppercase">contact us</span>
      </h6>
      <h5 class="text-center mb-2"><span class="display-5 fs-4 fw-bold">Lets work</span> together</h5>
      <p class="text-center fw-medium mb-4 mb-md-12 pb-3">Any question or remark? just write us a message</p>
      <div class="row gy-6">
        <div class="col-lg-5">
          <div class="card h-100">
            <div class="bg-primary rounded-4 text-white card-body p-8">
              <p class="fw-medium mb-1_5 tagline">Let’s contact with us</p>
              <h4 class="text-white mb-5 title">Share your ideas or requirement with our experts.</h4>
              <img src="{{asset('assets/img/front-pages/landing-page/let’s-contact.png')}}
              " alt="let’s contact" class="w-100 mb-5" />
              <p class="mb-0 description">
                Looking for more customisation, more features, and more anything? Don’t worry, We’ve provide you with
                an entire team of experienced professionals.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="card">
            <div class="card-body">
              <h5 class="mb-6">Share your ideas</h5>
              <form>
                <div class="row g-5">
                  <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                      <input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" />
                      <label for="basic-default-fullname">Full name</label>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                      <input type="email" class="form-control" id="basic-default-email" placeholder="johndoe99@gmail.com" />
                      <label for="basic-default-email">Email address</label>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-floating form-floating-outline">
                      <textarea class="form-control h-px-250" placeholder="Message" aria-label="Message" id="basic-default-message"></textarea>
                      <label for="basic-default-message">Message</label>
                    </div>
                  </div>

                </div>
                <button type="submit" class="btn btn-primary mt-5">Send inquiry</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Contact Us: End -->
</div>
@endsection
