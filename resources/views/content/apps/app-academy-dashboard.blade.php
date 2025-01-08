@extends('layouts/layoutMaster')

@section('title', 'Academy - Dashboard - App')

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
@vite('resources/assets/js/app-academy-dashboard.js')
@endsection
@php
    use Illuminate\Support\Facades\Auth;
@endphp

@section('content')

<script>
var courseData = @json($courseData);
</script>
<!-- Hour chart  -->
<div class="card bg-transparent shadow-none border-0 mb-6">
  <div class="card-body row g-6 p-0 pb-5">
    <div   class="col-12 col-md-8 card-separator">
        <h5 class="mb-2">Halo,<span class="h4 fw-semibold">
        {{ Auth::user()->pegawai->nama ?? Auth::user()->name }} 👋🏻
      </span></h5>
      <div class="col-12 col-lg-5">
        <p>Kemajuan Anda minggu ini Luar Biasa. Ayo teruskan dan penuhi jumlah minimal JP!</p>
      </div>
      <div class="d-flex justify-content-between flex-wrap gap-4 me-12">
        <div class="d-flex align-items-center gap-4">
          <div class="avatar avatar-lg">
            <div class="avatar-initial bg-label-info rounded-3">
              <div>
                <img src="{{asset('assets/svg/icons/lightbulb.svg')}}" alt="Lightbulb" class="img-fluid">
              </div>
            </div>
          </div>
          <div class="content-right">
            <p class="mb-1 fw-medium">Hasil Tes</p>
            <span class="text-info mb-0 h5">82%</span>
          </div>
        </div>
        <div class="d-flex align-items-center gap-4">
          <div class="avatar avatar-lg">
            <div class="avatar-initial bg-label-warning rounded-3">
              <div>
                <img src="{{asset('assets/svg/icons/check.svg')}}" alt="Check" class="img-fluid">
              </div>
            </div>
          </div>
          <div class="content-right">
            <p class="mb-1 fw-medium">Pelatihan yang Diselesaikan</p>
            <span class="text-warning mb-0 h5">{{ $completedCoursesCount }}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4 ps-md-4 ps-lg-6">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <div>
            <h5 class="mb-1">Total Waktu</h5>
            <p class="mb-9">Laporan Mingguan</p>
          </div>
          <div class="time-spending-chart">
            <h5 class="mb-2">231<span class="text-body"> jam</span> 14<span class="text-body"> menit</span></h5>
            <span class="badge bg-label-success rounded-pill">+18.4%</span>
          </div>
        </div>
        <div id="leadsReportChart"></div>
      </div>
    </div>
  </div>
</div>
<!-- Hour chart End  -->

<!-- Topic and Instructors -->
<div class="row mb-6 g-6">

  <!-- pelatihan yang di ikuti -->
