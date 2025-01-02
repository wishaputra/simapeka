<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller; // Import the base Controller
use App\Models\Pegawai;
use App\Models\Struktur_jabatan;
use App\Models\User;
use App\models\Komtek;
use App\Models\DaftarDiklat;
use Illuminate\Support\Str;
use App\Exports\PresentExport;
use App\Exports\UsersPresentExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables; 

class BangkomBawahan extends Controller
{
   
    public function index()
    {   
        $daftar_pegawai    = Pegawai::all();
        $pegawai    = Pegawai::where('nip', Auth::user()->nip)->first();
        $cek_eselon = Struktur_jabatan::where('nama_jabatan', $pegawai->jabatan)->first();
        $kode_atasan = Struktur_jabatan::where('nama_jabatan', $pegawai->jabatan)->first();
        $cek_bawahan = Struktur_jabatan::where('kode_atasan', $kode_atasan->kode_jabatan)->get();
        
        if ($cek_eselon->eselon == "II.a" || $cek_eselon->eselon == "II.b" || (strpos($cek_eselon->nama_jabatan, 'Ahli Madya') !== false)) {
            $level_kompetensi = 4;}
        else if($cek_eselon->eselon == "III.a" || $cek_eselon->eselon == "III.b" || (strpos($cek_eselon->nama_jabatan, 'Ahli Muda') !== false) || (strpos($cek_eselon->nama_jabatan, 'Penyelia') !== false)){ 
            $level_kompetensi = 3;}
        else if($cek_eselon->eselon == "IV.a" || $cek_eselon->eselon == "IV.b" || (strpos($cek_eselon->nama_jabatan, 'Ahli Pertama') !== false) || (strpos($cek_eselon->nama_jabatan, 'Terampil') !== false) || (strpos($cek_eselon->nama_jabatan, 'Mahir') !== false)){ 
            $level_kompetensi = 2;}
        else { $level_kompetensi = 1;}

        

        return view('content.apps.bangkom-bawahan', compact('cek_eselon', 'kode_atasan', 'cek_bawahan', 'daftar_pegawai','pegawai', 'level_kompetensi'));
    }

