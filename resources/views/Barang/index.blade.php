    @extends('layouts.template')
    
    @section('content')
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Barang</h3>
                <div class="card-tools">
                <button onclick="modalAction('{{ url('/barang/import') }}')" class="btn btn-info">Import Barang</button>
                <a href="{{ url('/barang/create') }}" class="btn btn-primary">Tambah Data</a>
                <button onclick="modalAction('{{ url('/barang/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
                </div>
            </div>
            <div class="card-body">
                <!-- Filter data -->
                <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm row text-sm mb-0">
                                <label for="filter_date" class="col-md-1 col-form-label">Filter</label>
                                <div class="col-md-3">
                                    <select name="filter_katagori" class="form-control form-control-sm filter_katagori">
                                        <option value="">- Semua -</option>
                                        @foreach($katagori as $l)
                                            <option value="{{ $l->katagori_id }}">{{ $l->katagori_nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Katagori Barang</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @if(session('success'))

                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
    
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
    
                <table class="table table-bordered table-sm table-striped table-hover" id="table-barang">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Katagori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" 
        data-keyboard="false" data-width="75%"></div>
    @endsectio
    
    @push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
            $('#myModal').modal('show');

            });
        }
        var tableBarang;

$(document).ready(function() {
    tableBarang = $('#table-barang').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('barang/list') }}",
            dataType: "json",
            type: "POST",
            data: function (d) {
                d.filter_katagori = $('.filter_katagori').val(); // diganti dari filter_kategori
            }
        },
        columns: [
            {
                data: "DT_RowIndex",
                className: "text-center",
                width: "5%",
                orderable: false,
                searchable: false
            },
            {
                data: "barang_kode",
                className: "",
                width: "10%",
                orderable: true,
                searchable: true
            },
            {
                    data: "barang_nama",
                    className: "",
                    width: "37%",
                    orderable: true,
                    searchable: true
                },
            {
                    data: "harga_beli",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: false,
                    render: function(data, type, row) {
                    return new Intl.NumberFormat('id-ID').format(data);
                    }
                },
                {
                    data: "harga_jual",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: false,
                    render: function(data, type, row) {
                    return new Intl.NumberFormat('id-ID').format(data);
                    }
                },
                {
                    data: "katagori.katagori_nama",
                    className: "",
                    width: "14%",
                    orderable: true,
                    searchable: false
                },
                {
                    data: "aksi",
                    className: "text-center",
                    width: "14%",
                    orderable: false,
                    searchable: false
                }
            ]
        });
            $('#table-barang_filter input').unbind().bind().on('keyup', function(e) {
             if (e.keyCode == 13) { // Enter key
                tableBarang.search(this.value).draw();
            }
        });

            $('.filter_katagori').change(function() {
            tableBarang.draw();
        });
    });
</script>
@endpush
    