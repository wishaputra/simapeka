<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller; // Import the base Controller
use App\Models\Data_Bangkom;
use App\Models\Komtek;
use App\uptd;
use App\Models\Pegawai;
use App\DiklatMandiri;
use App\Models\Perangkat_daerah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class BangkomMandiri extends Controller
{
    // Display a listing of the resource.
    public function index(Request $request)
{
    // Get the current user's NIP
    $userNip = Auth::user()->nip;

    // Retrieve the user's unit_kerja and uptd from the Pegawai model
    $pegawai = Pegawai::where('nip', $userNip)->first();

    // Check if the request is AJAX for DataTables
    if ($request->ajax()) {
        // Initialize the query for DaftarDiklat
        $data = Data_Bangkom::with('perangkatdaerah')
            ->select(['id', 'nama_diklat', 'unit_kerja', 'uptd']);

            if ($pegawai) {
                $pegawai = Pegawai::where('nip', Auth::user()->nip)->first();
                if ($pegawai) {
                    // Check if the user's unit_kerja contains 'KECAMATAN'
                    if (stripos($pegawai->unit_kerja, 'KECAMATAN') !== false) {
                        $data->where('unit_kerja', 'like', '%KECAMATAN%')
                             ->where('uptd', 'like', '%KELURAHAN%'); // Filter for UPTD KELURAHAN under KECAMATAN
                    } else {
                        // For other specific units like DINAS KESEHATAN and DINAS PENDIDIKAN DAN KEBUDAYAAN
                        $data->where('unit_kerja', $pegawai->unit_kerja);
            
                        // Add filter logic for DINAS KESEHATAN using LIKE for UPTD
                        if (stripos($pegawai->unit_kerja, 'DINAS KESEHATAN') !== false) {
                            $data->where(function($query) {
                                $query->where('uptd', 'like', '%PUSKESMAS%')
                                      ->orWhere('uptd', 'like', '%LABORATORIUM KESEHATAN%')
                                      ->orWhere('uptd', 'like', '%RUMAH SAKIT UMUM%')
                                      ->orWhere('uptd', 'like', '%FARMASI%')
                                      ->orWhere('unit_kerja', 'like', '%DINAS KESEHATAN');
                            }); // Filter UPTD under DINAS KESEHATAN using LIKE
                        }
                        
                        // Add filter logic for DINAS PENDIDIKAN DAN KEBUDAYAAN using LIKE for UPTD
                        elseif (stripos($pegawai->unit_kerja, 'DINAS PENDIDIKAN DAN KEBUDAYAAN') !== false) {
                            $data->where(function($query) {
                                $query->where('uptd', 'like', '%SD NEGERI%')
                                      ->orWhere('uptd', 'like', '%TK NEGERI%')
                                      ->orWhere('uptd', 'like', '%SMP NEGERI%')
                                      ->orWhere('unit_kerja', 'like', '%DINAS PENDIDIKAN DAN KEBUDAYAAN%');
                            }); // Filter UPTD under DINAS PENDIDIKAN DAN KEBUDAYAAN using LIKE
                        }
                    }
                }
            }
            

        // Get the filtered data
        $data = $data->get();

        // Get the list of checked Diklat IDs for this user
        $checkedDiklatIds = Komtek::where('nip_bawahan', $userNip)
            ->pluck('id_diklat_bawahan')
            ->toArray();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('action', function ($row) use ($checkedDiklatIds) {
                $checked = in_array($row->id, $checkedDiklatIds) ? 'checked' : '';
                return '<input type="checkbox" name="skala[]" value="' . $row->id . '" class="diklat-checkbox" ' . $checked . '>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

  
    return view('content.apps.bangkom-mandiri', compact( 'pegawai'));
}










    // Show the form for creating a new resource.
    public function create()
    {
        return view('diklatmandiri.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'diklat_id' => 'required|integer|exists:daftar_diklat,id',
            'checked' => 'required|boolean',
        ]);

        $diklatId = $request->input('diklat_id');
        $isChecked = $request->input('checked');

        // Count selected items for the user
        $selectedCount = Komtek::where('nip_bawahan', Auth::user()->nip)->count();

        if ($isChecked && $selectedCount >= 3) {
            return response()->json(['message' => 'Hanya bisa Checklist 3 data!'], 400);
        }

        $existingDiklat = Komtek::where('id_diklat_bawahan', $diklatId)
                                ->where('nip_bawahan', Auth::user()->nip)
                                ->first();

        if ($isChecked) {
            if (!$existingDiklat) {
                Komtek::create([
                    'nip_bawahan' => Auth::user()->nip,
                    'id_diklat_bawahan' => $diklatId,
                    'creator' => Auth::user()->nip,
                ]);
            }
        } else {
            if ($existingDiklat) {
                $existingDiklat->delete();
            }
        }

        return response()->json(['message' => 'Success'], 200);
    }






    // Display the specified resource.
    public function show(Komtek $diklatMandiri)
    {
        return view('diklat_mandiri.show', compact('diklatMandiri'));
    }

    // Show the form for editing the specified resource.
    public function edit(Komtek $diklatMandiri)
    {
        return view('diklat_mandiri.edit', compact('diklatMandiri'));
    }

    // Update the specified resource in storage.
    public function update(Request $request)
{
    // Validate request data
    $request->validate([
        'diklat_id' => 'required|integer',
        'checked' => 'required|boolean'
    ]);

    $diklatId = $request->input('diklat_id');
    $isChecked = $request->input('checked');

    // Update the diklat record based on checkbox state
    $diklat = Komtek::find($diklatId);
    if ($diklat) {
        // Perform update or any other actions you need
        // For example:
        $diklat->some_field = $isChecked;  // Example field update
        $diklat->save();
    }

    return response()->json(['success' => true]);
}


    // Remove the specified resource from storage.
    public function destroy(Komtek $diklatMandiri)
    {
        // Delete the DiklatMandiri record
        $diklatMandiri->delete();

        // Redirect back to the index route with a success message
        return redirect()->route('diklat_mandiri.index')->with('success', 'Diklat Mandiri deleted successfully.');


    }


    public function save(Request $request)
{
    // Get the selected checkboxes
    $selectedSkala = $request->input('skala', []);

    // Update the `skala` field for the selected rows
    foreach ($selectedSkala as $id) {
        Komtek::where('id', $id)->update(['skala' => 1]);
    }

    // Redirect back with a success message
    return redirect()->route('diklat_mandiri.index')->with('success', 'Selection saved successfully.');
}


    private function getLevelKompetensi($eselon)
    {
        switch ($eselon) {
            case "II.a":
            case "II.b":
                return 4;
            case "III.a":
            case "III.b":
                return 3;
            case "IV.a":
            case "IV.b":
                return 2;
            default:
                return 1;
        }
    }
}