@extends('layouts/layoutMaster')

@section('title', 'Tables - Basic Tables')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">List /</span> Kuesioner Pengajar</h4>

    <!-- Basic Bootstrap Table -->
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-header">Pengajar</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Kelas</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($guru as $a)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $a->name }}</td>
                                    <td>{{ $a->nama_kelas }}</td>

                                    <td>

                                        <a class="dropdown-item" href="/kuesioner/{{ $a->id }}"><i
                                                class="mdi mdi-pencil-outline btn btn-primary me-1">Kuesioner</i>
                                        </a>


                                    </td>
                                    {{-- <td><i class="mdi mdi-wallet-travel mdi-20px text-danger me-3"></i><span class="fw-medium">Tours
                                    Project</span></td>
                            <td>Albert Cook</td>
                            <td>
                                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                        <img src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar"
                                            class="rounded-circle">
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                                        <img src="{{ asset('assets/img/avatars/6.png') }}" alt="Avatar"
                                            class="rounded-circle">
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Christina Parker">
                                        <img src="{{ asset('assets/img/avatars/7.png') }}" alt="Avatar"
                                            class="rounded-circle">
                                    </li>
                                </ul>
                            </td>
                            <td><span class="badge rounded-pill bg-label-primary me-1">Active</span></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="mdi mdi-pencil-outline me-1"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="mdi mdi-trash-can-outline me-1"></i> Delete</a>
                                    </div>
                                </div>
                            </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    
   


    <script>
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
                    console.log(data);
                    // $('#datatable').DataTable();


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
                    type: 'GET',
                    url: '{{ route('load_data.keusionerall') }}',
                    async: true,

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
                        // alert('success')

                    }
                });
            }
        })
    </script>
@endsection
