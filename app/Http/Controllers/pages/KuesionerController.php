<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KuesionerController extends Controller
{
    public function index($id)
    {
        // dd($id);
        $data['guru'] = DB::table('users')->where('role', '3')->where('status', 'ON')->where('id', $id)->get();
        // dd(count($data['guru']));
        $data['pertanyaan'] = DB::table('pertanyaan')->where('status', 'ON')->get();
        $data['done'] = DB::table('kuesioner')->where('id_guru', $id)->where('id_kelas', request()->user()->kelas_id)->get();
        // dd($data['done']);
        return view('content.kuesioner.index', $data);
    }
    public function listGuru()
    {
        $data['guru'] = DB::select("select u.*, k.nama_kelas from users u, kelas k where u.kelas_id=k.id and u.status = 'ON' and u.role = '3' and kelas_id = " . request()->user()->kelas_id . "");
        // dd(count($data['guru']));
        return view('content.kuesioner.listguru', $data);
    }
    function add(Request $request)
    {
        $cekData = DB::table('kuesioner')->where('id_guru', $request->id_guru)->where('id_siswa', request()->user()->id)->where('id_kelas', $request->id_kelas)->where('id_pertanyaan', $request->id_pertanyaan)->first();

        if ($cekData == null) {
            # code...

            $data = [
                'id_guru' => $request->id_guru,
                'id_siswa' => request()->user()->id,
                'id_kelas' => $request->id_kelas,
                'id_pertanyaan' => $request->id_pertanyaan,
                'nilai' =>  $request->nilai,
                'created_at' => now()
            ];
            DB::table('kuesioner')->insert($data);
            return response()->json([
                'success' => true
            ]);
        } else {
            $data = [
                'id_guru' => $request->id_guru,
                'id_siswa' => request()->user()->id,
                'id_kelas' => $request->id_kelas,
                'id_pertanyaan' => $request->id_pertanyaan,
                'nilai' =>  $request->nilai,
                'created_at' => now()
            ];
            DB::table('kuesioner')->where('id_guru', $request->id_guru)->where('id_siswa', request()->user()->id)->where('id_kelas', $request->id_kelas)->where('id_pertanyaan', $request->id_pertanyaan)->update($data);
            return response()->json([
                'success' => true
            ]);
        }
        // dd($data);
    }
}
