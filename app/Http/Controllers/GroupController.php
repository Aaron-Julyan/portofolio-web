<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class GroupController extends Controller
{
    public function index()
    {
        $permissionId = session('groupId');

        $datauser = User::find($permissionId);

        //ambil semua user kecuali user logind dan user yang sudah ada di Group
        $existingUserIDs = Group::where('group_id', $datauser->id)->pluck('user_id');
        $alluser = User::whereNotIn('id', [$datauser->id])->whereNotIn('id', $existingUserIDs)->get();

        //ini untuk mengambil group member dengan tambahan field permission status nya
        $groups = Group::where('group_id', $datauser->id)->get();
        $groupUserStatus = $groups->map(function ($group) {
            return [
                'user_id' => $group->user_id,
                'status' => $group->status,
            ];
        });
        // ambil data dari tabel user yang sama dengan groupUserStatus
        $usersWithStatus = User::whereIn('id', $groupUserStatus->pluck('user_id'))->get();
        // tambahkan status dari usernya
        $usersWithStatus->map(function ($user) use ($groupUserStatus) {
            $status = $groupUserStatus->where('user_id', $user->id)->first()['status'] ?? null;
            //tambahkan sebagai field baru, karena user sudah memiliki field 'status'
            $user->permission_status = $status;
            return $user;
        });

        //menjaga status admin saat refresh
        if (session()->has('isAdmin')) {
            session()->put('isAdmin', $permissionId);
        } 
        session()->put('groupId', $permissionId);

        return view('addgroupmember', compact('datauser', 'alluser', 'usersWithStatus'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $permissionId = session('groupId');

        $group = User::find($permissionId);

        $validateData['user_id'] = $request->selectedId;
        $validateData['group_id'] = $group->id;
        $validateData['status'] = $request->selectedRole;

        if ($request->selectedId == '0') {
            return redirect('/addgroupmember')->with('error', 'No User Selected!');
        }
        if ($request->selectedRole == '') {
            return redirect('/addgroupmember')->with('error', 'No Role Selected!');
        }

        Group::create($validateData);

        //menjaga status admin saat refresh
        if (session()->has('isAdmin')) {
            session()->put('isAdmin', $permissionId);
        } 
        session()->put('groupId', $permissionId);

        // session(['postid' => $request->postid]);
        if ($request->selectedRole == 'Member') {
            return redirect('/groupmember')->with('success', 'New Member Added!');
        } else if ($request->selectedRole == 'Admin') {
            return redirect('/groupmember')->with('success', 'New Admin Added!');
        }
    }

    public function show(Request $request)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $permissionId = session('groupId');

        $group = User::find($permissionId);
        
        //menjaga status admin saat refresh
        if (session()->has('isAdmin')) {
            session()->put('isAdmin', $permissionId);
        } 
        session()->put('groupId', $permissionId);
        
        Group::where('group_id', $group->id)
            ->where('user_id', $id)
            ->delete();
        return redirect('/groupmember')->with('success', 'Group Member Deleted!');
    }
}
