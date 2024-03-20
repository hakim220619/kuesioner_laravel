@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')


    <br>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="row g-2">
                    <div class="col col-md-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select id="id_kelas" class="select2 form-select form-select-lg" data-allow-clear="true"
                                onclick="getValuekelas()" name="id_kelas">
                                <option value="all" selected>-- All --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach

                            </select>
                            <label for="select2Basic">Kelas</label>
                        </div>
                    </div>

                    <div class="col col-md-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select id="id_guru" class="select2 form-select form-select-lg" data-allow-clear="true"
                                name="id_guru" onchange="getValueguru()">
                                <option value="all" selected>-- All --</option>


                            </select>
                            <label for="select2Basic">Guru</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <label>PENGAJAR
                                    <br>
                                    <br>
                                    <h5>
                                        <b id="promotor"></b><br>---- X 100 &nbsp -<br>
                                        <b id="jumlah"></b>
                                    </h5>

                                    <br>
                                </label>
                                &nbsp
                                <label>
                                    <br>
                                    <br>
                                    <h5><b id="dektrator"></b><br>---- X 100 = <b id="hasilPromotor"></b> - <b
                                            id="hasilDektrator"></b> = <b id="hasil"></b><br>
                                        <b id="jumlahdek"></b>
                                    </h5>

                                    <br>
                                </label>
                            </div>

                        </div>

                    </div>
                    <div class="col col-md-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select id="id_jurusan" class="select2 form-select form-select-lg" data-allow-clear="true"
                                name="id_jurusan" onchange="getValuejurusan()">
                                <option value="all" selected>-- All --</option>
                                @foreach ($lab as $k)
                                    <option value="{{ $k->id_jurusan }}">
                                        {{ $k->nama_lab }}
                                    </option>
                                @endforeach

                            </select>
                            <label for="select2Basic">Lab</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <label>LABORATORIUM
                                    <br>
                                    <br>
                                    <h5><b id="promotorlab"></b><br>---- X 100 &nbsp -<br>
                                        <b id="jumlahlab"></b>
                                    </h5>

                                    <br>
                                </label>
                                &nbsp
                                <label>
                                    <br>
                                    <br>
                                    <h5><b id="dektratorlab"></b><br>---- X 100 = <b id="hasilPromotorlab"></b> - <b
                                            id="hasilDektratorlab"></b> = <b id="hasillab"></b><br>
                                        <b id="jumlahdeklab"></p>
                                    </h5>

                                    <br>
                                </label>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <label>PERPUSTAKAAN
                                    <br>
                                    <br>
                                    <h5><b id="promotorperpus"></b><br>---- X 100 &nbsp -<br>
                                        <b id="jumlahperpus"></b>
                                    </h5>

                                    <br>
                                </label>
                                &nbsp
                                <label>
                                    <br>
                                    <br>
                                    <h5><b id="dektratorperpus"></b><br>---- X 100 = <b id="hasilPromotorperpus"></b> -
                                        <b id="hasilDektratorperpus"></b> = <b id="hasilperpus"></b><br>
                                        <b id="jumlahdekperpus"></b>
                                    </h5>

                                    <br>
                                </label>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#id_kelas").change(function() {

                console.log($(this).val());
                $.ajax({
                    type: 'GET',
                    url: '{{ url('getGuru') }}/' + $(this).val(),
                    async: true,
                    dataType: 'json',
                    success: function(url) {
                        // console.log(url.data);
                        $('#id_guru').html(url.data);


                    }
                });
                // console.log(url);
            })
        });

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
                    console.log(data.success);
                    if (data.success == true) {
                        $('#promotor').text(data.promotor);
                        $('#jumlah').text(data.jumlah);
                        $('#jumlahdek').text(data.jumlah);
                        $('#dektrator').text(data.dektrator);
                        $('#hasilPromotor').text(data.hasilPromotor);
                        $('#hasilDektrator').text(data.hasilDektrator);
                        $('#hasil').text(data.hasil);
                    } else {
                        $('#promotor').text(0);
                        $('#jumlah').text(0);
                        $('#jumlahdek').text(0);
                        $('#dektrator').text(0);
                        $('#hasilPromotor').text(0);
                        $('#hasilDektrator').text(0);
                        $('#hasil').text(0);
                    }


                }
            });
        }

        function getValueguru() {
            const id_kelas = $('#id_kelas').val();
            const id_guru = $('#id_guru').val();
            console.log(id_kelas);
            console.log(id_guru);
            $.ajax({
                type: 'GET',
                url: '{{ route('home.perhitunganpengajar') }}',
                async: true,
                data: {
                    "_token": "{{ csrf_token() }}",
                    id_kelas: id_kelas,
                    id_guru: id_guru,
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data.success);
                    if (data.success == true) {
                        $('#promotor').text(data.promotor);
                        $('#jumlah').text(data.jumlah);
                        $('#jumlahdek').text(data.jumlah);
                        $('#dektrator').text(data.dektrator);
                        $('#hasilPromotor').text(data.hasilPromotor);
                        $('#hasilDektrator').text(data.hasilDektrator);
                        $('#hasil').text(data.hasil);
                    } else {
                        $('#promotor').text(0);
                        $('#jumlah').text(0);
                        $('#jumlahdek').text(0);
                        $('#dektrator').text(0);
                        $('#hasilPromotor').text(0);
                        $('#hasilDektrator').text(0);
                        $('#hasil').text(0);
                    }


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
                    console.log(data.success);
                    // console.log(data.dektrator.toString().substr(1, 2));
                    if (data.success == true) {


                        $('#promotorlab').text(data.promotor);
                        $('#jumlahlab').text(data.jumlah);
                        $('#jumlahdeklab').text(data.jumlah);
                        $('#dektratorlab').text(data.dektrator);
                        $('#hasilPromotorlab').text(data.hasilPromotor);
                        $('#hasilDektratorlab').text(data.hasilDektrator);
                        $('#hasillab').text(data.hasil);
                    } else {
                        $('#promotorlab').text(0);
                        $('#jumlahlab').text(0);
                        $('#jumlahdeklab').text(0);
                        $('#dektratorlab').text(0);
                        $('#hasilPromotorlab').text(0);
                        $('#hasilDektratorlab').text(0);
                        $('#hasillab').text(0);
                    }

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