    public function detail(Request $request, $id)
{
    $pegawai = Pegawai::where('id', $id)->first();
    $cek_eselon = Struktur_jabatan::where('nama_jabatan', $pegawai->jabatan)->first();
    $penilaian_bawahan = Penilaian_pribadi::where('nip', $pegawai->nip)->get();
    $status_penilaian = Penilaian_atasan::where('nip_bawahan', $pegawai->nip)->get();
    $nilai = Penilaian_pribadi::where('nip', $pegawai->nip)->get();
    $nilai_atasan = Penilaian_atasan::where('nip_bawahan', $pegawai->nip)->get();

    if ($cek_eselon->eselon == "II.a" || $cek_eselon->eselon == "II.b" || (strpos($cek_eselon->nama_jabatan, 'Ahli Madya') !== false)) {
        $level_kompetensi = 4;}
    else if($cek_eselon->eselon == "III.a" || $cek_eselon->eselon == "III.b" || (strpos($cek_eselon->nama_jabatan, 'Ahli Muda') !== false) || (strpos($cek_eselon->nama_jabatan, 'Penyelia') !== false)){ 
        $level_kompetensi = 3;}
    else if($cek_eselon->eselon == "IV.a" || $cek_eselon->eselon == "IV.b" || (strpos($cek_eselon->nama_jabatan, 'Ahli Pertama') !== false) || (strpos($cek_eselon->nama_jabatan, 'Terampil') !== false) || (strpos($cek_eselon->nama_jabatan, 'Mahir') !== false)){ 
        $level_kompetensi = 2;}
    else { $level_kompetensi = 1;}

    $manajerial = Formulir::where('level_kompetensi', $level_kompetensi)
                    ->where('kategori_kompetensi', 'Kompetensi Manajerial')
                    ->get();
    $soskul = Formulir::where('level_kompetensi', $level_kompetensi)
                    ->where('kategori_kompetensi', 'Kompetensi Sosial Kultural')
                    ->get();
    $teknis = Formulir::where('level_kompetensi', $level_kompetensi)
                    ->where('kategori_kompetensi', 'Kompetensi Teknis')
                    ->where(function($query) use ($pegawai) {
                        $query->where('jabatan', $pegawai->jabatan)
                              ->orWhere('jabatan_ketik', $pegawai->jabatan);
                    })
                    ->get();

    $indikator = Formulir_indikator::all();
    $sub_indikator = Formulir_sub_indikator::all();

    return view('diklat_atasan.index_detail', compact(
        'cek_eselon', 'penilaian_bawahan', 'pegawai', 'status_penilaian',
        'level_kompetensi', 'manajerial', 'soskul', 'teknis', 'indikator',
        'sub_indikator'
    ));
}


    




public function update(Request $request)
{
    $diklatId = $request->input('diklat_id');
    $isChecked = $request->input('checked');
    $nipAtasan = auth()->user()->nip; // Assuming the atasan's NIP is the currently logged-in user's NIP
    $nipBawahan = $request->input('nip_bawahan');

    // Find the Komtek entry related to the specific bawahan
    $komtek = Komtek::where('nip_bawahan', $nipBawahan)
                    ->where('id_diklat_bawahan', $diklatId)
                    ->first();

    if ($isChecked) {
        // Ensure the atasan has not checked more than 5 options
        $countChecked = Komtek::where('nip_atasan', $nipAtasan)
                              ->where('nip_bawahan', $nipBawahan)
                              ->count();

        if ($countChecked >= 1) {
            return response()->json(['error' => 'You can only select 1 items.'], 400);
        }

        if ($komtek) {
            // Update the existing record
            $komtek->update([
                'nip_atasan' => $nipAtasan,
                'id_diklat_atasan' => $diklatId,
                'creator' => $nipAtasan, // Set the creator as the atasan
            ]);
        } else {
            // Create a new Komtek record if it doesn't exist
            Komtek::create([
                'nip_atasan' => $nipAtasan,
                'nip_bawahan' => $nipBawahan,
                'id_diklat_atasan' => $diklatId,
                'id_diklat_bawahan' => $diklatId,
                'creator' => $nipAtasan, // Set the creator as the atasan
            ]);
        }
    } else {
        // If unchecked, remove both the id_diklat_atasan and nip_atasan fields from the record
        if ($komtek) {
            // Clear the id_diklat_atasan and nip_atasan only if it matches the current diklat ID
            if ($komtek->id_diklat_atasan == $diklatId) {
                $komtek->update([
                    'id_diklat_atasan' => null,  // Clear the id_diklat_atasan field
                    'nip_atasan' => null         // Clear the nip_atasan field
                ]);
            }
        }
    }

    return response()->json(['success' => 'Update successful']);
}






public function loadChecklist(Request $request, $id)
{
    // Retrieve the current user's data based on the ID
    $pegawai = Pegawai::where('id', $id)->first();

    if ($request->ajax()) {
        // Initialize the query for DaftarDiklat
        $data = DaftarDiklat::with('perangkatdaerah')
            ->select(['daftar_diklat.id', 'daftar_diklat.nama_diklat', 'daftar_diklat.unit_kerja', 'daftar_diklat.uptd']);

        // Remove filters for unit_kerja and other specific departments
        // Now, the function will retrieve all DaftarDiklat data regardless of the user's unit_kerja
        
        // Join with komtek to show the selected diklat bawahan
        $data = $data->join('komtek', function ($join) use ($pegawai) {
            $join->on('daftar_diklat.id', '=', 'komtek.id_diklat_bawahan')
                 ->where('komtek.nip_bawahan', '=', $pegawai->nip);
        })
        ->select(
            'daftar_diklat.id',
            'daftar_diklat.nama_diklat',
            'komtek.id_diklat_bawahan',
            'komtek.id_diklat_atasan as is_checked'
        )
        ->get();

        // Fetch the list of selected diklats by this user for checkboxes
        return datatables()->of($data)
            ->addColumn('id_diklat_bawahan', function ($row) {
                return $row->id_diklat_bawahan ? '<i class="fas fa-check"></i>' : '';
            })
            ->addColumn('aksi', function ($row) {
                $checked = $row->is_checked ? 'checked' : '';
                return '<input type="checkbox" name="action[]" value="' . $row->id . '" class="action-checkbox" ' . $checked . '>';
            })
            ->rawColumns(['id_diklat_bawahan', 'aksi'])
            ->make(true);
    }
}




    public function nilai_atasan(Request $request, $id)
    {
        // $formulirs  = Penilaian_pribadi::find($id);
        $id_pegawai = $request->id_pegawai;
        $pegawai    = Pegawai::where('id', $id_pegawai)->first();
        $cek_eselon = Struktur_jabatan::where('nama_jabatan', $pegawai->jabatan)->first();
        
        if($cek_eselon->eselon == "II.a" || $cek_eselon->eselon == "II.b"){ $level_kompetensi = 4;}
        else if($cek_eselon->eselon == "III.a" || $cek_eselon->eselon == "III.b"){ $level_kompetensi = 3;}
        else if($cek_eselon->eselon == "IV.a" || $cek_eselon->eselon == "IV.b"){ $level_kompetensi = 2;}
        else { $level_kompetensi = 1;}

        $indikator              = Formulir_indikator::where('id', $request->id_indikator)->first();
        $sub_indikator          = Formulir_sub_indikator::where('id_indikator', $id)->get();
        $jumlah_sub_indikator   = Formulir_sub_indikator::where('id_indikator', $id)->count();
        $nilai                  = Penilaian_pribadi::where('nip', $pegawai->nip)->get();
        $nilai_atasan           = Penilaian_atasan::where('nip_atasan', Auth::user()->nip)->get();
        
        return view('diklat_atasan.penilaian_sub_indikator',compact('cek_eselon','pegawai', 'level_kompetensi', 'indikator', 'sub_indikator', 'jumlah_sub_indikator', 'nilai', 'nilai_atasan'));
    }

