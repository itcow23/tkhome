<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

use function PHPUnit\Framework\returnSelf;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

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
