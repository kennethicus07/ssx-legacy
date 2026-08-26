<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Carbon\Carbon;

class UserAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('superadmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user_accounts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user_accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:App\Models\User,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8'
        ]);

        $user = new User;
        $user->name = $request->input('name');
        $user->email = Str::lower($request->input('email'));
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make($request->input('password'));
        $user->password_unhash = $request->input('password');
        $user->user_group = 4;
        $user->status = 1;
        $user->save();

        $user->givePermissionTo('view dashboard');

        return redirect()->route('admin.user-accounts.index')->with('status', 'User account successfully saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $per_page = $request->input('per_page');
        $limit = $per_page;
        $no_of_records_per_page = $limit;
        $page = $request->input('page');
        $offset = ($page-1) * $no_of_records_per_page; 

        $users = User::whereNotIn('user_group', [2, 3]);

        if ($request->has('filter')) {
            $filters = json_decode($request->input('filter'), true);
            if (!empty($filters['name'])) {
                $users->where('name', 'like', '%'.$filters['name'].'%');
            }
            if (!empty($filters['email'])) {
                $users->where('email', 'like', '%'.$filters['email'].'%');
            }
            if (!empty($filters['status'])) {
                if ($filters['status'] == 'active') {
                    $users->where('status', 1);
                } else {
                    $users->where('status', 5);
                }
            }
        }

        if ($request->has('sort')) {
            $sort = json_decode($request->input('sort'), true);
            $users->orderBy("{$sort['field']}", "{$sort['type']}");
        }

        $total_users = $users->count();

        $records = $users->offset($offset)->limit($no_of_records_per_page)->get();

        return response()->json(['total' => $total_users, 'data' => $records], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrfail($id);

        return view('admin.user_accounts.update', compact('user'));
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
        $user = User::findOrFail($id);

        $arr_default_permission[] = 1;
        $arr_new_permission = $request->input('permission');

        $arr_permission = Arr::collapse([$arr_default_permission, $arr_new_permission]);

        $user->syncPermissions($arr_permission);

        return redirect()->route('admin.user-accounts.index')->with('status', 'User account permission successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(true, 200);
    }

    public function suspend($id)
    {
        $user = User::findOrFail($id);
        $user->status = 5;
        $user->save();

        return response()->json(true, 200);
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 1;
        $user->email_verified_at = Carbon::now();
        $user->save();
        
        return response()->json(true, 200);
    }

    public function change_password()
    {

    }
}
