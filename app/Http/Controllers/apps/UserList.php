<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\User_role;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserList extends Controller
{
    public function index()
    {
        
        return view('content.apps.app-user-list');
    }

    public function getPegawaiData(Request $request)
    {
        if ($request->ajax()) {
            $data = Pegawai::select(['id', 'nip', 'nama', 'eselon', 'jabatan', 'unit_kerja','uptd', 'created_at', 'updated_at']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'unit_kerja' => 'required|string',
            'uptd' => 'required|string',
        ]);

        Pegawai::create($request->all());
        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return response()->json($pegawai);
    } 

        public function edit($id)
    {
        $user = Pegawai::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = Pegawai::findOrFail($id);

        $request->validate([
            'id_role' => ['required', 'numeric']
        ]);

        $user->id_role = $request->id_role;
        $user->save();

        return response()->json(['success' => 'Pengguna berhasil diperbarui']);
    }


        public function role()
    {
        $roles = User_role::all(); // Assuming `Role` is your model for roles
        return response()->json($roles);
    }

    public function destroy($id)
    {
        Pegawai::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}