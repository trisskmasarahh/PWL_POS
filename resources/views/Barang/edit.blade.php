    @extends('layouts.template')
    
    @section('content')
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ $page->title }}</h3>
                <div class="card-tools"></div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('/barang/' . $barang->barang_id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="katagori_id">Kategori</label>
                        <select class="form-control" id="katagori_id" name="katagori_id" required>
                            @foreach ($katagoris as $katagori)
                                <option value="{{ $katagori->katagori_id }}" {{ $katagori->katagori_id == $barang->katagori_id ? 'selected' : '' }}>{{ $katagori->katagori_nama }}</option>
                            @endforeach
                        </select>
                        @error('katagori_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="barang_kode">Kode Barang</label>
                        <input type="text" class="form-control" id="barang_kode" name="barang_kode" value="{{ $barang->barang_kode }}" required>
                        @error('barang_kode')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="barang_nama">Nama Barang</label>
                        <input type="text" class="form-control" id="barang_nama" name="barang_nama" value="{{ $barang->barang_nama }}" required>
                        @error('barang_nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="number" class="form-control" id="harga_beli" name="harga_beli" value="{{ $barang->harga_beli }}" required>
                        @error('harga_beli')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="{{ $barang->harga_jual }}" required>
                        @error('harga_jual')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('barang') }}" class="btn btn-default">Batal</a>
                </form>
            </div>
        </div>
    @endsection