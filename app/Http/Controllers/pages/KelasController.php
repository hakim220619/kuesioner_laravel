<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function index()
    {
        $data['kelas'] = DB::table('kelas')->get();
        $data['status'] = ['ON', 'OFF'];
        // dd(count($data['guru']));
        return view('content.kelas.index', $data);
    }
    function add(Request $request)
    {
        $data = [
            'nama_kelas' => $request->nama_kelas,
            'status' => 'ON',
            'created_at' => now(),

        ];
        DB::table('kelas')->insert($data);
        return redirect('/kelas');
    }
    function edit(Request $request)
    {
        $data = [
            'nama_kelas' => $request->nama_kelas,
            'status' => $request->status,
            'updated_at' => now(),

        ];
        DB::table('kelas')->where('id', $request->id)->update($data);
        return redirect('/kelas');
    }

    function delete($id)
    {
        DB::table('kelas')->where('id', $id)->delete();
        return redirect('/kelas');
    }
}
