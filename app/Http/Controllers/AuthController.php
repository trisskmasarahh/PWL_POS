<?php  
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModel;
use App\Models\LevelModel;
class AuthController extends Controller
    {
            public function login()
            {
                if (Auth::check()) { // jika sudah login, maka redirect ke halaman home             
                    return redirect('/');
                }
                    return view('auth.login');
            }
                public function postlogin(Request $request)
            {
                if($request->ajax() || $request->wantsJson()){ 
                $credentials = $request->only('username', 'password'); 
                if (Auth::attempt($credentials)) {                 
                    return response()->json([ 
                        'status' => true, 
                        'message' => 'Login Berhasil', 
                        'redirect' => url('/') 
                    ]); 
                }              
                    return response()->json([ 
                    'status' => false, 
                    'message' => 'Login Gagal' 
                ]); 
            } 
    
            return redirect('login'); 
    
        // }  
        // public function logout(Request $request) 
        // { 
        //     Auth::logout(); 
    
        //     $request->session()->invalidate(); 
        //     $request->session()->regenerateToken();             
        //     return redirect('login'); 
        // } 
    }
        public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
    public function register()
    {
        if (Auth::check()) return redirect('/');
            $levels = LevelModel::all();
            return view('auth.register', compact('levels'));
        }
    
        public function postRegister(Request $request)
        {
            $validated = $request->validate([
                'nama' => 'required|string|max:100',
                'username' => 'required|string|max:100|unique:m_user,username',
                'password' => 'required|string|min:3',
                'level_id' => 'required|exists:m_level,level_id'
            ]);
    
                UserModel::create([
                    'nama' => $validated['nama'],
                    'username' => $validated['username'],
                    'password' => Hash::make($validated['password']),
                    'level_id' => $validated['level_id'],
            ]);
    
            return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
        }
    
}
