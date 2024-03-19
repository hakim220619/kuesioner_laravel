@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
    @if (request()->user()->role == 1)
        <div class="col-12">
            <div class="card">
                <!-- Pricing Plans -->
                <div class="pb-sm-5 pb-2 rounded-top">
                    <div class="container py-5">

                        <h2 class="text-center mb-2 mt-0 mt-md-4"><img src="{{ asset('') }}storage/logo.png" alt="asd"
                                style="width: 20px; height: 200px; width: 200px;"></h2>
                        <h2 class="text-center mb-2 mt-0 mt-md-4">SMKN 1 BENGKALIS</h2>


                        <div class="pricing-plans row mx-0 gy-3 px-lg-5">
                            <!-- Basic -->


                            <!-- Standard -->


                            <!-- Enterprise -->

                        </div>
                    </div>
                </div>
                <!--/ Pricing Plans -->
            </div>
        </div>
    @else
        <div class="col-12">
            <div class="card">
                <!-- Pricing Plans -->
                <div class="pb-sm-5 pb-2 rounded-top">
                    <div class="container py-5">

                        <h2 class="text-center mb-2 mt-0 mt-md-4"><img src="{{ asset('') }}storage/logo.png"
                                alt="asd" style="width: 20px; height: 200px; width: 200px;"></h2>
                        <h2 class="text-center mb-2 mt-0 mt-md-4">SMKN 1 BENGKALIS</h2>


                        <div class="pricing-plans row mx-0 gy-3 px-lg-5">
                            <!-- Basic -->


                            <!-- Standard -->
                            <div class="col-lg mb-md-0 mb-4">
                                <div class="card border-primary border shadow-none">
                                    <div class="card-body position-relative">
                                        <div class="position-absolute end-0 me-4 top-0 mt-4">
                                            <span class="badge bg-label-primary rounded-pill">Popular</span>
                                        </div>
                                        <div class="my-3 pt-2 text-center">
                                            <i class="mdi mdi-account-badge mdi-48px"></i>
                                        </div>
                                        <h3 class="card-title text-center text-capitalize mb-1">Pengajar</h3>
                                        {{-- <p class="text-center">For small to medium businesses</p> --}}

                                        <br>
                                        <a href="{{ url('/list-kuesioner') }}"
                                            class="btn btn-primary d-grid w-100">Kuesioner</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg mb-md-0 mb-4">
                                <div class="card border-primary border shadow-none">
                                    <div class="card-body position-relative">
                                        <div class="position-absolute end-0 me-4 top-0 mt-4">
                                            <span class="badge bg-label-primary rounded-pill">Popular</span>
                                        </div>
                                        <div class="my-3 pt-2 text-center">
                                            <i class="mdi mdi-chandelier mdi-48px"></i>
                                        </div>
                                        <h3 class="card-title text-center text-capitalize mb-1">Laboratorium</h3>
                                        {{-- <p class="text-center">For small to medium businesses</p> --}}

                                        <br>
                                        <a href="{{ url('list-lab') }}" class="btn btn-primary d-grid w-100">Kuesioner</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg mb-md-0 mb-4">
                                <div class="card border-primary border shadow-none">
                                    <div class="card-body position-relative">
                                        <div class="position-absolute end-0 me-4 top-0 mt-4">
                                            <span class="badge bg-label-primary rounded-pill">Popular</span>
                                        </div>
                                        <div class="my-3 pt-2 text-center">
                                            <i class="mdi mdi-home-edit mdi-48px"></i>
                                        </div>
                                        <h3 class="card-title text-center text-capitalize mb-1">Perpustakaan</h3>
                                        {{-- <p class="text-center">For small to medium businesses</p> --}}

                                        <br>
                                        <a href="{{ url('perpustakaan') }}"
                                            class="btn btn-primary d-grid w-100">Kuesioner</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Enterprise -->

                        </div>
                    </div>
                </div>
                <!--/ Pricing Plans -->
            </div>
        </div>
    @endif
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        function getValuekelas() {
            const id_kelas = $('#id_kelas').val();
            const id_jurusan = $('#id_jurusan').val();
            $.ajax({
                type: 'GET',
                url: '{{ route('home.perhitunganpengajar') }}',
                async: true,
                data: {
                    "_token": "{{ csrf_token() }}",
                    id_kelas: id_kelas,
                    id_jurusan: id_jurusan,
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $('#promotor').text(data.promotor);
                    $('#jumlah').text(data.jumlah);
                    $('#jumlahdek').text(data.jumlah);
                    $('#dektrator').text(data.dektrator);
                    $('#hasilPromotor').text(data.hasilPromotor);
                    $('#hasilDektrator').text(data.hasilDektrator);
                    $('#hasil').text(data.hasil);


                }
            });

        }

        function getValuejurusan() {

            const id_jurusan = $('#id_jurusan').val();
            $.ajax({
                type: 'GET',
                url: '{{ route('home.perhitunganLab') }}',
                async: true,
                data: {
                    "_token": "{{ csrf_token() }}",
                    id_jurusan: id_jurusan,
                },
                dataType: 'json',
                success: function(data) {
                    // console.log(data.dektrator.toString().substr(1, 2));
                    $('#promotorlab').text(data.promotor);
                    $('#jumlahlab').text(data.jumlah);
                    $('#jumlahdeklab').text(data.jumlah);
                    $('#dektratorlab').text(data.dektrator);
                    $('#hasilPromotorlab').text(data.hasilPromotor);
                    $('#hasilDektratorlab').text(data.hasilDektrator);
                    $('#hasillab').text(data.hasil);


                }
            });
        }
        $(document).ready(function() {
            perhitunganperpus();

            function perhitunganperpus() {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('home.perhitunganperpus') }}',
                    async: true,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#promotorperpus').text(data.promotor);
                        $('#jumlahperpus').text(data.jumlah);
                        $('#jumlahdekperpus').text(data.jumlah);
                        $('#dektratorperpus').text(data.dektrator);
                        $('#hasilPromotorperpus').text(data.hasilPromotor);
                        $('#hasilDektratorperpus').text(data.hasilDektrator);
                        $('#hasilperpus').text(data.hasil);


                    }
                });
            }
        });
    </script>

@endsection
