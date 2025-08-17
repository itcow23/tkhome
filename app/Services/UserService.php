<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function getAll(){
        $users = DB::table('user')
                ->join( 'role', 'user.role_id', '=', 'role.id')
                ->select('user.*', 'role.name as role_name')
                ->paginate(10);
        return  $users;
    }

    public function getUserById($id){
        $user = DB::table('user')
                ->where('user.id', $id)
                ->first();
        return $user;
    }

    public function getRole(){
        $role = DB::table('role')->get();
        return $role;
    }

    public function updateProduct($id, $role_id){
        DB::table('user')
            ->where('id', $id)
            ->update(['role_id' => $role_id]);
    }

    public function deleteProduct($id){
        DB::table('user')
            ->where('id', $id)
            ->delete();
    }
}