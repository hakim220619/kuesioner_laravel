<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePage extends Controller
{
  public function index()
  {
    $data['kelas'] = DB::table('kelas')->get();
    $data['lab'] = DB::table('lab')->get();
    return view('content.pages.pages-home', $data);
  }
  public function hasil()
  {
    $data['kelas'] = DB::table('kelas')->get();
    $data['lab'] = DB::table('lab')->get();
    $data['guru'] = DB::table('users')->where('role', 3)->get();
    return view('content.hasil.index', $data);
  }
  function getGuru($id)
  {
    $query = DB::table('users')->where('kelas_id', $id)->where('role', 3)->get();
    $data = "<option value='all'>- Select Guru -</option>";
    foreach ($query as $value) {
      $data .= "<option value='" . $value->id . "'>" . $value->name . "</option>";
    }
    // dd($query);
    return response()->json([
      'success' => false,
      'data' => $data
    ]);
  }

  function perhitunganpengajar(Request $request)
  {
    try {
      if ($request->id_jurusan != 'all') {


        $sql = '';
        if (isset($request->id_jurusan) && $request->id_jurusan != 'all') {
          $sql .= "and k.id_jurusan = '" . $request->id_jurusan . "'";
        }
        if (isset($request->id_guru) && $request->id_guru != 'all') {
          $sql .= "and k.id_guru = " . $request->id_guru . " ";
        }
        if (isset($request->id_kelas) && $request->id_kelas != 'all') {
          $sql .= "and k.id_kelas = " . $request->id_kelas . " ";
        }
        $haslProm = 0;
        $haslDekt = 0;
        //Pengajar
        $getjumlahdataPengajar = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id  and p.type = 'PENGAJAR'  $sql group by k.id_siswa");
        $getPromotor = DB::select("SELECT k.*, COUNT(IF( k.nilai >= 9, 'prom', null)) AS prom, COUNT(IF( k.nilai <= 6, 'dekt', null)) AS dekt, IF(COUNT(IF( k.nilai >= 9, 'prom', null)) > COUNT(IF( k.nilai <= 6, 'dekt', null)), 'prom', 'dkt') as initial  FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id  and p.type = 'PENGAJAR' $sql GROUP BY k.id_siswa");
        $getDektrator = DB::select("SELECT k.*, COUNT(IF( k.nilai >= 9, 'prom', null)) AS prom, COUNT(IF( k.nilai <= 6, 'dekt', null)) AS dekt, IF(COUNT(IF( k.nilai >= 9, 'prom', null)) > COUNT(IF( k.nilai <= 6, 'dekt', null)), 'prom', 'dkt') as initial  FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id  and p.type = 'PENGAJAR' $sql GROUP BY k.id_siswa");
        foreach ($getPromotor as $key => $a) {
          
          if ($a->initial == 'prom') {
            $haslProm += 1;
          }
         
        }
        foreach ($getDektrator as $key => $a) {
          if ($a->initial == 'dkt') {
            $haslDekt += 1;
          }
        }
        
        $fixPromotor = ($haslProm / count($getjumlahdataPengajar)) * 1;
        $fixDektrator = ($haslDekt / count($getjumlahdataPengajar)) * 1;
        $hasil = ($fixPromotor - $fixDektrator);
        return response()->json([
          'success' => true,
          'promotor' => $haslProm,
          'dektrator' => $haslDekt,
          'hasilPromotor' => $fixPromotor,
          'hasilDektrator' => $fixDektrator,
          'hasil' => $hasil,
          'jumlah' => count($getjumlahdataPengajar)
        ]);
      } else {
        return response()->json([
          'success' => false,
        ]);
      }
    } catch (\Throwable $th) {
      // dd($th);
      return response()->json([
        'success' => false,
      ]);
    }
  }
  function perhitunganLab(Request $request)
  {
    try {
      $getjumlahdataLab = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id  and p.type not in ('PENGAJAR', 'PERPUSTAKAAN') and k.id_guru = '0' and k.id_jurusan ='" . $request->id_jurusan . "' group by k.id_siswa");
      $getPromotorLab = DB::select("SELECT k.*, COUNT(IF( k.nilai >= 9, 'prom', null)) AS prom, COUNT(IF( k.nilai <= 6, 'dekt', null)) AS dekt, IF(COUNT(IF( k.nilai >= 9, 'prom', null)) > COUNT(IF( k.nilai <= 6, 'dekt', null)), 'prom', 'dkt') as initial  FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id  and p.type not in ('PENGAJAR', 'PERPUSTAKAAN') and k.id_guru = '0' and k.id_jurusan ='" . $request->id_jurusan . "' GROUP BY k.id_siswa");
      $getDektratorLab = DB::select("SELECT k.*, COUNT(IF( k.nilai >= 9, 'prom', null)) AS prom, COUNT(IF( k.nilai <= 6, 'dekt', null)) AS dekt, IF(COUNT(IF( k.nilai >= 9, 'prom', null)) > COUNT(IF( k.nilai <= 6, 'dekt', null)), 'prom', 'dkt') as initial  FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id  and p.type not in ('PENGAJAR', 'PERPUSTAKAAN') and k.id_guru = '0' and k.id_jurusan ='" . $request->id_jurusan . "' GROUP BY k.id_siswa");
      $haslProm = 0;
      $haslDekt = 0;
      foreach ($getPromotorLab as $key => $a) {
          
        if ($a->initial == 'prom') {
          $haslProm += 1;
        }
       
      }
      foreach ($getDektratorLab as $key => $a) {
        if ($a->initial == 'dkt') {
          $haslDekt += 1;
        }
      }
      
      
      $fixPromotorLab = ($haslProm / count($getjumlahdataLab)) * 1;
      $fixDektratorLab = ($haslDekt / count($getjumlahdataLab)) * 1;
      $hasil = ($fixPromotorLab - $fixDektratorLab);
      // dd(explode('.', $hasil)[0]);
      return response()->json([
        'success' => true,
        'promotor' => $haslProm,
        'dektrator' => $haslDekt,
        'hasilPromotor' => $fixPromotorLab,
        'hasilDektrator' => $fixDektratorLab,
        'hasil' => $hasil,
        'jumlah' => count($getjumlahdataLab)
      ]);
    } catch (\Throwable $th) {
      // dd($th);
      return response()->json([
        'success' => false,
      ]);
    }
  }
  function perhitunganperpus()
  {
    try {
      //code...

      $getjumlahdataPerpus = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id  and p.type = 'PERPUSTAKAAN' and k.id_guru = '0' group by k.id_siswa");
      $getPromotorPerpus = DB::select("SELECT k.*, COUNT(IF( k.nilai >= 9, 'prom', null)) AS prom, COUNT(IF( k.nilai <= 6, 'dekt', null)) AS dekt, IF(COUNT(IF( k.nilai >= 9, 'prom', null)) > COUNT(IF( k.nilai <= 6, 'dekt', null)), 'prom', 'dkt') as initial  FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id  and p.type = 'PERPUSTAKAAN' and k.id_guru = '0' GROUP BY k.id_siswa");
      $getDektratorPerpus = DB::select("SELECT k.*, COUNT(IF( k.nilai >= 9, 'prom', null)) AS prom, COUNT(IF( k.nilai <= 6, 'dekt', null)) AS dekt, IF(COUNT(IF( k.nilai >= 9, 'prom', null)) > COUNT(IF( k.nilai <= 6, 'dekt', null)), 'prom', 'dkt') as initial  FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id  and p.type = 'PERPUSTAKAAN' and k.id_guru = '0' GROUP BY k.id_siswa");
      
      $haslProm = 0;
      $haslDekt = 0;
      foreach ($getPromotorPerpus as $key => $a) {
          
        if ($a->initial == 'prom') {
          $haslProm += 1;
        }
       
      }
      foreach ($getDektratorPerpus as $key => $a) {
        if ($a->initial == 'dkt') {
          $haslDekt += 1;
        }
      }
      
      $fixPromotorPerpus = ($haslProm / count($getjumlahdataPerpus)) * 1;
      $fixDektratorPerpus = ($haslDekt / count($getjumlahdataPerpus)) * 1;
      $hasil = ($fixPromotorPerpus - $fixDektratorPerpus);
      return response()->json([
        'success' => true,
        'promotor' => $haslProm,
        'dektrator' => $haslDekt,
        'hasilPromotor' => $fixPromotorPerpus,
        'hasilDektrator' => $fixDektratorPerpus,
        'hasil' => $hasil,
        'jumlah' => count($getjumlahdataPerpus)
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'success' => true,
        'promotor' => count($getPromotorPerpus),
        'dektrator' => count($getDektratorPerpus),
        'hasilPromotor' => number_format($fixPromotorPerpus, 2),
        'hasilDektrator' => number_format($fixDektratorPerpus, 2),
        'hasil' => number_format($hasil, 2),
        'jumlah' => count($getjumlahdataPerpus)
      ]);
    }
  }
}
