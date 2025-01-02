<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Exports\ResultsExportByGapOpd;
use App\Formulir;
use App\Formulir_indikator;
use App\Formulir_sub_indikator;
use App\Models\Pegawai;
use App\Penilaian_pribadi;
use App\Penilaian_atasan;
use App\Models\Struktur_jabatan;
use App\Models\User;
use App\Exports\KompetensiExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Support\Facades\App;
use App\Exports\ResultsExport;
use App\Exports\LevelExport;
use App\Exports\LevelExportOpd;
use App\Exports\ResultsExport2024;
use App\Exports\ResultsExportuptd;
use App\Exports\ResultsExportuptdopd;
use App\Exports\ResultsExportByGap;
use App\Exports\ResultsExportOpd;
use App\Exports\JabatansExport;
use App\Models\Perangkat_daerah;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;

class RekapAkpk extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user           = User::all();
        $pegawai        = "";
        $pegawai_opd    = "";
        $hasil          = "";
        
        return view('content.apps.rekap-akpk', compact('user', 'pegawai', 'pegawai_opd', 'hasil'));
    }

    public function search(Request $request)
{
    // Fetch the authenticated user's data
    $pegawai = Pegawai::where('nip', Auth::user()->nip)->first(); 
    $pegawai_opd = "";
    $hasil = "";
    $kategori = "";

    // Check if the request contains the 'kategori' parameter
    if ($request->kategori) {
        if ($request->kategori == "Perangkat Daerah") {
            // Existing logic for Perangkat Daerah
            if (Auth::user()->id_role == 2) {
                // Fetch perangkat daerah based on user's unit_kerja
                $hasil = Perangkat_daerah::where('nama_perangkat_daerah', $pegawai->unit_kerja)->get();
            } else {
                // If not Role 2, fetch all perangkat daerah
                $hasil = Perangkat_daerah::where('nama_perangkat_daerah', '!=', 'Sekolah')
                    ->where('nama_perangkat_daerah', '!=', 'Puskesmas')
                    ->where('nama_perangkat_daerah', '!=', 'Rumah Sakit')
                    ->get();
            }
            $kategori = "OPD";

        } elseif ($request->kategori == "UPTD") { // New UPTD category
            // Apply role-based logic for UPTD
            if (Auth::user()->id_role == 2) {
                // If Admin PD (Role 2), restrict UPTD results based on the logged-in user's uptd
                $hasil = Pegawai::select('uptd')
                    ->where('nip', Auth::user()->nip)
                    ->whereNotNull('uptd') // Only include rows where UPTD is not null
                    ->where(function ($query) {
                        $query->where('uptd', 'not like', 'Bidang%')
                              ->where('uptd', '!=', 'NULL') // Exclude "NULL" string values
                              ->where('uptd', 'not like', 'sekretariat%')
                              ->where('uptd', 'not like', 'asisten%')
                              ->where('uptd', 'not like', 'bagian umum%')
                              ->where('uptd', 'not like', 'bagian%')
                              ->where('uptd', 'not like', 'inspektur%')
                              ->where('uptd', 'not like', 'kelompok%')
                              ->where('uptd', 'not like', 'seksi%')
                              ->where('uptd', 'not like', 'dinas%')
                              ->where('uptd', 'not like', 'staf ahli%');
                    })
                    ->groupBy('uptd')
                    ->get();
            } else {
                // If Super Admin (Role 1), show all UPTDs, excluding certain ones
                $hasil = Pegawai::select('uptd')
                    ->whereNotNull('uptd')
                    ->where(function ($query) {
                        $query->where('uptd', 'not like', 'Bidang%')
                            ->where('uptd', '!=', 'NULL') // Exclude "NULL" string values
                              ->where('uptd', 'not like', 'sekretariat%')
                              ->where('uptd', 'not like', 'asisten%')
                              ->where('uptd', 'not like', 'bagian umum%')
                              ->where('uptd', 'not like', 'bagian%')
                              ->where('uptd', 'not like', 'inspektur%')
                              ->where('uptd', 'not like', 'kelompok%')
                              ->where('uptd', 'not like', 'seksi%')
                              ->where('uptd', 'not like', 'dinas%')
                              ->where('uptd', 'not like', 'staf ahli%');
                    })
                    ->groupBy('uptd')
                    ->get();
            }
            $kategori = "UPTD";        

        } elseif ($request->kategori == "Level Kompetensi") {
            // Existing logic for Level Kompetensi
            $hasil = Struktur_jabatan::select('level_kompetensi')
                ->whereNotNull('level_kompetensi')
                ->groupBy('level_kompetensi')
                ->get();
            $kategori = "Level Kompetensi";

        } elseif ($request->kategori == "Level Kompetensi Gap") {
            // Existing logic for Level Kompetensi Gap
            $hasil = Struktur_jabatan::select('level_kompetensi')
                ->whereNotNull('level_kompetensi')
                ->groupBy('level_kompetensi')
                ->get();
            $kategori = "Level Kompetensi Gap";
        } else {
            $hasil = "jabatan";
            $kategori = "";
        }
    }

    return view('content.apps.rekap-akpk', compact('pegawai', 'pegawai_opd', 'hasil', 'kategori'));
}






    public function detail($id)
    {   
        $hasil              = Pegawai::where('unit_kerja', $id)->get();
        $struktur_jabatan   = Struktur_jabatan::all();
        $perangkat_daerah   = $id;

        return view('unduh.detail_individu', compact('struktur_jabatan', 'hasil', 'perangkat_daerah'));
    }
    
    public function unduh_individu($id)
    {   
        $pegawai            = Pegawai::where('id', $id)->first();
        $cek_eselon         = Struktur_jabatan::where('nama_jabatan', $pegawai->jabatan)->first();
        $penilaian_bawahan  = Penilaian_pribadi::where('nip', $pegawai->nip)->get();
        $status_penilaian   = Penilaian_atasan::where('nip_bawahan', $pegawai->nip)->get();
        $nilai              = Penilaian_pribadi::where('nip', $pegawai->nip)->get();
        $nilai_atasan       = Penilaian_atasan::where('nip_bawahan', $pegawai->nip)->get();
        
        if($cek_eselon->eselon == "II.a" || $cek_eselon->eselon == "II.b"){ $level_kompetensi = 4;}
        else if($cek_eselon->eselon == "III.a" || $cek_eselon->eselon == "III.b"){ $level_kompetensi = 3;}
        else if($cek_eselon->eselon == "IV.a" || $cek_eselon->eselon == "IV.b"){ $level_kompetensi = 2;}
        else { $level_kompetensi = 1;}

        $manajerial = Formulir::where('level_kompetensi', $level_kompetensi)
                        ->where('kategori_kompetensi', 'Kompetensi Manajerial')
                        // ->where('jabatan', 'like', $pegawai->jabatan.'%')
                        // ->orWhere('jabatan_ketik', 'like', $pegawai->jabatan,'%')
                        ->get();
        $soskul     = Formulir::where('level_kompetensi', $level_kompetensi)
                        ->where('kategori_kompetensi', 'Kompetensi Sosial Kultural')
                        // ->where('jabatan', $pegawai->jabatan)
                        // ->orWhere('jabatan_ketik', $pegawai->jabatan)
                        ->get();
        $teknis     = Formulir::where('level_kompetensi', $level_kompetensi)
                        ->where('kategori_kompetensi', 'Kompetensi Teknis')
                        ->where('jabatan', $pegawai->jabatan)
                        ->orWhere('jabatan_ketik', $pegawai->jabatan)
                        ->get();

        $indikator      = Formulir_indikator::all();
        $sub_indikator  = Formulir_sub_indikator::all();

        return view('unduh.individual', compact('cek_eselon', 'penilaian_bawahan','pegawai', 'status_penilaian', 'level_kompetensi', 'manajerial', 'soskul', 'teknis', 'indikator', 'sub_indikator', 'nilai', 'nilai_atasan'));
    }

  

    public function pdf_individu($id)
    {
        $pegawai = Pegawai::where('id', $id)->first();
        $hitung_pegawai = Pegawai::where('id', $id)->count();
        $cek_eselon = Struktur_jabatan::where('nama_jabatan', $pegawai->jabatan)->first();
        $penilaian_bawahan = Penilaian_pribadi::where('nip', $pegawai->nip)->get();
        $status_penilaian = Penilaian_atasan::where('nip_bawahan', $pegawai->nip)->get();
        $nilai = Penilaian_pribadi::where('nip', $pegawai->nip)->get();
        $nilai_atasan = Penilaian_atasan::where('nip_bawahan', $pegawai->nip)->get();
    
        if ($cek_eselon->eselon == "II.a" || $cek_eselon->eselon == "II.b") {
            $level_kompetensi = 4;
        } elseif ($cek_eselon->eselon == "III.a" || $cek_eselon->eselon == "III.b") {
            $level_kompetensi = 3;
        } elseif ($cek_eselon->eselon == "IV.a" || $cek_eselon->eselon == "IV.b") {
            $level_kompetensi = 2;
        } else {
            $level_kompetensi = 1;
        }
    
        $manajerial = Formulir::where('level_kompetensi', $level_kompetensi)
                        ->where('kategori_kompetensi', 'Kompetensi Manajerial')
                        ->get();
        $soskul = Formulir::where('level_kompetensi', $level_kompetensi)
                        ->where('kategori_kompetensi', 'Kompetensi Sosial Kultural')
                        ->get();
        $teknis = Formulir::where('level_kompetensi', $level_kompetensi)
                        ->where('kategori_kompetensi', 'Kompetensi Teknis')
                        ->where('jabatan', $pegawai->jabatan)
                        ->orWhere('jabatan_ketik', $pegawai->jabatan)
                        ->get();
    
        $indikator = Formulir_indikator::all();
        $sub_indikator = Formulir_sub_indikator::all();
    
        $html = view('unduh.pdf_individu', compact('pegawai', 'hitung_pegawai', 'manajerial', 'soskul', 'teknis', 'level_kompetensi', 'indikator', 'sub_indikator', 'nilai', 'nilai_atasan'))->render();
    
        $pdf = Pdf::loadHTML($html)
                  ->setPaper('Letter')
                  ->setOrientation('landscape')
                  ->setOption('margin-left', '2cm')
                  ->setOption('margin-right', '2cm')
                  ->setOption('margin-top', '2cm')
                  ->setOption('margin-bottom', '2cm')
                  ->setOption('header-spacing', 5)
                  ->setOption('footer-spacing', 5);
                  
        return $pdf->inline('report.pdf');
    }
    

    
    public function pdf_opd($id)
    {
        $pegawai            = Pegawai::where('unit_kerja', $id)->get();
        $hitung_pegawai     = Pegawai::where('unit_kerja', $id)->count();

        $indikator      = Formulir_indikator::all();
        $sub_indikator  = Formulir_sub_indikator::all();
        $pdf = Pdf::loadView('unduh.pdf_individu', compact('pegawai', 'hitung_pegawai', 'indikator', 'sub_indikator'))->setPaper('A1', 'landscape');
        return $pdf->stream();
        // return $pdf->download('Individu.pdf');
    }

    public function export(Request $request)
{
    if($request->jabatan){
        return Excel::download(new JabatansExport($request->jabatan), 'Rekap_AKPK_'.$request->jabatan.'.xlsx');
    } else {
        return Excel::download(new ResultsExport($request->unit_kerja), 'Rekap_AKPK_'.$request->unit_kerja.'.xlsx');
    }
}
    public function export2024(Request $request)
{ 
        return Excel::download(new ResultsExport2024($request->unit_kerja), 'Rekap_AKPK_'.$request->unit_kerja.'.xlsx');
}
    public function exportopd(Request $request)
{ 
        return Excel::download(new ResultsExportOpd($request->unit_kerja), 'Rekap_AKPK_'.$request->unit_kerja.'.xlsx');
}

    public function uptd(Request $request)
{ 
        return Excel::download(new ResultsExportuptd($request->uptd), 'Rekap_AKPK_'.$request->uptd.'.xlsx');
}
    public function uptdopd(Request $request)
{ 
        return Excel::download(new ResultsExportuptdopd($request->uptd), 'Rekap_AKPK_'.$request->uptd.'.xlsx');
}
    public function exportlevel(Request $request)
{ 
       return Excel::download(new LevelExport($request->level_kompetensi), 'Rekap_AKPK_Level_Kompetensi_'.$request->level_kompetensi.'.xlsx');
}
    public function exportlevelopd(Request $request)
{ 
       return Excel::download(new LevelExportOpd($request->level_kompetensi), 'Rekap_AKPK_Level_Kompetensi_'.$request->level_kompetensi.'.xlsx');
}

    public function exportbygap(Request $request)
{ 
        return Excel::download(new ResultsExportByGap($request->level_kompetensi), 'Rekap_AKPK_Gap_'.$request->level_kompetensi.'.xlsx');
}
    public function exportbygapopd(Request $request)
{ 
        return Excel::download(new ResultsExportByGapOpd($request->level_kompetensi), 'Rekap_AKPK_Gap_'.$request->level_kompetensi.'.xlsx');
}

}