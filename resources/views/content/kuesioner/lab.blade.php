@extends('layouts/layoutMaster')

@section('title', 'Tables - Basic Tables')
@include('sweetalert::alert')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Kuesioner /</span> Form</h4>

    <!-- Basic Bootstrap Table -->


    <!-- Responsive Table -->

    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-header">Laboratorium</h5>

                <div class="card">


                    {{-- <h5 class="card-header">Kuesioner <b style="color: black">PERPUSTAKAAN</b> --}}
                    </h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr class="text-nowrap">

                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>0</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                    <th>6</th>
                                    <th>7</th>
                                    <th>8</th>
                                    <th>9</th>
                                    <th>10</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($laboratorium as $a)
                                    <input type="hidden" value="{{ $a->id }}" id="id_pertanyaan{{ $a->id }}"
                                        name="id_pertanyaan{{ $a->id }}">

                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{!! $a->nama_pertanyaan !!}</td>
                                        <td>
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input" type="radio" name="{{ $a->id }}"
                                                    id="inlineRadio0{{ $a->id }}"
                                                    onclick="return getValue(this.value, this.name)" value="0"
                                                    style="accent-color: #e74c3c;" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input" type="radio" name="{{ $a->id }}"
                                                    id="inlineRadio1{{ $a->id }}"
                                                    onclick="return getValue(this.value, this.name)" value="1"
                                                    style="accent-color: #e74c3c;" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input" type="radio" name="{{ $a->id }}"
                                                    id="inlineRadio2{{ $a->id }}"
                                                    onclick="return getValue(this.value, this.name)" value="2" />

                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input" type="radio" name="{{ $a->id }}"
                                                    id="inlineRadio3{{ $a->id }}"
                                                    onclick="return getValue(this.value, this.name)" value="3" />

                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input" type="radio" name="{{ $a->id }}"
                                                    id="inlineRadio4{{ $a->id }}"
                                                    onclick="return getValue(this.value, this.name)" value="4" />

                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input" type="radio" name="{{ $a->id }}"
                                                    id="inlineRadio5{{ $a->id }}"
                                                    onclick="return getValue(this.value, this.name)" value="5" />

                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input" type="radio" name="{{ $a->id }}"
                                                    id="inlineRadio6{{ $a->id }}"
                                                    onclick="return getValue(this.value, this.name)" value="6" />

                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input" type="radio" name="{{ $a->id }}"
                                                    id="inlineRadio7{{ $a->id }}"
                                                    onclick="return getValue(this.value, this.name)" value="7" />

                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input" type="radio" name="{{ $a->id }}"
                                                    id="inlineRadio8{{ $a->id }}"
                                                    onclick="return getValue(this.value, this.name)" value="8" />

                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input" type="radio" name="{{ $a->id }}"
                                                    id="inlineRadio9{{ $a->id }}"
                                                    onclick="return getValue(this.value, this.name)" value="9" />
        
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input" type="radio" name="{{ $a->id }}"
                                                    id="inlineRadio10{{ $a->id }}"
                                                    onclick="return getValue(this.value, this.name)" value="10" />
        
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



                </div>


                <div class="card-body">
                    <div class="demo-inline-spacing">
                        <button onclick="sendtolistlab()" class="btn btn-primary">Save</button>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>
        function sendtolistlab() {
            alert('success');
            window.location.href = '/list-lab'
        }

        function getValue(params1, params2) {
            const id_guru = $('#id_guru').val();
            const id_kelas = $('#id_kelas').val();
            const nilai = params1;
            const id_pertanyaan = params2
            console.log(params2);
            $.ajax({
                type: 'POST',
                url: '{{ route('kuesioner.add') }}',
                async: true,
                data: {
                    "_token": "{{ csrf_token() }}",
                    id_guru: id_guru,
                    id_kelas: id_kelas,
                    nilai: nilai,
                    id_pertanyaan: id_pertanyaan
                },
                dataType: 'json',
                success: function(data) {
                    console.log('suc');
                    // $('#datatable').DataTable();
                    // swal.fire("Done!", "Success", "success");

                    //SweetAlert2 Toast
                    // alert('success')



                }
            });

        }
    </script>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script>
        $(document).ready(function() {
            getchecked()

            function getchecked() {



                $.ajax({
                    type: 'POST',
                    url: '{{ route('load_data.kuesioner') }}',
                    async: true,
                    data: {
                        "_token": "{{ csrf_token() }}",


                    },
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        var i;
                        var no = 1;
                        for (i = 0; i < data.length; i++) {
                            console.log(data[i].id_pertanyaan);
                            document.getElementById('inlineRadio' + data[i].nilai + '' + data[i]
                                .id_pertanyaan + '').setAttribute("checked", "checked")
                        }
                        // $('#datatable').DataTable();
                        swal.fire("Done!", "Success", "success");

                    }
                });
            }
        })
    </script>
    <!--/ Responsive Table -->
@endsection
