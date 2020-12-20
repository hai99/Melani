<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\Color;
	use App\User;
	use App\Models\Sizes;
	use App\Models\Stocks;
	use App\Http\Controllers\Controller;
    use Spatie\Permission\Models\Permission;
	use Validator;
	use DataTables;
	use Spatie\Permission\Models\Role;
	use DB;
	use Hash;
    use Illuminate\Support\Arr;
    use App\Models\ModelHasRoles;
    use App\Models\RoleHasPermissions;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Collection;

	/**
	 * summary
	 */
	class UserController extends Controller
	{
        function __construct()
        {
             $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
             $this->middleware('permission:user-create', ['only' => ['create','store']]);
             $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        }

	    public function index(Request $request)
        {
            $data = User::orderBy('id','DESC')->paginate(5);
            $roles = Role::get(); 
            return view('admin.users.index',compact('data','roles'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('admin.users.create',compact('roles'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'roles' => 'required',
        ];
        $messages = [
            'name.required' => 'Tên đăng nhập không được để trống',
            'name.unique' => 'Tên đăng nhập đã tồn tại',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.between' => 'Mật khẩu chỉ được phép chửa từ 8 đến 15 ký tự',
            'confirm_password.required' => 'Mật khẩu nhập lại không được để trống',
            'confirm_password.same' => 'Mật khẩu nhập lại phải trùng với mật khẩu đã nhập',
            'roles.required' => 'Vai trò không được để trống',
        ];
        $errors = Validator::make($request->all(),$rules,$messages);
        if ($errors->fails()) {
            return response()->json(['errors' => $errors->errors()->all()]);
        }
        $password = bcrypt($request->password);
        $request->merge(['password'=>$password]);
        $form_data =[
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ];
        $user = User::create($form_data);
        $user->assignRole($request->input('roles'));
        return response()->json(['success' => 'Thêm mới thành công']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::join('model_has_roles','model_has_roles.model_id','=','users.id')->join('roles','roles.id','=','model_has_roles.role_id')->select('users.*','roles.name as roleName')->where('users.id',$id)->first();
        return response()->json(['data' => $user]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->offsetUnset('_token');
        $request->offsetUnset('_method');
        $rules = [
            'name' => 'required|unique:users,name,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
        ];
        $messages = [
            'name.required' => 'Tên đăng nhập không được để trống',
            'name.unique' => 'Tên đăng nhập đã tồn tại',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Email không đúng định dạng',
            'password.same' => 'Mật khẩu xác nhận mật khẩu phải giống nhau',
            'roles.required' => 'Vai trò không được để trống',
        ];
        $errors = Validator::make($request->all(),$rules,$messages);
        if ($errors->fails()) {
            return response()->json(['errors' => $errors->errors()->all()]);
        }
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input, ['password']);     
            $input = Arr::except($input, ['confirm_password']);     
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
        return response()->json(['success' => 'Chỉnh sửa thành công!']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['success' => 'Xóa thành công!']);
        }
        else{
            return response()->json(['errors' => 'Không thể xóa']);
        }
    }

	}
 ?>