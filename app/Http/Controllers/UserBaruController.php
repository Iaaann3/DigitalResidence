<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class UserBaruController extends Controller
{
    public function index()
    {
        $users = User::orderBy('no_rumah', 'asc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'no_rumah' => 'required|string|unique:users,no_rumah',
            'no_tlp'   => 'required|string|max:20',
            'alamat'   => 'required|string|max:500',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required'      => 'Nama harus diisi',
            'email.unique'       => 'Email sudah digunakan',
            'no_rumah.unique'    => 'No Rumah sudah terdaftar',
            'password.min'       => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'no_rumah' => strtoupper($request->no_rumah),
            'no_tlp'   => $request->no_tlp,
            'alamat'   => $request->alamat,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User baru berhasil ditambahkan.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:5120',
        ], [
            'file.required' => 'File Excel harus diupload',
            'file.mimes'    => 'Format file harus .xlsx atau .xls',
        ]);

        try {
            $import = new UsersImport;
            Excel::import($import, $request->file('file'));

            $imported = $import->getImportedCount();
            $failures = $import->getFailures();
            $errors   = $import->getErrors();

            // Ada baris yang diskip karena validasi gagal
            if (!empty($failures)) {
                $skipLines = collect($failures)
                    ->map(function ($f) {
                        $errorMsg = implode(', ', $f['errors']);
                        $value    = $f['values'][$f['field']] ?? '-';
                        return "Baris {$f['row']} [{$f['field']}: {$value}] → {$errorMsg}";
                    })
                    ->implode(' | ');

                $message = $imported > 0
                    ? "{$imported} user berhasil diimport. Baris diskip: {$skipLines}"
                    : "Tidak ada user yang diimport. Semua baris gagal: {$skipLines}";

                return redirect()->route('admin.users.index')
                    ->with($imported > 0 ? 'warning' : 'error', $message);
            }

            // Ada error teknis (DB error, dll)
            if (!empty($errors)) {
                $errorMsg = implode(' | ', $errors);
                return redirect()->route('admin.users.index')
                    ->with('error', "Import selesai dengan error teknis: {$errorMsg}");
            }

            // Semua sukses
            return redirect()->route('admin.users.index')
                ->with('success', "{$imported} user berhasil diimport dari Excel!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new \App\Exports\UsersTemplateExport, 'template_import_user.xlsx');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'no_rumah' => 'required|string|unique:users,no_rumah,' . $user->id,
            'no_tlp'   => 'required|string|max:20',
            'alamat'   => 'required|string|max:500',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->no_rumah = strtoupper($request->no_rumah);
        $user->no_tlp   = $request->no_tlp;
        $user->alamat   = $request->alamat;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}