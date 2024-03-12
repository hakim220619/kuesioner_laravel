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
    $data['jurusan'] = DB::table('jurusan')->get();
    return view('content.pages.pages-home', $data);
  }
  function perhitunganpengajar(Request $request)
  {
    $sql = '';
    if (isset($request->id_jurusan) && $request->id_jurusan != 'all') {
      $sql .= " and k.id_jurusan = '" . $request->id_jurusan . "'";
    }
    //Pengajar
    $getjumlahdataPengajar = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id  and p.type = 'PENGAJAR' and k.id_guru != '0' and k.id_kelas ='" . $request->id_kelas . "' $sql");
    $getPromotor = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id and k.nilai >= '7' and p.type = 'PENGAJAR' and k.id_guru != '0' and k.id_kelas ='" . $request->id_kelas . "' $sql");
    $getDektrator = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id and k.nilai < '7' and p.type = 'PENGAJAR' and k.id_guru != '0' and k.id_kelas ='" . $request->id_kelas . "' $sql");
    $fixPromotor = (count($getPromotor) / count($getjumlahdataPengajar)) * 100;
    $fixDektrator = (count($getDektrator) / count($getjumlahdataPengajar)) * 100;
    $hasil = ($fixPromotor - $fixDektrator);


    return response()->json([
      'success' => true,
      'promotor' => count($getPromotor),
      'dektrator' => count($getDektrator),
      'hasilPromotor' => $fixPromotor,
      'hasilDektrator' => $fixDektrator,
      'hasil' => $hasil,
      'jumlah' => count($getjumlahdataPengajar)
    ]);
  }
  function perhitunganLab(Request $request)
  {

    //Lab

    $getjumlahdataLab = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id  and p.type not in ('PENGAJAR', 'PERPUSTAKAAN') and k.id_guru = '0' and k.id_jurusan ='" . $request->id_jurusan . "'");
    $getPromotorLab = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id and k.nilai >= '7' and p.type not in ('PENGAJAR', 'PERPUSTAKAAN') and k.id_guru = '0' and k.id_jurusan ='" . $request->id_jurusan . "'");
    $getDektratorLab = DB::select("SELECT k.* FROM kuesioner k, pertanyaan p WHERE k.id_pertanyaan=p.id and k.nilai < '7' and p.type not in ('PENGAJAR', 'PERPUSTAKAAN') and k.id_guru = '0' and k.id_jurusan ='" . $request->id_jurusan . "'");
    $fixPromotorLab = (count($getPromotorLab) / count($getjumlahdataLab)) * 100;
    $fixDektratorLab = (count($getDektratorLab) / count($getjumlahdataLab)) * 100;
    $hasil = ($fixPromotorLab - $fixDektratorLab);
    return response()->json([
      'success' => true,
      'promotor' => count($getPromotorLab),
      'dektrator' => count($getDektratorLab),
      'hasilPromotor' => $fixPromotorLab,
      'hasilDektrator' => $fixDektratorLab,
      'hasil' => $hasil,
      'jumlah' => count($getjumlahdataLab)
    ]);
  }
  function perhitunganperpus()
  {

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
      'hasilPromotor' => $fixPromotorPerpus,
      'hasilDektrator' => $fixDektratorPerpus,
      'hasil' => $hasil,
      'jumlah' => count($getjumlahdataPerpus)
    ]);
  }
}
