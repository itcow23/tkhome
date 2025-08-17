<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    public function  getAll(){
        $categories = DB::table($this->table)->get();
        return $categories;
    }

    public function addCategory($datainsert){
        DB::table($this->table)->insert($datainsert);
    }

    public function getById($id){
        $category = DB::table($this->table)->where('id', $id)->first();
        return $category;
    }

    public function updateCategory($dataupdate, $id){
        DB::table($this->table)->where('id', $id)->update($dataupdate);
    }

    public function deleteCategory($id){
        DB::table($this->table)->where('id', $id)->delete();
    }
}
