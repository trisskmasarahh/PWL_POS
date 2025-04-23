@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profil Saya</div>

                <div class="card-body">
                    {{-- Alert Sukses / Error --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Preview Foto Profil --}}
                    <div class="text-center mb-4">
                        <img id="preview-image" 
                            src="{{ $user->profile_photo ? asset('storage/profile-photos/'.$user->profile_photo) : asset('images/default-profile.png') }}" 
                            class="rounded-circle" width="150" height="150" alt="Foto Profil">
                    </div>

                    {{-- Form Update Foto Profil --}}
                    <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data" id="formFoto">
                        @csrf
                        <div class="form-group">
                            <label for="profile_photo">Ubah Foto Profil</label>
                            <input type="file" class="form-control-file" id="profile_photo" name="profile_photo" accept="image/*" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3 d-none" id="btnUpdateFoto">Update Foto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('profile_photo').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview-image');
    const button = document.getElementById('btnUpdateFoto');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
        button.classList.remove('d-none');
    } else {
        button.classList.add('d-none');
    }
});

document.getElementById('formFoto').addEventListener('submit', function(event) {
    const confirmUpload = confirm("Yakin ingin mengupdate foto profil?");
    if (!confirmUpload) {
        event.preventDefault();
    }
});
</script>
@endpush
