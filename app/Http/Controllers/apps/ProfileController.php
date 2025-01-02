<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profil()
    {
        $pegawai = Pegawai::where('nip', Auth::user()->nip)->first();
        return view('content.apps.app-profile', compact('pegawai'));
    }

    public function updateProfil(Request $request, User $user)
    {
        $request->validate([
            'nip'   => ['required'],
            'name'  => ['required', 'string'],
            'phone' => ['required', 'string']
        ]);

        $user->pegawais->nama  = $request->name;
        $user->pegawais->phone = $request->phone;
        $user->pegawais->save();

        return response()->json(['success' => 'Profil berhasil diperbarui']);
    }

    public function updatePassword(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'password'                => 'required|string',
        'password_baru'           => 'required|min:8|required_with:konfirmasi_password|same:konfirmasi_password',
        'konfirmasi_password'     => 'required|min:8'
    ]);

    $user = Auth::user(); // Get the currently authenticated user

    // Check if the current password matches
    if (Hash::check($request->password, $user->password)) {
        // Check if the new password is different from the old one
        if ($request->password_baru !== $request->password) {
            // Update the user's password
            $user->password = Hash::make($request->password_baru);
            $user->save();

            // Redirect to profile with success message
            return redirect()->route('profil')->with('success', 'Password berhasil diperbarui');
        } else {
            // New password is the same as the old password
            return redirect()->back()->with('error', 'Password baru tidak boleh sama dengan password lama');
        }
    } else {
        // Current password is incorrect
        return redirect()->back()->with('error', 'Password lama tidak cocok');
    }
}
}