<div class="col-12 col-xxl-8">
  <div class="card h-100">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="card-title m-0 me-2">Pelatihan yang diikuti</h5>
    </div>
    <div class="card-body row g-3">
      <div class="col-md-6">
        <div id="horizontalBarChart"></div>
      </div>
      <div class="col-md-6 d-flex justify-content-around align-items-center">
        <div>
          @foreach($courseData->take(3) as $index => $course)
            <div class="d-flex align-items-baseline @if(!$loop->first) my-10 @endif">
              <span class="text-{{ ['primary', 'success', 'danger'][$index] }} me-2"><i class='ri-circle-fill ri-12px'></i></span>
              <div>
                <p class="mb-0">{{ $course['title'] }}</p>
                <h5 class="mb-0">{{ $course['progress'] }}%</h5>
              </div>
            </div>
          @endforeach
        </div>

        <div>
          @foreach($courseData->slice(3, 3) as $index => $course)
            <div class="d-flex align-items-baseline @if(!$loop->first) my-10 @endif">
              <span class="text-{{ ['info', 'secondary', 'warning'][$index] }} me-2"><i class='ri-circle-fill ri-12px'></i></span>
              <div>
                <p class="mb-0">{{ $course['title'] }}</p>
                <h5 class="mb-0">{{ $course['progress'] }}%</h5>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ pelatihan yand diikuti -->


  <!-- Top Courses -->
    <div class="col-12 col-xxl-4 col-md-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Pelatihan Populer</h5>
        </div>
        <div class="card-body">
          <ul class="list-unstyled mb-0">
            @foreach($popularCourses as $index => $course)
              <li class="d-flex {{ $loop->last ? '' : 'mb-7' }}">
                <div class="avatar flex-shrink-0 me-4">
                  <span class="avatar-initial rounded-3 bg-label-{{ ['primary', 'info', 'success', 'warning', 'danger'][$index] }}">
                    <i class="{{ $course['icon'] }} ri-24px"></i>
                  </span>
                </div>
                <div class="d-sm-flex w-100 align-items-center">
                  <div class="w-100 mb-2 mb-sm-0 me-sm-4">
                    <h6 class="mb-0">{{ $course['title'] }}</h6>
                  </div>
                  <div class="badge bg-label-secondary rounded-pill">{{ $course['enrollment_count'] }} Enrollments</div>
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    <!--/ Top Courses -->

  <!-- Upcoming Webinar -->
  <!-- <div class="col-12 col-xxl-4 col-md-6">
    <div class="card h-100">
      <div class="card-body">
        <div class="bg-label-primary text-center mb-6 pt-2 rounded-3">
          <img class="img-fluid w-px-150" src="{{asset('assets/img/illustrations/faq-illustration.png')}}"
            alt="Boy card image" />
        </div>
        <h5 class="mb-1">Webinar yang Akan Datang</h5>
        <p class="mb-6">Sosialisasi penggunaan aplikasi SIMAPEKA.</p>
        <div class="row mb-6 g-4">
          <div class="col-6">
            <div class="d-flex">
              <div class="avatar flex-shrink-0 me-4">
                <span class="avatar-initial rounded-3 bg-label-primary"><i class="ri-calendar-line ri-24px"></i></span>
              </div>
              <div>
                <h6 class="mb-0 text-nowrap fw-normal">17 Nov 23</h6>
                <small>Tanggal</small>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="d-flex">
              <div class="avatar flex-shrink-0 me-4">
                <span class="avatar-initial rounded-3 bg-label-primary"><i class="ri-time-line ri-24px"></i></span>
              </div>
              <div>
                <h6 class="mb-0 text-nowrap fw-normal">32 menit</h6>
                <small>Durasi</small>
              </div>
            </div>
          </div>
        </div>
        <a href="javascript:void(0);" class="btn btn-primary w-100">Ikuti Webinar</a>
      </div>
    </div>
  </div> -->
  <!--/ Upcoming Webinar -->

  <!-- progress pelatihan -->
  <!-- <div class="col-12 col-xxl-4 col-md-6">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">Progress Pelatihan</h5>
        <div class="dropdown">
          <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button" id="assignProgress"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ri-more-2-line ri-20px"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="assignProgress">
            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
            <a class="dropdown-item" href="javascript:void(0);">Download</a>
            <a class="dropdown-item" href="javascript:void(0);">View All</a>
          </div>
        </div>
      </div>
      <div class="card-body pt-5">
        <ul class="p-0 m-0">
          <li class="d-flex mb-8">
            <div class="chart-progress me-4" data-color="primary" data-series="72" data-progress_variant="true"></div>
            <div class="row w-100 align-items-center">
              <div class="col-9">
                <div class="me-2">
                  <h6 class="mb-2">Dasar-dasar Pemrograman</h6>
                  <p class="mb-0 small">120 Tasks</p>
                </div>
              </div>
              <div class="col-3 text-end">
                <button type="button" class="btn btn-sm btn-icon bg-label-secondary">
                  <i class="ri-arrow-right-s-line ri-20px scaleX-n1-rtl"></i>
                </button>
              </div>
            </div>
          </li>
          <li class="d-flex mb-8">
            <div class="chart-progress me-4" data-color="success" data-series="48" data-progress_variant="true"></div>
            <div class="row w-100 align-items-center">
              <div class="col-9">
                <div class="me-2">
                  <h6 class="mb-2">Pengelolaan Barang dan Jasa</h6>
                  <p class="mb-0 small">32 Tasks</p>
                </div>
              </div>
              <div class="col-3 text-end">
                <button type="button" class="btn btn-sm btn-icon bg-label-secondary">
                  <i class="ri-arrow-right-s-line ri-20px scaleX-n1-rtl"></i>
                </button>
              </div>
            </div>
          </li>
          <li class="d-flex mb-8">
            <div class="chart-progress me-4" data-color="danger" data-series="15" data-progress_variant="true"></div>
            <div class="row w-100 align-items-center">
              <div class="col-9">
                <div class="me-2">
                  <h6 class="mb-2">Manajemen Proyek</h6>
                  <p class="mb-0 small">182 Tasks</p>
                </div>
              </div>
              <div class="col-3 text-end">
                <button type="button" class="btn btn-sm btn-icon bg-label-secondary">
                  <i class="ri-arrow-right-s-line ri-20px scaleX-n1-rtl"></i>
                </button>
              </div>
            </div>
          </li>
          <li class="d-flex">
            <div class="chart-progress me-4" data-color="info" data-series="24" data-progress_variant="true"></div>
            <div class="row w-100 align-items-center">
              <div class="col-9">
                <div class="me-2">
                  <h6 class="mb-2">Manajemen Strategis</h6>
                  <p class="mb-0 small">56 Tasks</p>
                </div>
              </div>
              <div class="col-3 text-end">
                <button type="button" class="btn btn-sm btn-icon bg-label-secondary">
                  <i class="ri-arrow-right-s-line ri-20px scaleX-n1-rtl"></i>
                </button>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div> -->
  <!--/ progress pelatihan end -->

</div>
<!--  Topic and Instructors  End-->

<!-- Course datatable -->
<!-- <div class="card">
  <div class="table-responsive mb-4">
    <table class="table datatables-academy-course">
      <thead>
        <tr>
          <th></th>
          <th></th>
          <th>Course Name</th>
          <th>Time</th>
          <th class="w-25">Progress</th>
          <th class="w-25">Status</th>
        </tr>
      </thead>
    </table>
  </div>
</div> -->
<!-- Course datatable End -->
@endsection
