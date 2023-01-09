<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\DataResource;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index()
    {
        $user = User::latest()->paginate(5);
        return new DataResource(true, 'List Data User', $user);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'nama_lengkap' => 'required',
            'no_telp' => 'required',
            'password' => ['required', 'string', 'min:8'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],            
            'is_admin' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'is_admin' => $request->is_admin,
        ]);

        return new DataResource(true, 'Data User Berhasil Ditambahkan!', $user);
    }

    public function show(User $user)
    {
        return new DataResource(true, 'Data User Ditemukan!', $user);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'name' => 'required',
            'username' => 'required',
            'nama_lengkap' => 'required',
            'no_telp' => 'required',
            'password' => ['required', 'string', 'min:8'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],            
            'is_admin' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'is_admin' => $request->is_admin,
        ]);
        return new DataResource(true, 'Data User Berhasil Diubah!', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return new DataResource(true, 'Data User Berhasil Dihapus!', null);
    }
}
