@extends('layouts/layoutMaster')

@section('title', 'Tables - Basic Tables')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">List /</span> Pertanyaan</h4>

    <!-- Basic Bootstrap Table -->
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header"><button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#addModalPertanyaan">
                    Add
                </button></div>
            <div class="card-body">
                {{-- <h5 class="card-header">Table Basic</h5> --}}
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pertanyaan</th>
                                <th>Status</th>
                                <th>type</th>
                                <th>Create</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($pertanyaan as $a)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $a->nama_pertanyaan }}</td>
                                    <td>{{ $a->status }}</td>
                                    <td>{{ $a->type }}</td>
                                    <td>{{ $a->created_at }}</td>

                                    {{-- <td>

                                <a class="dropdown-item" href="/kuesioner/{{ $a->id }}"><i
                                        class="mdi mdi-pencil-outline btn btn-primary me-1">Kuesioner</i>
                                </a>


                            </td> --}}
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
                            <td><span class="badge rounded-pill bg-label-primary me-1">Active</span></td> --}}
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#EditPertanyaan{{ $a->id }}"><i
                                                        class="mdi mdi-pencil-outline me-1"></i>
                                                    Edit</button>
                                                <a class="dropdown-item" href="/pertanyaan/{{ $a->id }}"><i
                                                        class="mdi mdi-trash-can-outline me-1"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>


                                <!-- Modal -->
                                <div class="modal fade" id="EditPertanyaan{{ $a->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="modalCenterTitle">Edit Pertanyaan</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form id="formAuthentication" class="mb-3" method="POST"
                                                action="{{ route('pertanyaan.edit') }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <input type="hidden" name="id" value="{{ $a->id }}">
                                                        <div class="col mb-4 mt-2">
                                                            <div class="form-floating form-floating-outline">
                                                                <textarea class="form-control" id="contentEdit" placeholder="Enter the Description" rows="10" cols="30"
                                                                    name="nama_pertanyaan">{{ $a->nama_pertanyaan }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-2">
                                                        <div class="col mb-4">
                                                            <div class="form-floating form-floating-outline">
                                                                <select id="select2Basic"
                                                                    class="select2 form-select form-select-lg"
                                                                    data-allow-clear="true" name="type">
                                                                    <option value="" selected>-- Pilih --</option>
                                                                    @foreach ($type as $k)
                                                                        <option value="{{ $k }}"
                                                                            {{ $k == $a->type ? 'selected' : '' }}>
                                                                            {{ $k }}
                                                                        </option>
                                                                    @endforeach
                                                                    @foreach ($lab as $k)
                                                                        <option value="{{ $k->nama_lab }}"
                                                                            {{ $k->nama_lab == $a->type ? 'selected' : '' }}>
                                                                            {{ $k->nama_lab }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                                <label for="select2Basic">Type</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-2">
                                                        <div class="col mb-4">
                                                            <div class="form-floating form-floating-outline">
                                                                <select id="select2Basic"
                                                                    class="select2 form-select form-select-lg"
                                                                    data-allow-clear="true" name="status">
                                                                    <option value="" selected>-- Pilih --</option>
                                                                    @foreach ($status as $k)
                                                                        <option value="{{ $k }}"
                                                                            {{ $k == $a->status ? 'selected' : '' }}>
                                                                            {{ $k }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                                <label for="select2Basic">Status</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="addModalPertanyaan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalPertanyaanTitle">Add Pertanyaan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('pertanyaan.add') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <div class="col mb-4 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <textarea class="form-control" id="content" placeholder="Enter the Description" rows="10" cols="30"
                                        name="nama_pertanyaan"></textarea>

                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-4">
                                <div class="form-floating form-floating-outline">
                                    <select id="select2Basic" class="select2 form-select form-select-lg"
                                        data-allow-clear="true" name="type">
                                        <option value="" selected>-- Pilih --</option>
                                        @foreach ($type as $k)
                                            <option value="{{ $k }}">
                                                {{ $k }}
                                            </option>
                                        @endforeach
                                        @foreach ($lab as $k)
                                            <option value="{{ $k->nama_lab }}">
                                                {{ $k->nama_lab }}
                                            </option>
                                        @endforeach

                                    </select>
                                    <label for="select2Basic">Type</label>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor.create(document.querySelector('#contentEdit'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
