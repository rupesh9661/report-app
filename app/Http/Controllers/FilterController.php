<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    /**
     * Search users
     */
    public function searchUsers(Request $request)
    {
        $search = $request->input('search', '');
        
        $users = DB::table('users')
            ->select('id', 'name')
            ->when($search, function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->limit(50)
            ->get();

        return response()->json($users);
    }

    /**
     * Search games
     */
    public function searchGames(Request $request)
    {
        $search = $request->input('search', '');
        
        $games = DB::table('games')
            ->select('id', 'name', 'category')
            ->where('status', 'active')
            ->when($search, function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('code', 'LIKE', "%{$search}%");
            })
            ->limit(50)
            ->get();

        return response()->json($games);
    }

    /**
     * Search providers
     */
    public function searchProviders(Request $request)
    {
        $search = $request->input('search', '');
        
        $providers = DB::table('providers')
            ->select('id', 'name', 'code')
            ->where('status', 'active')
            ->when($search, function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('code', 'LIKE', "%{$search}%");
            })
            ->limit(50)
            ->get();

        return response()->json($providers);
    }
}
