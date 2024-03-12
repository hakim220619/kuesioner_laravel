<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PengajarController extends Controller
{
    public function index()
    {
        $data['pengajar'] = DB::select("select u.*, k.nama_kelas, j.nama_jurusan from users u, kelas k, jurusan j where u.kelas_id=k.id and u.jurusan_id=j.id and u.role = 3");
        $data['kelas'] = DB::table('kelas')->get();
        $data['jurusan'] = DB::table('jurusan')->get();
        $data['status'] = ['ON', 'OFF'];

        // dd(count($data['guru']));
        return view('content.pengajar.index', $data);
    }
    function add(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 3,
            'kelas_id' => $request->kelas_id,
            'jurusan_id' => $request->jurusan_id,
            'created_at' => now(),

        ];
        DB::table('users')->insert($data);
        return redirect('/pengajar');
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
        return redirect('/pengajar');
    }

    function delete($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect('/pengajar');
    }
}
