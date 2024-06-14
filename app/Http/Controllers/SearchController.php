<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Contributor;
use App\Models\Keyword;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index()
    {
        // $datauser = Auth::user();
        // // $alluser = User::where('id', '!=', $datauser->id)->get();;

        // //ini untuk mengambil group member dengan tambahan field permission status nya
        // $groups = Group::where('group_id', $datauser->id)->get();
        // $groupUserStatus = $groups->map(function ($group) {
        //     return [
        //         'user_id' => $group->user_id,
        //         'status' => $group->status,
        //     ];
        // });
        // // ambil data dari tabel user yang sama dengan groupUserStatus
        // $usersWithStatus = User::whereIn('id', $groupUserStatus->pluck('user_id'))->get();
        // // tambahkan status dari usernya
        // $usersWithStatus->map(function ($user) use ($groupUserStatus) {
        //     $status = $groupUserStatus->where('user_id', $user->id)->first()['status'] ?? null;
        //     //tambahkan sebagai field baru, karena user sudah memiliki field 'status'
        //     $user->permission_status = $status; 
        //     return $user;
        // });

        // return view('search', compact('datauser', 'usersWithStatus'));
        return view('search');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    // //search function
    // public function show(Request $request)
    // {
    //     // $datauser = Auth::user();

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

    //     $searchvalue = $request->query('search', '');

    //     // modifikasi search value jika lebih dari satu kata
    //     $modifiedSearchValue = $searchvalue;

    //     // Periksa apakah lebih dari satu kata
    //     if (strpos($searchvalue, ' ') !== false) {
    //         $modifiedSearchValue = "'" . $searchvalue . "'"; //tambahkan tanda kutip pada nilai pencarian
    //     }

    //     // dd($searchvalue);

    //     // $datauser = User::where(function (Builder $query) use ($searchvalue): void {
    //     //     $query
    //     //         ->orwhere('name', 'ilike', "%{$searchvalue}%")
    //     //         ->orWhere('category', 'ilike', "%{$searchvalue}%")
    //     //         ->orWhere('email', 'ilike', "%{$searchvalue}%");
    //     // })
    //     //     ->get();

    //     // $datapost = Post::orderBy('created_at', 'desc')
    //     //     ->where(function (Builder $query) use ($searchvalue): void {
    //     //         $query
    //     //             ->orwhere('description', 'ilike', "%{$searchvalue}%")
    //     //             ->orwhere('department', 'ilike', "%{$searchvalue}%")
    //     //             ->orWhere('categories', 'ilike', "%{$searchvalue}%")
    //     //             ->orWhere('subcategories', 'ilike', "%{$searchvalue}%");
    //     //     })
    //     //     ->get();

    //     // $datauser = User::whereRaw("to_tsvector('english', name || ' ' || category || ' ' || email ) @@ to_tsquery('english', ?)", [$searchvalue])
    //     //     ->orderBy('created_at', 'desc')
    //     //     ->get();

    //     // $datapost = Post::with('user')
    //     //     ->whereRaw("to_tsvector('english', description || ' ' || department || ' ' || categories || ' ' || subcategories) @@ to_tsquery('english', ?)", [$searchvalue])
    //     //     ->orderBy('created_at', 'desc')
    //     //     ->get();

    //     // jika ingin menggunakan dua bahasa
    //     $datauser = User::whereRaw("to_tsvector('english', name || ' ' || category || ' ' || email)
    //     @@ to_tsquery('english', ?)
    //     OR
    //     to_tsvector('indonesian', name || ' ' || category || ' ' || email)
    //     @@ to_tsquery('indonesian', ?)", [$modifiedSearchValue, $modifiedSearchValue])
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     // datapostbycategories : bingung namain variabel nya apa
    //     $datapostbycategories = Post::with('user')
    //         ->whereRaw("to_tsvector('english', description || ' ' || department || ' ' || categories || ' ' || subcategories)
    //     @@ to_tsquery('english', ?)
    //     OR
    //     to_tsvector('indonesian', description || ' ' || department || ' ' || categories || ' ' || subcategories)
    //     @@ to_tsquery('indonesian', ?)", [$modifiedSearchValue, $modifiedSearchValue])
    //         ->orderBy('created_at', 'desc')
    //         ->get();
    //     $pluckdatapostbycategories = $datapostbycategories->pluck('id')->toArray();

    //     // ambil post dari keyword
    //     // $datakeyword = Keyword::where('keyword', $searchvalue)->get();
    //     $datakeyword = Keyword::orderBy('created_at', 'desc')
    //         ->where(function (Builder $query) use ($searchvalue): void {
    //             $query
    //                 ->orWhere('keyword', 'ilike', "%{$searchvalue}%");
    //         })
    //         ->get();
    //     $postidbykeyword = $datakeyword->pluck('post_id');
    //     $datapostbykeyword = Post::whereIn('id', $postidbykeyword)
    //         ->whereNotIn('id', $pluckdatapostbycategories)
    //         ->get();

    //     $datapost = $datapostbycategories->concat($datapostbykeyword);
    //     // comment penjelasan search by keyword:
    //     // jadi kan bisa aja keyword yang diisi sama dengan department, categories, dan subcategories
    //     // jadi diambil dulu post yang value nya ada di department, categories, dan subcategories
    //     // lalu ambil post yang value nya ada di keyword, lalu digabungkan keduanya pada datapost, tanpa menampilkan data secara duplikat

    //     // coba print ini kalo mau test
    //     // $pluckdatapostbtykeyword = $datapostbykeyword->pluck('id')->toArray();
    //     // dd($pluckdatapostbycategories, $pluckdatapostbtykeyword);

    //     $count = $datauser->count() + $datapost->count();

    //     $postcontributor = [];
    //     $postkeyword = [];
    //     foreach ($datapost as $post) {
    //         $postcontributor[$post->id] = Contributor::select('contributors.*', 'users.file', 'users.name', 'users.email', 'users.status')
    //             ->join('users', 'users.id', '=', 'contributors.user_id')
    //             ->where('contributors.post_id', $post->id)
    //             ->get();
    //         $postkeyword[$post->id] = Keyword::where('post_id', $post->id)->get();
    //     }

    //     // dd($datapost);

    //     return view('search', compact('searchvalue', 'count', 'datauser', 'datapost', 'postcontributor', 'postkeyword'));
    // }

    //search function
    public function show(Request $request)
    {

        $searchvalue = $request->query('search', '');

        // modifikasi search value jika lebih dari satu kata
        $modifiedSearchValue = $searchvalue;

        // Periksa apakah lebih dari satu kata
        if (strpos($searchvalue, ' ') !== false) {
            $modifiedSearchValue = "'" . $searchvalue . "'"; //tambahkan tanda kutip pada nilai pencarian
        }

        // jika ingin menggunakan dua bahasa
        // $datauser = User::whereRaw("to_tsvector('english', name || ' ' || category || ' ' || email)
        // @@ to_tsquery('english', ?)
        // OR
        // to_tsvector('indonesian', name || ' ' || category || ' ' || email)
        // @@ to_tsquery('indonesian', ?)", [$modifiedSearchValue, $modifiedSearchValue])
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        $datauser = User::orderBy('created_at', 'desc')
            ->where(function (Builder $query) use ($searchvalue): void {
                $query
                    ->orwhere('name', 'like', "%{$searchvalue}%")
                    ->orwhere('category', 'like', "%{$searchvalue}%")
                    ->orWhere('email', 'like', "%{$searchvalue}%");
            })->get();

        // datapostbycategories : bingung namain variabel nya apa
        // $datapostbycategories = Post::with('user')
        //     ->whereRaw("to_tsvector('english', description || ' ' || department || ' ' || categories || ' ' || subcategories)
        // @@ to_tsquery('english', ?)
        // OR
        // to_tsvector('indonesian', description || ' ' || department || ' ' || categories || ' ' || subcategories)
        // @@ to_tsquery('indonesian', ?)", [$modifiedSearchValue, $modifiedSearchValue])
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        $datapostbycategories = Post::with('user')
            ->orderBy('created_at', 'desc')
            ->where(function (Builder $query) use ($searchvalue): void {
                $query
                    ->orWhere('description', 'like', "%{$searchvalue}%")
                    ->orWhere('department', 'like', "%{$searchvalue}%")
                    ->orWhere('categories', 'like', "%{$searchvalue}%")
                    ->orWhere('subcategories', 'like', "%{$searchvalue}%");
            })
            ->get();

        $pluckdatapostbycategories = $datapostbycategories->pluck('id')->toArray();

        // dd($pluckdatapostbycategories);

        // ambil post dari keyword
        $datakeyword = Keyword::orderBy('created_at', 'desc')
            ->where(function (Builder $query) use ($searchvalue): void {
                $query
                    ->orWhere('keyword', 'like', "%{$searchvalue}%");
            })
            ->get();
        $postidbykeyword = $datakeyword->pluck('post_id');
        $datapostbykeyword = Post::whereIn('id', $postidbykeyword)
            ->whereNotIn('id', $pluckdatapostbycategories)
            ->get();

        $datapost = $datapostbycategories->concat($datapostbykeyword);
        // comment penjelasan search by keyword:
        // jadi kan bisa aja keyword yang diisi sama dengan department, categories, dan subcategories
        // jadi diambil dulu post yang value nya ada di department, categories, dan subcategories
        // lalu ambil post yang value nya ada di keyword, lalu digabungkan keduanya pada datapost, tanpa menampilkan data secara duplikat

        $count = $datauser->count() + $datapost->count();

        $postcontributor = [];
        $postkeyword = [];
        foreach ($datapost as $post) {
            $postcontributor[$post->id] = Contributor::select('contributors.*', 'users.file', 'users.name', 'users.email', 'users.status')
                ->join('users', 'users.id', '=', 'contributors.user_id')
                ->where('contributors.post_id', $post->id)
                ->get();
            $postkeyword[$post->id] = Keyword::where('post_id', $post->id)->get();
        }

        return view('search', compact('searchvalue', 'count', 'datauser', 'datapost', 'postcontributor', 'postkeyword'));
    }

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
