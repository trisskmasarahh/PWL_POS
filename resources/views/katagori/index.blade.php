@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/katagori/import') }}')" class="btn btn-info">Import Katagori</button>
                <a href="{{ url('/katagori/export_excel') }}" class="btn btn-primary">Export Katagori</a>
                <button onclick="modalAction('{{ url('/katagori/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_katagori">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Katagori</th>
                        <th>Nama Katagori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var datakatagori
        $(document).ready(function() {
            var dataKatagori = $('#table_katagori').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('katagori/list') }}",
                    // "dataType": "json",
                    "type": "GET"
                },
                columns: [{
                        data: "DT_RowIndex",
                            className: "text-center",
                            orderable: false,
                            searchable: false
                        // data: "katagori_id",
                        // className: "text-center",
                        // orderable: true,
                        // searchable: true
                    },
                    {
                        data: "katagori_kode",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "katagori_nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
