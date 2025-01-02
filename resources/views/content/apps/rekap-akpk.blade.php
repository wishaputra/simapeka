@extends('layouts/layoutMaster')

@section('title', 'Rekap AKPK - Pages')

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

<!-- @section('page-script')
@vite('resources/assets/js/bangkom-mandiri.js')
@endsection -->

@php
    use Illuminate\Support\Facades\Auth;
@endphp

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card shadow h-100">
                    <div class="card-header">
                    <h5 class="h2 m-0 pt-1 font-weight-bold text-center">Unduh Hasil Penilaian</h5>
</div>
<div class="card-body">
    @if (auth()->user()->id_role == 1 || auth()->user()->id_role == 2)
        <div class="form-group row">
            <div class="col-sm-10">
                <form action="{{ route('rekap_akpk.search') }}" method="get" class="form-inline">
                    <select name="kategori" id="kategori" class="form-control" onchange="setUnitKerja()">
                        <option value="">Pilih Kategori</option>
                        <option value="Perangkat Daerah">Rekap AKPK Berdasarkan Perangkat Daerah</option>
                        <option value="UPTD">Rekap AKPK Berdasarkan UPTD</option> <!-- New option for UPTD -->
                        <option value="Level Kompetensi">Rekap AKPK Berdasarkan Level Kompetensi</option>
                        <option value="Level Kompetensi Gap">Rekap AKPK Berdasarkan Level Kompetensi Yang Memiliki Gap</option>
                        <option value="ASN yang belum memilih">Rekap AKPK ASN yang belum memilih data bangkom</option>
                        <option value="Atasan yang belum acc bawahan">Rekap AKPK Atasan langsung yang belum acc bawahan</option>
                        <option value="Atasan langsung sebagai PLT">Rekap AKPK Atasan langsung ASN sebagai PLT yang belum acc bawahan</option>
                    </select>
                    <button type="submit" class="btn btn-primary ml-2">Cari</button>
                </form>
            </div>
        </div>
        <div class="float-right">
            {{-- Pagination or other elements can go here --}}
        </div>
        <div class="mt-4 table-responsive">
            @if ($hasil)
            <table id="dataTable" class="table table-stripped table-hover">
                <thead>
                    <tr>
                        @if($kategori == "OPD")
                            <th style="text-align: center">Nama Perangkat Daerah</th>
                        @elseif($kategori == "UPTD") <!-- New UPTD category -->
                            <th style="text-align: center">Nama UPTD</th>
                        @elseif($kategori == "Level Kompetensi")
                            <th style="text-align: center">Level Kompetensi</th>
                        @elseif($kategori == "Level Kompetensi Gap")
                            <th style="text-align: center">Level Kompetensi</th>
                        @endif
                        <th style="text-align: center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @if ($kategori == "OPD")
                        @foreach ($hasil as $item)
                            <tr>
                                <td>{{ $item->nama_perangkat_daerah ?? $item->nama }}</td>
                                <td>
                                    @if (auth()->user()->id_role == 1)
                                        <form action="{{ route('rekap_akpk.search') }}" method="GET">
                                            @csrf
                                            <input type="hidden" name="unit_kerja" value="{{ $item->nama_perangkat_daerah }}">
                                            <button type="submit" class="btn btn-sm btn-default" title="Unduh">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </form>
                                    @elseif (auth()->user()->id_role == 2)
                                        <form action="{{ route('unduh.opd') }}" method="GET">
                                            @csrf
                                            <input type="hidden" name="unit_kerja" value="{{ $item->nama_perangkat_daerah }}">
                                            <button type="submit" class="btn btn-sm btn-default" title="Unduh">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @elseif ($kategori == "UPTD")
                        @foreach ($hasil as $item)
                            <tr>
                                <td>{{ $item->uptd }}</td>
                                <td>
                                    @if (auth()->user()->id_role == 1) 
                                        <form action="{{ route('rekap_akpk.uptd') }}" method="GET">
                                            @csrf
                                            <input type="hidden" name="uptd" value="{{ $item->uptd }}">
                                            <button type="submit" class="btn btn-sm btn-default" title="Unduh for Role 1">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </form>
                                    @elseif (auth()->user()->id_role == 2)
                                        <form action="{{ route('rekap_akpk.uptdopd') }}" method="GET">
                                            @csrf
                                            <input type="hidden" name="uptd" value="{{ $item->uptd }}">
                                            <button type="submit" class="btn btn-sm btn-default" title="Unduh for Role 2">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                                            @elseif ($kategori == "Level Kompetensi")
                                                @foreach ($hasil as $item)
                                                    <tr>
                                                        <td>{{ 'Level kompetensi ' . $item->level_kompetensi }}</td>
                                                        <td>
                                                            @if (auth()->user()->id_role == 1)
                                                                <form action="{{ route('rekap_akpk.level') }}" method="GET">
                                                                    @csrf
                                                                    <input type="hidden" name="level_kompetensi" value="{{ $item->level_kompetensi }}">
                                                                    <button type="submit" class="btn btn-sm btn-default" title="Unduh">
                                                                        <i class="fas fa-download"></i>
                                                                    </button>
                                                                </form>
                                                                @elseif (auth()->user()->id_role == 2)
                                                                <form action="{{ route('rekap_akpk.levelopd') }}" method="GET">
                                                                    @csrf
                                                                    <!-- Hidden input for level_kompetensi -->
                                                                    <input type="hidden" name="level_kompetensi" value="{{ $item->level_kompetensi }}">
                                                                    
                                                                    <!-- Hidden input for unit_kerja, assuming it's available as $item->unit_kerja -->
                                                                    <input type="hidden" name="unit_kerja" value="{{ $item->unit_kerja }}">
                                                                    
                                                                    <button type="submit" class="btn btn-sm btn-default" title="Unduh">
                                                                        <i class="fas fa-download"></i>
                                                                    </button>
                                                                </form>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @elseif ($kategori == "Level Kompetensi Gap")
                                                    @foreach ($hasil as $item)
                                                        <tr>
                                                            <td>{{ 'Level kompetensi ' . $item->level_kompetensi }}</td>
                                                            
                                                            <td>
                                                                @if (auth()->user()->id_role == 1)
                                                                    <form action="{{ route('rekap_akpk.bygap') }}" method="GET">
                                                                        @csrf
                                                                        <input type="hidden" name="level_kompetensi" value="{{ $item->level_kompetensi }}">
                                                                        <button type="submit" class="btn btn-sm btn-default" title="Unduh">
                                                                            <i class="fas fa-download"></i>
                                                                        </button>
                                                                    </form>
                                                                @elseif (auth()->user()->id_role == 2)
                                                                    <form action="{{ route('rekap_akpk.bygapopd') }}" method="GET">
                                                                        @csrf
                                                                        <input type="hidden" name="level_kompetensi" value="{{ $item->level_kompetensi }}">
                                                                        <button type="submit" class="btn btn-sm btn-default" title="Unduh">
                                                                            <i class="fas fa-download"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                            @endif
                                        </tbody>
                                    </table>
                                @else
                                    <table class="table table-stripped table-hover">
                                        <tr>
                                            <td style="text-align: center">Pilih Kategori Terlebih Dahulu</td>
                                        </tr>
                                    </table>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

 

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        function setUnitKerja() {
            document.getElementById('unit_kerja_set').value = document.getElementById('kategori').value;
        }
    </script>
@endpush