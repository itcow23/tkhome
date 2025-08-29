<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $user;
    public function __construct() {
        $this->user = new User();
    }
    public function index(){
        $users =  $this->user->getAll();
        return view('admin.user.home',compact('users'))->with('i',(request()->input('page',1)-1)*10);
    }

    public function edit($id, Request  $request) {
        $user = $this->user->getUserById($id); 
        $role = $this->user->getRole(); 
        $request->session() -> put('id', $id); 
        session()->put('current-page-update-user', $request->input('last_page'));
        return view('admin.user.edit', compact('user', 'role')); 
    }

    public function update(Request $request) {
        $id = $request->session()->get('id');
        $currentPage = session()->get('current-page-update-user');
        session()->forget('current-page-update-user');
        $role_id = $request->role_id;

        $this->user->updateProduct($id, $role_id); // gọi phương thức updateProduct của đối tượng product để update dữ liệu vào bảng product
        return redirect()->route('admin.user.home', [
            'page' => $currentPage,
        ])->with( 'success', 'Cập nhật sản phẩm thành công');
    }

    public function delete($id) {
        $this->user->deleteProduct($id); // gọi phương thức deleteProduct của đối tượng product để xóa dữ liệu trong bảng product
        return redirect()->route('admin.user.home')->with( 'success', 'Xóa tài khoản thành công');
    }
    
    public function forgetPassword(){
        if(Auth::guard('client')->check()){
            return redirect()->route('client.home');
        }else{
            return view('client.forgetpass');
        }
    }

    public function processForgetPassword(Request $request){
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if ($user) {
            return redirect()->route('client.rePassword')->with('email',$email); // Chuyển hướng đến trang đặt lại mật khẩu
        }else{
            return redirect()->back()->with('error', 'Email không tồn tại');
        }
    }

    public function rePassword(){
        if(Auth::guard('client')->check()){
            return redirect()->route('client.home');
        }else{
            return view('client.repassword');
        }
    }

    public function processRePassword(Request $request){

        //validation
        $request->validate([
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password', // Kiểm tra mật khẩu và mật khẩu xác nhận giống nhau
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu',
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp',
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->password = bcrypt($password);
            $user->save();
            return redirect()->route('client.login')->with('success', 'Đặt lại mật khẩu thành công');
        }
        
    }

    public function changePassword(){
        if(Auth::guard('client')->check()){
            return view('client.change_password');
        }else{
            return view('client.login');
        }
    }

    public function processChangePassword(Request $request){
        //validation

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password', // Kiểm tra mật khẩu và mật khẩu xác nhận giống nhau
        ], [
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu',
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp',
        ]);

        if(Auth::guard('client')->check()){
            $email = Auth::guard('client')->user()->email;
            $old_password = $request->input('old_password');
            $password = $request->input('password');
            $user = User::where('email', $email)->first();
            if ($user) {
                if (Auth::guard('client')->attempt(['email' => $email, 'password' => $old_password])) {
                    $user->password = bcrypt($password);
                    $user->save();
                    return redirect()->route('client.home')->with('success', 'Đổi mật khẩu thành công');
                } else {
                    return redirect()->back()->with('error', 'Mật khẩu cũ không đúng');
                }
            }
        }
    }
    
    public function login(){
        if(Auth::guard('client')->check()){
            return redirect()->route('client.home');
        }else{
            return view('client.login');
        }
    }

    public function processLoginClient(Request $request){
        $data = [ 'email' => $request->email, 'password' => $request->password];
        $remember = $request->has('remember') ? true : false;


        if(Auth::guard('client')->attempt($data,$remember)){
            return redirect()->route('client.home');
        }else{
            return redirect()->back()->with('error','Tài khoản hoặc mật khẩu không đúng');
        }
        
    }

    public function register(){
        if(Auth::guard('client')->check()){
            return redirect()->route('client.home');
        }else{
            return view('client.register');
        }
    }

    public function processRegister(Request $request){
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email|unique:user',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ],
        [
            'fullname.required' => 'Bạn chưa nhập họ tên',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'confirm_password.required' => 'Bạn chưa nhập lại mật khẩu',
            'confirm_password.same' => 'Mật khẩu nhập lại không đúng',
        ]);
        
        $request->merge( ['password' => bcrypt($request->password)] );
        User::create( $request->all());

        return  redirect()->route('client.login')->with('success', 'Đăng ký thành công');
    }

    public function logout(){
        Auth::guard('client')->logout();
        return redirect()->route('client.login');
    }

    public function loginAdmin(){
        return view('admin.login');
    }

    public function processLoginAdmin(Request $request){
        $data = [ 'email' => $request->email, 'password' => $request->password];

        $role_id = DB::table( 'user' )
                    ->where('email',$request->email)
                    ->first();


        if($role_id){
            if($role_id->role_id == 2 && Auth::guard('admin')->attempt($data)){
                    return redirect()->route('admin.home');
                }
                 else if(!Auth::guard('admin')->attempt($data)){
                     return redirect()->back()->with('error', 'Email hoặc mật khẩu không đúng');
                }
                else{
                    return redirect()->back()->with('error', 'Bạn không có quyền đăng nhập vào trang này');
               
                }
            }else{
                return redirect()->back()->with('error', 'Email không tồn tại');
            }
    }

    public function logoutAdmin(){
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login');
    }
        
}
