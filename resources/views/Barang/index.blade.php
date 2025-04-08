    @extends('layouts.template')
    
    @section('content')
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ $page->title }}</h3>
                <div class="card-tools">
                    <a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create') }}">Tambah</a>
                    <button onclick="modalAction('{{ url('barang/create_ajax')}}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
    
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
    
                <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true">
    </div>
    @endsection
    
    @push('css')
    @endpush
    
    @push('js')
    <script>
        function modalAction(url = ''){
            $('#myModal').load(url,function(){
            $('#myModal').modal('show');
            });
        }
        var dataBarang;
        $(document).ready(function() {
            var dataBarang = $('#table_barang').DataTable({
                serverSide: true, // Mengaktifkan server-side processing
                ajax: {
                    url: "{{ url('barang/list') }}",
                    type: "GET",
                },
                columns: [
                    // { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    // { data: "barang_kode", className: "", orderable: true, searchable: true },
                    // { data: "barang_nama", className: "", orderable: true, searchable: true },
                    // { data: "katagori_nama", className: "", orderable: true, searchable: true }, // Perbaikan di sini
                    // { data: "harga_beli", className: "", orderable: true, searchable: true },
                    // { data: "harga_jual", className: "", orderable: true, searchable: true },
                    // { data: "aksi", className: "", orderable: false, searchable: false }
                    { 
                            data: "DT_RowIndex", 
                            className: "text-center", 
                            orderable: false, 
                            searchable: false 
                        },
                        { 
                            data: "barang_kode", 
                            className: "", 
                            orderable: true, 
                            searchable: true 
                        },
                        { 
                            data: "barang_nama", 
                            className: "", 
                            orderable: true, 
                            searchable: true 
                        },
                        { 
                            data: "katagori.katagori_nama", 
                            className: "", 
                            orderable: true, 
                            searchable: true 
                        },
                        { 
                            data: "harga_beli", 
                            className: "", 
                            orderable: true, 
                            searchable: true 
                        },
                        { 
                            data: "harga_jual", 
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