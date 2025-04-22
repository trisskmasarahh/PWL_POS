<?php 
namespace App\Http\Controllers;    
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserModel;
use Intervention\Image\Facades\Image;
    
        class ProfileController extends Controller
    {
        public function __construct()
        {
            $this->middleware('auth');
        }
    
        // Menampilkan halaman profil
        public function index()
        {
            $user = auth()->user();
            $activeMenu = 'profile';
            $breadcrumb = (object)[
                'title' => 'Profile',
                'list' => ['Home', 'Profile']
            ];
            return view('profile.index', compact('user', 'activeMenu', 'breadcrumb'));
        }
        // Mengubah foto profil
        public function updateFoto(Request $request)
        {
            $request->validate([
                'profile_photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            ]);
            $user = UserModel::find(auth()->user()->user_id);
            if (!$user) {
                return redirect()->route('login')->withErrors('Silakan login terlebih dahulu.');
            }
            try {
                // Hapus foto lama jika ada
                if ($user->profile_photo) {
                    $oldPhotoPath = 'public/profile-photos/' . $user->profile_photo;
                    if (Storage::exists($oldPhotoPath)) {
                        Storage::delete($oldPhotoPath);
                    }
                }
    
                // Upload foto baru
                $file = $request->file('profile_photo');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/profile-photos', $fileName);
    
                // Simpan nama file ke database
                $user->update([
                    'profile_photo' => $fileName
                ]);
    
                return back()->with('success', 'Foto profil berhasil diperbarui.');
            } catch (\Exception $e) {
                return back()->with('error', 'Terjadi kesalahan saat mengubah foto: ' . $e->getMessage());
            }
        }
    }