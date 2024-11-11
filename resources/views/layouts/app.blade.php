<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Zhafrani Mohamad">
    <meta name="description" content="Self assesment instrument for South Tangerang City">
    <meta name="keywords" content="zhafran, tangsel, simapeka, bkpsdm, self assesment">
    <title>
        @yield('title')
    </title>
    <!-- Favicon -->
    <link href="{{ url('argon') }}/assets/img/brand/favicon.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ url('argon') }}/assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
    <link href="{{ url('argon') }}/assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ url('argon') }}/assets/css/argon-dashboard.css?v=1.1.2" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    {{-- JQUERY --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    {{-- Tiny MCE --}}
    <script src="https://cdn.tiny.cloud/1/t5ou6k2rxqlhkbagokpewf54609o41eu2ubn3j13ooykndox/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
        selector: '#tinymce', // change this value according to your HTML
        height: 400,
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'table emoticons template paste help'
        ],
        menu: {
            file: { title: 'File', items: 'newdocument restoredraft | preview | print ' },
            edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
            view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen' },
            insert: { title: 'Insert', items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
            format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align lineheight | forecolor backcolor | removeformat' },
            tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | code wordcount' },
            table: { title: 'Table', items: 'inserttable | cell row column | tableprops deletetable' },
            help: { title: 'Help', items: 'help' }
        }
        });
    </script>
    @yield('styles')
</head>

