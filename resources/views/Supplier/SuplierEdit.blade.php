@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @if (empty($suplier))
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data suplier yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('suplier') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('suplier/' . $suplier->suplier_id) }}" class="form-horizontal">
                    @method('PUT')
                    @csrf

                    {{-- Nama Suplier --}}
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Nama Suplier</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="nama_suplier" name="nama_suplier"
                                value="{{ old('nama_suplier', $suplier->nama_suplier) }}" required>
                            @error('nama_suplier')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Kontak --}}
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Kontak</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="kontak" name="kontak"
                                value="{{ old('kontak', $suplier->kontak) }}" required>
                            @error('kontak')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Alamat</label>
                        <div class="col-10">
                            <textarea class="form-control" id="alamat" name="alamat" required>{{ old('alamat', $suplier->alamat) }}</textarea>
                            @error('alamat')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="col-10">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('suplier') }}">Kembali</a>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush