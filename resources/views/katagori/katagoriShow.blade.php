@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Katagri</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('katagri') }}" class="form-horizontal">
                @csrf

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kode Katagri</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="katagri_kode" name="katagri_kode"
                            value="{{ old('katagri_kode') }}" required>
                        @error('katagri_kode')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama Katagri</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="katagri_nama" name="katagri_nama"
                            value="{{ old('katagri_nama') }}" required>
                        @error('katagri_nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-default ml-1" href="{{ url('katagri') }}">Kembali</a>
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
