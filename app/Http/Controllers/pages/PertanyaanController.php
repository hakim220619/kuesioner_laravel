<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PertanyaanController extends Controller
{
    public function index()
    {
        $data['pertanyaan'] = DB::table('pertanyaan')->get();
        $data['status'] = ['ON', 'OFF'];
        $data['type'] = ['PENGAJAR', 'PERPUSTAKAAN'];
        $data['lab'] = DB::table('lab')->get();

        // dd(count($data['guru']));
        return view('content.pertanyaan.index', $data);
    }
    function add(Request $request)
    {
        $data = [
            'nama_pertanyaan' => $request->nama_pertanyaan,
            'type' => $request->type,
            'status' => 'ON',
            'created_at' => now(),

        ];
        DB::table('pertanyaan')->insert($data);
        return redirect('/pertanyaan');
    }
    function edit(Request $request)
    {
        $data = [
            'nama_pertanyaan' => $request->nama_pertanyaan,
            'status' => $request->status,
            'type' => $request->type,

        ];
        DB::table('pertanyaan')->where('id', $request->id)->update($data);
        return redirect('/pertanyaan');
    }

    function delete($id)
    {
        DB::table('pertanyaan')->where('id', $id)->delete();
        return redirect('/pertanyaan');
    }
}
