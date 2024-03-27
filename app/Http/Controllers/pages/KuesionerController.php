<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KuesionerController extends Controller
{
    public function index($id)
    {
        // dd($id);
        $data['guru'] = DB::table('users')->where('role', '3')->where('status', 'ON')->where('id', $id)->get();
        // dd(count($data['guru']));
        $data['pertanyaan'] = DB::table('pertanyaan')->where('status', 'ON')->where('type', 'PENGAJAR')->get();
        $data['done'] = DB::table('kuesioner')->where('id_guru', $id)->where('id_kelas', request()->user()->kelas_id)->get();
        $data['id_guru'] = $id;
        $data['id_kelas'] =  request()->user()->kelas_id;
        // dd($data['done']);
        return view('content.kuesioner.index', $data);
    }
    public function lab($nama_pertanyaan)
    {
        // dd(count($data['guru']));
        $data['laboratorium'] = DB::table('pertanyaan')->where('status', 'ON')->where('type', $nama_pertanyaan)->get();
        // $data['done'] = DB::table('kuesioner')->where('id_guru', $id)->where('id_kelas', request()->user()->kelas_id)->get();
        $data['id_kelas'] =  request()->user()->kelas_id;
        // dd($nama_pertanyaan);
        return view('content.kuesioner.lab', $data);
    }
    public function perpustakaan()
    {
        // dd(count($data['guru']));
        $data['perpustakaan'] = DB::table('pertanyaan')->where('status', 'ON')->where('type', 'PERPUSTAKAAN')->get();
        // $data['done'] = DB::table('kuesioner')->where('id_guru', $id)->where('id_kelas', request()->user()->kelas_id)->get();
        $data['id_kelas'] =  request()->user()->kelas_id;
        // dd($nama_pertanyaan);
        return view('content.kuesioner.perpus', $data);
    }
    public function listkuesioner()
    {
        $data['guru'] = DB::select("select u.*, k.nama_kelas from users u, kelas k where u.kelas_id=k.id and u.status = 'ON' and u.role = '3' and kelas_id = " . request()->user()->kelas_id . "");
        // dd(count($data['guru']));
        $data['perpustakaan'] = DB::table('pertanyaan')->where('status', 'ON')->where('type', 'PERPUSTAKAAN')->get();
        $data['laboratorium'] = DB::table('pertanyaan')->where('status', 'ON')->where('type', 'LABORATORIUM')->get();

        return view('content.kuesioner.listkuesioner', $data);
    }
    public function listlab()
    {
        $data['lab'] = DB::select("select l.*, j.nama_jurusan from lab l, jurusan j where l.id_jurusan=j.id and j.id = " . request()->user()->jurusan_id . "");
        // dd($data);

        return view('content.kuesioner.listlab', $data);
    }
    function add(Request $request)
    {
        $cekData = DB::table('kuesioner')->where('id_guru', $request->id_guru)->where('id_siswa', request()->user()->id)->where('id_kelas', $request->id_kelas)->where('id_pertanyaan', $request->id_pertanyaan)->first();
        // dd($cekData);
        if ($cekData == null) {
            # code...

            $data = [
                'id_guru' => $request->id_guru == null ? 0 : $request->id_guru,
                'id_siswa' => request()->user()->id,
                'id_kelas' => $request->id_kelas == null ? request()->user()->kelas_id : $request->id_kelas,
                'id_jurusan' => $request->id_jurusan == null ? request()->user()->jurusan_id : $request->id_jurusan,
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
                'id_guru' => $request->id_guru == null ? 0 : $request->id_guru,
                'id_siswa' => request()->user()->id,
                'id_kelas' => $request->id_kelas == null ? request()->user()->kelas_id : $request->id_kelas,
                'id_jurusan' => $request->id_jurusan == null ? request()->user()->jurusan_id : $request->id_jurusan,
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

    function load_data(Request $request)
    {
        $data = DB::table('kuesioner')->where('id_guru', $request->id_guru)->where('id_kelas', $request->id_kelas)->where('id_siswa', request()->user()->id)->get();
        echo json_encode($data);
    }
    function keusionerall()
    {
        $data = DB::table('kuesioner')->where('id_kelas', request()->user()->kelas_id)->where('id_siswa', request()->user()->id)->get();
        echo json_encode($data);
    }
}
