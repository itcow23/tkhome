<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategorySub extends Model
{
    use HasFactory;
    protected $table = 'category_sub';

    public static function getCategory(){
        $categories = DB::table('category')->get();
        return $categories;
    }
    public function  getAll(){
        $categories_sub = DB::table($this->table)
        ->select('category_sub.*', 'category.name as category_name')
        ->join('category', 'category_sub.category_id', '=', 'category.id')
        ->get();
        return $categories_sub;
    }

    public function addCategorySub($datainsert){
        DB::table($this->table)->insert($datainsert);
    }

    public function getById($id){
        $category = DB::table($this->table)->where('id', $id)->first();
        return $category;
    }

    public function updateCategorySub($dataupdate, $id){
        DB::table($this->table)->where('id', $id)->update($dataupdate);
    }

    public function deleteCategorySub($id){
        DB::table($this->table)->where('id', $id)->delete();
    }
}
