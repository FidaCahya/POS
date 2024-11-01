<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Monolog\User;

class UserController extends Controller
{
    public function index(){
        return UserModel::all();
    }

    public function store(Request $request)
    {
    $data = $request->all();
    $data['level_id'] = $data['level_id'] ?? 1; // set a default value if missing
    $user = UserModel::create($data);
    return response()->json($user, 201);
    }


    public function show(UserModel $user)
    {
        return UserModel::find($user);
    }

    public function update(Request $request, UserModel $user)
    {
        $user->update($request->all());
        return UserModel::find($user);
    }

    public function destroy(UserModel $user)
    {
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus',

        ]);
    }
}
