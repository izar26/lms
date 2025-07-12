<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * READ
     */
    public function index(Request $request)
{
    $roleFilter = $request->input('role');

    $users = User::with(['role', 'kursus'])
    ->when($roleFilter, function ($query, $roleFilter) {
        $query->whereHas('role', function ($q) use ($roleFilter) {
            $q->where('name', $roleFilter);
        });
    }, function ($query) {
        $query->whereHas('role', function ($q) {
            $q->where('name', '!=', 'Administrator');
        });
    })
    ->latest()
    ->get();


    return view('admin.users.index', compact('users', 'roleFilter'));
}



    /**
     * Show the form for creating a new resource.
     * CREATE (FORM)
     */
    public function create()
    {
        // Mengambil semua role untuk ditampilkan di dropdown form
        $roles = Role::all();
        
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * CREATE (PROCESS)
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' akan mencocokkan dengan input 'password_confirmation'
            'role_id' => 'required|exists:roles,id',
        ]);

        // Membuat user baru di database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password wajib di-hash
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * (Optional, bisa tidak digunakan jika detail user tidak diperlukan di halaman terpisah)
     */
    public function show(User $user)
    {
        // Biasanya untuk menampilkan detail satu user.
        // Kita bisa redirect ke halaman edit saja untuk simpelnya.
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     * UPDATE (FORM)
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     * UPDATE (PROCESS)
     */
    public function update(Request $request, User $user)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed', // Password tidak wajib diisi saat update
        ]);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        
        // Cek jika ada input password baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save(); // Simpan perubahan

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE
     */
    public function destroy(User $user)
    {
        // Hapus data user
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}