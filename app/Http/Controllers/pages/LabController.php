<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LabController extends Controller
{
    public function index()
    {
        $data['lab'] = DB::select("select l.*, j.nama_jurusan from lab l, jurusan j where l.id_jurusan=j.id");
        $data['jurusan'] = DB::table('jurusan')->get();
        $data['status'] = ['ON', 'OFF'];
        // dd(count($data['guru']));
        return view('content.lab.index', $data);
    }
    function add(Request $request)
    {
        $data = [
            'nama_lab' => Str::upper($request->nama_lab),
            'id_jurusan' => $request->id_jurusan,
            'status' => 'ON',
            'created_at' => now(),

        ];
        DB::table('lab')->insert($data);
        return redirect('/lab');
    }
    function edit(Request $request)
    {
        $data = [
            'nama_lab' => Str::upper($request->nama_lab),
            'id_jurusan' => $request->id_jurusan,
            'status' => $request->status,
            'updated_at' => now(),
        ];
        DB::table('lab')->where('id', $request->id)->update($data);
        return redirect('/lab');
    }

    function delete($id)
    {
        DB::table('lab')->where('id', $id)->delete();
        return redirect('/lab');
    }
}
