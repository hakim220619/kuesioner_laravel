<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurusanController extends Controller
{
    public function index()
    {
        $data['jurusan'] = DB::table('jurusan')->get();
        $data['status'] = ['ON', 'OFF'];
        // dd(count($data['guru']));
        return view('content.jurusan.index', $data);
    }
    function add(Request $request)
    {
        $data = [
            'nama_jurusan' => $request->nama_jurusan,
            'status' => 'ON',
            'created_at' => now(),

        ];
        DB::table('jurusan')->insert($data);
        return redirect('/jurusan');
    }
    function edit(Request $request)
    {
        $data = [
            'nama_jurusan' => $request->nama_jurusan,
            'status' => $request->status,
            'updated_at' => now(),

        ];
        DB::table('jurusan')->where('id', $request->id)->update($data);
        return redirect('/jurusan');
    }

    function delete($id)
    {
        DB::table('jurusan')->where('id', $id)->delete();
        return redirect('/jurusan');
    }
}
