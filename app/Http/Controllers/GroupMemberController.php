<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class GroupMemberController extends Controller
{   
    //untuk refresh page
    public function index()
    {
        $permissionId = session('groupId');
        $datauser = User::find($permissionId);
        $isAdmin = false; //initialize

        //ada case kalo user itu delete dia sendiri sebagai admin
        //jadi harus cek lagi, supaya dia tidak ada akses add delete member
        if (session('isAdmin') && Auth::check()) {
            $isAdmin = Group::where('user_id', Auth::user()->id)
                ->where('group_id', $permissionId)
                ->where('status', 'Admin')
                ->exists();

            if ($isAdmin) {
                session()->put('isAdmin', $permissionId);
            }
        }

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

        session()->put('groupId', $permissionId);
        return view('groupmember', compact('datauser', 'isAdmin', 'usersWithStatus'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    //dari profile dan viewprofile semua diarahin kesini
    public function show($id)
    {
        $permissionId = session('groupId');
        $datauser = User::find($permissionId);
        $isAdmin = false; //initialize

        //ada case kalo user itu delete dia sendiri sebagai admin
        //jadi harus cek lagi, supaya dia tidak ada akses add delete member
        if (session('isAdmin') && Auth::check()) {
            $isAdmin = Group::where('user_id', Auth::user()->id)
                ->where('group_id', $permissionId)
                ->where('status', 'Admin')
                ->exists();

            if ($isAdmin) {
                session()->put('isAdmin', $permissionId);
            }
        }

        //ini untuk mengambil group member dengan tambahan field permission status nya
        $groups = Group::where('group_id', $permissionId)->get();
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

        session()->put('groupId', $permissionId);
        return view('groupmember', compact('datauser', 'isAdmin', 'usersWithStatus'));
    }

    // //search function
    // public function show(Request $request)
    // {
    //     $datauser = Auth::user();

    //     // ignore case
    //     // $search = strtolower($request->search);
    //     // $alluser = User::whereNotIn('id', [$datauser->id])
    //     //     ->whereRaw('LOWER(name) LIKE ?', ["%$search%"])
    //     //     ->orWhereRaw('LOWER(category) LIKE ?', ["%$search%"])
    //     //     ->orWhereRaw('LOWER(email) LIKE ?', ["%$search%"])
    //     //     ->get();

    //     // opsi 2: tidak ignore case
    //     // $search = $request->search;
    //     // $alluser = User::where('name', 'like', "%$search%")
    //     //     ->orWhere('category', 'like', "%$search%")
    //     //     ->orWhere('email', 'like', "%$search%")
    //     //     ->whereNotIn('id', [$datauser->id])
    //     //     ->get();

    //     $search = $request->query('search', '');

    //     $alluser = User::where('id', '!=', $datauser->id)
    //         ->where(function (Builder $query) use ($search): void {
    //             $query
    //                 ->orwhere('name', 'ilike', "%{$search}%")
    //                 ->orWhere('category', 'ilike', "%{$search}%")
    //                 ->orWhere('email', 'ilike', "%{$search}%");
    //             // ->orWhereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
    //             // ->orWhereRaw('LOWER(category) LIKE ?', ["%{$search}%"])
    //             // ->orWhereRaw('LOWER(email) LIKE ?', ["%{$search}%"]);
    //         })
    //         ->get();


    //     return view('groupmember', compact('alluser', 'datauser', 'search'));
    // }

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