    public function store(Request $request)
    {
        $data_penilaian = Penilaian_atasan::where('nip_atasan', Auth::user()->nip)->where('nip_bawahan', $request->nip_bawahan)->where('id_sub_indikator', $request->id_sub_indikator)->get();

        if($data_penilaian->count() >= 1){
            foreach($data_penilaian as $item){
                $data = Penilaian_atasan::findOrFail($item->id);
                $data->update([
                    'skala' => $request->skala_atasan
                ]);
            }
        } else {
            $data['id_indikator']       = $request->id_indikator;
            $data['id_sub_indikator']   = $request->id_sub_indikator;
            $data['nip_atasan']         = Auth::user()->nip;
            $data['nip_bawahan']        = $request->nip_bawahan;
            $data['skala']              = $request->skala_atasan;

            Penilaian_atasan::create($data);
        }
        
        // return redirect('/penilaian_pribadi')->with('success', 'Data berhasil disimpan');
        return back()->with('success', 'Data berhasil disimpan');
    }

   

    public function excelUser(Request $request, User $user)
    {
        return Excel::download(new PresentExport($user->id, $request->bulan), 'kehadiran-'.$user->nrp.'-'.$request->bulan.'.xlsx');
    }

    public function excelUsers(Request $request)
    {
        return Excel::download(new UsersPresentExport($request->tanggal), 'kehadiran-'.$request->tanggal.'.xlsx');
    }

    public function getDiklatData(Request $request)
    {
        // Get the current user's NIP and details
        $pegawai = Pegawai::where('nip', Auth::user()->nip)->first();
    
        // Determine the correct kode_atasan based on the user's position
        if ($pegawai->jabatan_tambahan) {
            // If the user has a jabatan_tambahan, search based on that
            $kode_atasan = Struktur_jabatan::where('nama_jabatan', $pegawai->jabatan_tambahan)
                ->where('perangkat_daerah', $pegawai->unit_kerja)
                ->first()->kode_jabatan;
        } else {
            // If no jabatan_tambahan, check if UPTD exists
            if ($pegawai->uptd) {
                // If UPTD is not null, filter using both perangkat_daerah and UPTD
                $kode_atasan = Struktur_jabatan::where('nama_jabatan', $pegawai->jabatan)
                    ->where('perangkat_daerah', $pegawai->unit_kerja)
                    ->where('unit_kerja', $pegawai->uptd)
                    ->first()->kode_jabatan;
            } else {
                // If no UPTD, just filter by perangkat_daerah
                $kode_atasan = Struktur_jabatan::where('nama_jabatan', $pegawai->jabatan)
                    ->where('perangkat_daerah', $pegawai->unit_kerja)
                    ->first()->kode_jabatan;
            }
        }
    
        if($pegawai->jabatan != "SEKRETARIS DAERAH"){
            $query = Pegawai::join('struktur_jabatans as s', function($join) use ($pegawai) {
                        // Match both unit_kerja and UPTD
                        $join->on('pegawais.unit_kerja', '=', 's.perangkat_daerah')
                              ->on('pegawais.uptd', '=', 's.unit_kerja');
                    })
                    ->where('s.kode_atasan', $kode_atasan)
                    ->where('pegawais.jabatan', '!=', 'PNS Tugas Belajar') // Exclude specific role
                    ->whereColumn('s.nama_jabatan', 'pegawais.jabatan')
                    ->distinct() // Ensure distinct pegawais.nama
                    ->select('pegawais.id', 'pegawais.nip', 'pegawais.nama', 'pegawais.jabatan', 'pegawais.eselon', 'pegawais.unit_kerja', 'pegawais.uptd', 
                            's.nama_jabatan', 's.eselon as eselon_jabatan', 's.level_kompetensi', 's.perangkat_daerah', 's.unit_kerja as unit_jabatan')
                    ->get();
        } else {
            $query = Pegawai::join('struktur_jabatans as s', function($join) use ($pegawai) {
                    // Match both unit_kerja and UPTD
                    $join->on('pegawais.unit_kerja', '=', 's.perangkat_daerah');
                })
                ->where('s.kode_atasan', $kode_atasan)
                ->where('pegawais.jabatan', '!=', 'PNS Tugas Belajar') // Exclude specific role
                ->whereColumn('s.nama_jabatan', 'pegawais.jabatan')
                ->distinct() // Ensure distinct pegawais.nama
                ->select('pegawais.id', 'pegawais.nip', 'pegawais.nama', 'pegawais.jabatan', 'pegawais.eselon', 'pegawais.unit_kerja', 'pegawais.uptd', 
                        's.nama_jabatan', 's.eselon as eselon_jabatan', 's.level_kompetensi', 's.perangkat_daerah', 's.unit_kerja as unit_jabatan')
                ->get();
        }
    
        return DataTables::of($query)
            ->addColumn('aksi', function($row) {
                return '<a href="'.route('diklat_atasan.detail', $row->id).'" class="btn btn-sm btn-success" title="diklat penilaian"><i class="fas fa-pen"></i></a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    
}