<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller; // Import the base Controller
use App\Models\Data_Bangkom;
use App\uptd;
use App\Models\Pegawai;
use App\DiklatMandiri;
use App\Models\Perangkat_daerah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Helpers\LogHelper; // Ensure LogHelper is imported

class DataBangkomController extends Controller
{
   
    public function index(Request $request)
{
    // Fetch distinct unit_kerja
    $unit_kerjas = Pegawai::select('unit_kerja')->distinct()->get();

    // Fetch current user's Pegawai record
    $pegawai = Pegawai::where('nip', Auth::user()->nip)->first();
    $uptds = Pegawai::where('unit_kerja', $pegawai->unit_kerja)->select('uptd')->distinct()->get();

    // Fetch perangkat daerah
    $perangkat_daerahs = Auth::user()->id_role == 2 
        ? Perangkat_daerah::where('nama_perangkat_daerah', $pegawai->unit_kerja)->get() 
        : Perangkat_daerah::all();

    // Handle AJAX request
    if ($request->ajax()) {
        $search = $request->get('search')['value']; // Search input

        // Initialize query for DataBangkom
        $data = Data_Bangkom::with('perangkatdaerah')
            ->select(['id', 'nama_diklat', 'unit_kerja', 'uptd', 'tahun']);

        if (Auth::user()->id_role == 2 && $pegawai) {
            // Define a filter function to reduce repetition
            $applyFilters = function ($query) use ($pegawai) {
                if (stripos($pegawai->unit_kerja, 'KECAMATAN') !== false) {
                    $query->where('unit_kerja', 'like', '%KECAMATAN%')
                          ->where('uptd', 'like', '%KELURAHAN%');
                } elseif (stripos($pegawai->unit_kerja, 'DINAS KESEHATAN') !== false) {
                    $query->where('unit_kerja', 'DINAS KESEHATAN')
                          ->where('uptd', 'like', '%PUSKESMAS%')
                          ->orWhere('uptd', 'like', '%LAB KESEHATAN%')
                          ->orWhere('uptd', 'like', '%RUMAH SAKIT UMUM%')
                          ->orWhere('uptd', 'like', '%FARMASI%');
                } elseif (stripos($pegawai->unit_kerja, 'DINAS PENDIDIKAN DAN KEBUDAYAAN') !== false) {
                    $query->where('unit_kerja', 'DINAS PENDIDIKAN DAN KEBUDAYAAN')
                          ->where('uptd', 'like', '%SD NEGERI%')
                          ->orWhere('uptd', 'like', '%TK NEGERI%')
                          ->orWhere('uptd', 'like', '%SMP NEGERI%');
                } else {
                    // Default filter for other unit_kerja
                    $query->where('unit_kerja', $pegawai->unit_kerja);
                }
            };

            // Apply the defined filters
            $data->where(function ($query) use ($applyFilters) {
                $applyFilters($query);
            });
        }

        // Apply search filter
        if (!empty($search)) {
            $data->where(function ($query) use ($search) {
                $query->where('nama_diklat', 'like', "%{$search}%")
                      ->orWhere('unit_kerja', 'like', "%{$search}%")
                      ->orWhere('uptd', 'like', "%{$search}%")
                      ->orWhere('tahun', 'like', "%{$search}%");
            });
        }

        // Return the filtered data for the datatable
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('id_perangkat_daerahs', function($row) {
                return $row->perangkatdaerah ? $row->perangkatdaerah->nama_perangkat_daerah : '-';
            })
            ->editColumn('id_uptd', function($row) {
                return $row->id_uptd;
            })
            ->make(true);
    }

    // Return view with required data
    return view('content.apps.app-data-bangkom', compact('unit_kerjas', 'perangkat_daerahs', 'pegawai', 'uptds'));
}






    
    public function create()
    {
        return view('daftar_diklat.create');
    }

   
    public function store(Request $request)
{
    $request->validate([
        'nama_diklat' => 'required|string',
        'unit_kerja' => 'required|string', // Validate unit_kerja
    ]);

    $diklat = Data_Bangkom::create([
        'nama_diklat' => $request->nama_diklat,
        'unit_kerja' => $request->unit_kerja, // Store unit_kerja
        'uptd' => $request->uptd, // Store uptd
        'tahun' => $request->tahun, // Store tahun
    ]);

    // Log the creation action
    $userNIP = auth()->user()->nip; // Ensure the user is authenticated
    LogHelper::logAction('create', 'Data_Bangkom', $diklat->id, $userNIP, null, $diklat->toArray());

    return back()->with('success', 'Data successfully added');
}




public function getUptds(Request $request)
{
    if ($request->ajax()) {
        $unitKerja = $request->input('unit_kerja');

        // Fetch distinct `uptd` values related to the selected `unit_kerja`, excluding unwanted values
        $uptds = Pegawai::where('unit_kerja', $unitKerja)
                        ->whereNotNull('uptd') // Exclude null values
                        ->where('uptd', '!=', 'NULL') // Exclude "NULL" string values
                        ->where('uptd', 'not like', '%Bidang%') // Exclude values containing "Bidang"
                        ->where('uptd', 'not like', '%INSPEKTUR%') // Exclude values containing "Bidang"
                        ->where('uptd', 'not like', '%SEKSI%') // Exclude values containing "Bidang"
                        ->where('uptd', 'not like', '%kelompok jabatan fungsional%') // Exclude "kelompok jabatan fungsional"
                        ->where('uptd', 'not like', '%sekretariat%') // Exclude "sekretariat"
                        ->where('uptd', 'not like', '%bagian%') // Exclude "sekretariat"
                        ->where('uptd', 'not like', '%staff ahli%') // Exclude "sekretariat"
                        ->select('uptd')
                        ->distinct()
                        ->get();

        // Return the filtered `uptd` data as a JSON response
        return response()->json($uptds);
    }
}



    
    
    public function show(DaftarDiklat $daftarDiklat)
    {
        return view('daftar_diklat.show', compact('daftarDiklat'));
    }

   
    public function edit($id)
    {
        $daftarDiklat = Data_Bangkom::findOrFail($id);
        return response()->json($daftarDiklat);
    }

   
    public function update(Request $request, $id)
{
    $request->validate([
        'nama_diklat' => 'required|string|max:255',
        'unit_kerja' => 'required|string',
        'uptd' => 'nullable|string',
        'tahun' => 'nullable|string|max:4',
    ]);

    $diklat = Data_Bangkom::findOrFail($id);
    $oldData = $diklat->toArray(); // Capture the old data

    $diklat->update($request->only(['nama_diklat', 'unit_kerja', 'uptd', 'tahun']));
    $newData = $diklat->toArray(); // Capture the updated data

    // Log the update action
    $userNIP = auth()->user()->nip;
    LogHelper::logAction('update', 'Data_Bangkom', $id, $userNIP, $oldData, $newData);

    return back()->with('success', 'Daftar Bangkom updated successfully.');
}






   
public function destroy($id)
{
    $daftarDiklat = Data_Bangkom::findOrFail($id);
    $oldData = $daftarDiklat->toArray(); // Capture the data before deletion

    $daftarDiklat->delete();

    // Log the delete action
    $userNIP = auth()->user()->nip;
    LogHelper::logAction('delete', 'Data_Bangkom', $id, $userNIP, $oldData);

    return back()->with('success', 'Daftar Bangkom deleted successfully.');
}



}
