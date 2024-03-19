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
  function perhitunganpengajar(Request $request)
  {
    try {
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
      //Pengajar
      $getjumlahdataPengajar = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id  and p.type = 'PENGAJAR'  $sql");
      $getPromotor = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id and k.nilai >= '7' and p.type = 'PENGAJAR'  $sql");
      $getDektrator = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id and k.nilai < '7' and p.type = 'PENGAJAR'  $sql");

      $fixPromotor = (count($getPromotor) / count($getjumlahdataPengajar)) * 100;
      $fixDektrator = (count($getDektrator) / count($getjumlahdataPengajar)) * 100;
      $hasil = ($fixPromotor - $fixDektrator);
      return response()->json([
        'success' => true,
        'promotor' => count($getPromotor),
        'dektrator' => count($getDektrator),
        'hasilPromotor' => number_format($fixPromotor, 2),
        'hasilDektrator' => number_format($fixDektrator, 2),
        'hasil' => number_format($hasil, 2),
        'jumlah' => count($getjumlahdataPengajar)
      ]);
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
      $getjumlahdataLab = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id  and p.type not in ('PENGAJAR', 'PERPUSTAKAAN') and k.id_guru = '0' and k.id_jurusan ='" . $request->id_jurusan . "'");
      $getPromotorLab = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id and k.nilai >= '7' and p.type not in ('PENGAJAR', 'PERPUSTAKAAN') and k.id_guru = '0' and k.id_jurusan ='" . $request->id_jurusan . "'");
      $getDektratorLab = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id and k.nilai < '7' and p.type not in ('PENGAJAR', 'PERPUSTAKAAN') and k.id_guru = '0' and k.id_jurusan ='" . $request->id_jurusan . "'");
      $fixPromotorLab = (count($getPromotorLab) / count($getjumlahdataLab)) * 100;
      $fixDektratorLab = (count($getDektratorLab) / count($getjumlahdataLab)) * 100;
      $hasil = ($fixPromotorLab - $fixDektratorLab);
      // dd(explode('.', $hasil)[0]);
      return response()->json([
        'success' => true,
        'promotor' => count($getPromotorLab),
        'dektrator' => count($getDektratorLab),
        'hasilPromotor' => number_format($fixPromotorLab, 2),
        'hasilDektrator' => number_format($fixDektratorLab, 2),
        'hasil' => number_format($hasil, 2),
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

      $getjumlahdataPerpus = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id  and p.type = 'PERPUSTAKAAN' and k.id_guru = '0'");
      $getPromotorPerpus = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id and k.nilai >= '7' and p.type = 'PERPUSTAKAAN' and k.id_guru = '0'");
      $getDektratorPerpus = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id and k.nilai < '7' and p.type = 'PERPUSTAKAAN' and k.id_guru = '0'");
      $fixPromotorPerpus = (count($getPromotorPerpus) / count($getjumlahdataPerpus)) * 100;
      $fixDektratorPerpus = (count($getDektratorPerpus) / count($getjumlahdataPerpus)) * 100;
      $hasil = ($fixPromotorPerpus - $fixDektratorPerpus);
      return response()->json([
        'success' => true,
        'promotor' => count($getPromotorPerpus),
        'dektrator' => count($getDektratorPerpus),
        'hasilPromotor' => number_format($fixPromotorPerpus, 2),
        'hasilDektrator' => number_format($fixDektratorPerpus, 2),
        'hasil' => number_format($hasil, 2),
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