<body class="" oncontextmenu="return false">
    <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
        <div class="container-fluid">
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
                aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Brand -->
            <a class="navbar-brand pt-0">
                <h1>AKPK</h1>
            </a>
            <!-- User -->
            {{-- <ul class="nav align-items-center d-md-none">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder" src="{{ Storage::url(Auth::user()->foto ) }}"
                                    alt="{{ Auth::user()->foto }}">
                            </span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            <i class="ni ni-user-run"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul> --}}
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Collapse header -->
                <div class="navbar-collapse-header d-md-none">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="{{ route('home') }}">
                                <h1>{{ config('app.name') }}</h1>
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                                aria-label="Toggle sidenav">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Navigation -->
                <ul class="navbar-nav">
                    @if (Request::segment(1) == 'home')
                        <li class="nav-item active">
                        <a class="nav-link active" href="{{ route('home') }}">
                    @else
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                    @endif
                            <i class="ni ni-shop text-primary"></i> Beranda
                        </a>
                    </li>

                    @if (auth()->user()->id_role == 1 || auth()->user()->id_role == 2)
                        <!-- @if (auth()->user()->id_role == 1)
                          @if (Request::segment(1) == 'formulir')
                              <li class="nav-item active">
                              <a class="nav-link active" href="{{ route('formulir.index') }}">
                          @else
                              <li class="nav-item">
                              <a class="nav-link" href="{{ route('formulir.index') }}">
                          @endif
                                  <i class="ni ni-ungroup text-warning"></i> Lihat Formulir
                              </a>
                          </li>
                        @endif -->
                        {{-- @if (Request::segment(1) == 'formulir')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('formulir.index') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('formulir.index') }}">
                        @endif
                                <i class="ni ni-chat-round text-success"></i> Formulir
                            </a>
                        </li> --}}
                    @endif

                    @if (auth()->user()->id_role == 1 || auth()->user()->id_role == 2)
                        {{-- @if (Request::segment(1) == 'eselon')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('eselon.index') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('eselon.index') }}">
                        @endif
                                <i class="ni ni-badge text-danger"></i> Level Kompetensi
                            </a>
                        </li> --}}
                        @if (Request::segment(1) == 'unduh')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('unduh.index') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('unduh.index') }}">
                        @endif
                                <i class="ni ni-bold-down text-purple"></i> Rekap AKPK
                            </a>
                        </li>

                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link nav-link-icon" href="#" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ni ni-settings-gear-65"></i>
                                <span class="nav-link-inner--text">Konfigurasi</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                                <a class="dropdown-item" href="{{ route('officers.index') }}">Petugas Hari Ini</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('skpds.index') }}">OPD</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('problems.index') }}">Kategori Masalah</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('users.index') }}">Akun Pengguna</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('faqs.index') }}">FAQ</a>
                            </div>
                        </li> --}}
                    @endif

                    @php
                    use App\Pegawai;
                    use App\Struktur_jabatan;
                
                    $pegawai = Pegawai::where('nip', Auth::user()->nip)->first();
                    if ($pegawai->jabatan != "Administrator") {
                        if($pegawai->jabatan_tambahan){
                        $kode_atasan = Struktur_jabatan::where('nama_jabatan', $pegawai->jabatan_tambahan)->first();
                        } else {
                        $kode_atasan = Struktur_jabatan::where('nama_jabatan', $pegawai->jabatan)->where('perangkat_daerah', $pegawai->unit_kerja)->first();
                        }
                
                        // Tambahkan logika untuk memeriksa apakah kode_jabatan bernilai null
                        if ($kode_atasan === null) {
                            $cek_bawahan = 0; // Jika null, set jumlah bawahan menjadi 0
                        } else {
                            $data_bawahan = Struktur_jabatan::where('kode_atasan', $kode_atasan->kode_jabatan)->get();
                            $cek_bawahan = $data_bawahan->count();
                        }
                    } else {
                        $cek_bawahan = 0;
                    }
                @endphp

                    @if ($pegawai->jabatan != "Administrator" && $pegawai->jabatan != "Admin PD")
                        {{-- Penilaian Mandiri --}}
                        {{-- @if (Request::segment(1) == 'penilaian_pribadi')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('penilaian_pribadi.index') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('penilaian_pribadi.index') }}">
                        @endif
                                <i class="ni ni-bullet-list-67 text-blue"></i> Penilaian Mandiri
                            </a>
                        </li> --}}

                        {{-- Diklat Mandiri (added after Penilaian Mandiri) --}}
                        @if (Request::segment(1) == 'diklat_mandiri')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('diklat_mandiri.index') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('diklat_mandiri.index') }}">
                        @endif
                                <i class="ni ni-books text-info"></i> Data Bangkom
                            </a>
                        </li>
                    @endif

                    @if ($cek_bawahan >= 1)
                        @if (Request::segment(1) == 'diklat_atasan')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('diklat_atasan.index') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('diklat_atasan.index') }}">
                        @endif
                                <i class="ni ni-chart-bar-32 text-warning"></i> Data Bangkom Bawahan
                            </a>
                        </li>
                    @endif

                    
                    <!-- @if (Request::segment(1) == 'diklat_atasan')
                        <li class="nav-item active">
                        <a class="nav-link active" href="{{ route('diklat_atasan.index') }}">
                    @else
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('diklat_atasan.index') }}">
                    @endif
                            <i class="ni ni-single-copy-04 text-warning"></i> Diklat Atasan
                        </a>
                    </li> -->

                    

                    {{-- @if (Request::segment(1) == 'ganti-password')
                        <li class="nav-item active">
                        <a class="nav-link active" href="{{ route('ganti-password') }}">
                    @else
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('ganti-password') }}">
                    @endif
                            <i class="ni ni-key-25 text-green"></i> Ganti Password
                        </a>
                    </li> --}}
                </ul>
                <hr class="my-3">
            <ul class="navbar-nav">
                @if (auth()->user()->id_role == 1 || auth()->user()->id_role == 2)
                    
                    <!-- Konfigurasi Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-icon dropdown-toggle" href="#" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ni ni-settings text-default"></i>
                            <span class="nav-link-inner--text">Konfigurasi</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                        @if (auth()->user()->id_role == 1)
                            <a class="dropdown-item" href="{{ route('users.index') }}">Pengguna</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('daftar_diklat.index') }}">Data Bangkom</a>
                            @if (auth()->user()->nip == '197811292010012020')
                                <a class="dropdown-item" href="{{ route('kompetensi_manajerial.index') }}">Kompetensi Manajerial</a>
                            @endif
                        </div>
                    </li>
                @endif

                @if (Request::segment(1) == 'profil')
                    <li class="nav-item active">
                        <a class="nav-link active" href="{{ route('profil') }}">
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profil') }}">
                @endif
                            <i class="ni ni-single-02 text-yellow"></i> Profil
                        </a>
                    </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run text-info"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block"
                    href="{{ route('home') }}">Beranda</a>
                <!-- User -->
                {{-- <ul class="navbar-nav align-items-center d-none d-md-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">
                                    <img alt="Image placeholder" src="{{ Storage::url(Auth::user()->foto ) }}"
                                        alt="{{ Auth::user()->foto }}">
                                </span>
                                <div class="media-body ml-2 d-none d-lg-block">
                                    <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->nama }}</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item">
                                <i class="ni ni-user-run"></i>
                                <span>Logout</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul> --}}
            </div>
        </nav>
        <!-- End Navbar -->

        <!-- Header -->
        <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
            <div class="container-fluid">
                <div class="header-body">
                    <!-- Card stats -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                    @yield('header')
                </div>
            </div>
        </div>
        <div class="container-fluid mt--7">
            @yield('content')
            <!-- Footer -->
            <footer class="footer">
                <div class="row align-items-center justify-content-xl-between">
                    <div class="col-xl-6">
                        <div class="copyright text-center text-xl-left text-muted">
                            © {{ date('Y')}} <a href="https://bkpsdm.tangerangselatankota.go.id/" class="font-weight-bold ml-1"
                                target="_blank">BKPSDM Kota Tangerang Selatan</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!--   Core   -->
    <script src="{{ url('argon') }}/assets/js/plugins/jquery/dist/jquery.min.js"></script>
    <script src="{{ url('argon') }}/assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!--   Optional JS   -->
    @stack('scripts')

    {{-- <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
    <script>
        window.TrackJS &&
            TrackJS.install({
                token: "ee6fab19c5a04ac1a32a645abde4613a",
                application: "argon-dashboard-free"
            });
    </script> --}}
</body>

</html>
