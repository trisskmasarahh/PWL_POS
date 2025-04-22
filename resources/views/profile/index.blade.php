@extends('layouts.app')
 
 @section('content')
 <div class="container">
    <div class="row justify-content-center">
         <div class="col-md-8">
             <div class="card">
                 <div class="card-header">Profil Saya</div>
 
                 <div class="card-body">
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
 
                     <div class="text-center mb-4">
                         @if($user->profile_photo)
                             <img src="{{ asset('storage/profile-photos/'.$user->profile_photo) }}" 
                                  class="rounded-circle" width="150" height="150">
                         @else
                             <img src="{{ asset('images/default-profile.png') }}" 
                                  class="rounded-circle" width="150" height="150">
                         @endif
                     </div>
 
                     <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data">
                         @csrf
                         <div class="form-group">
                             <label for="profile_photo">Ubah Foto Profil</label>
                             <input type="file" class="form-control-file" id="profile_photo" name="profile_photo" required>
                         </div>
                         <button type="submit" class="btn btn-primary">Upload</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>
 @endsection