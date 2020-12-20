<?php


namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Validator;
use DB;
use App\Models\ModelHasRoles;
use App\Models\RoleHasPermissions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permissions = Permission::get();
        return view('admin.permissions.index',compact('permissions'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('admin.roles.create',compact('permission'));
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
            'name' => 'required|same:str2|max:50|unique:permissions,name',
            'permissionFor' => 'required',
            'permissionType' => 'required',
        ];
        $messages = [
            'name.required' => 'Tên quyền không được để trống',
            'name.same' => 'Tên quyền không hợp lệ',
            'permissionFor.required' => 'Quyền cho bảng không được để trống',
            'permissionType.required' => 'Quyền không được để trống',
        ];
        $errors = Validator::make($request->all(),$rules,$messages);
        if ($errors->fails()) {
            return response()->json(['errors' => $errors->errors()->all()]);
        }
        $form_data = [
            'name' => $request->name,
        ];
        $permission = Permission::create($form_data);
        return response()->json(['success' => 'Thêm mới thành công!']);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();


        return view('admin.roles.show',compact('role','rolePermissions'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        $permissionName = explode('-',$permission->name);
        return response()->json(['data' => $permission,'data1' => $permissionName]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->offsetUnset('_token');
        $request->offsetUnset('_method');
        $rules = [
            'name' => 'required|unique:roles,name,'.$request->id,
            'permission' => 'required',
        ];
        $messages = [
            'name.required' => 'Tên vai trò không được để trống',
            'name.unique' => 'Tên vai trò đã tồn tại',
            'permission.required' => 'Quyền không được để trống',
        ];
        $errors = Validator::make($request->all(),$rules,$messages);
        if ($errors->fails()) {
            return response()->json(['errors' => $errors->errors()->all()]);
        }
        $role = Role::find($request->id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return response()->json(['success' => 'Chỉnh sửa thành công']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if ($role) {
            $role->delete();
            return response()->json(['success'=>'Xóa thành công!']);
        }
        else{
            return response()->json(['errors'=>'Không thể xóa']);
        }
    }
}