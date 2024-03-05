<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        $data['siswa'] = DB::select("select u.*, k.nama_kelas from users u, kelas k where u.kelas_id=k.id and u.status = 'ON' and u.role = '2'");
        $data['kelas'] = DB::table('kelas')->get();
        $data['jurusan'] = DB::table('jurusan')->get();
        // dd(count($data['guru']));
        return view('content.siswa.index', $data);
    }
    function add(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2,
            'kelas_id' => $request->kelas_id,
            'jurusan_id' => $request->jurusan_id,
            'created_at' => now(),

        ];
        DB::table('users')->insert($data);
        return redirect('/siswa');
    }
    function edit(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'kelas_id' => $request->kelas_id,
            'jurusan_id' => $request->jurusan_id,
            'updated_at' => now(),

        ];
        DB::table('users')->where('id', $request->id)->update($data);
        return redirect('/siswa');
    }

    function delete($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect('/siswa');
    }
}
