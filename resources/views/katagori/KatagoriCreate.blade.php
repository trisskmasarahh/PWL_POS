@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Katagori</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('katagori') }}" class="form-horizontal">
                @csrf

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kode Katagori</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="katagori_kode" name="katagori_kode"
                            value="{{ old('katagori_kode') }}" required>
                        @error('katagori_kode')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama Katagori</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="katagori_nama" name="katagori_nama"
                            value="{{ old('katagori_nama') }}" required>
                        @error('katagori_nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-default ml-1" href="{{ url('katagori') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
