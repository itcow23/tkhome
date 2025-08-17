<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';

    public function getAll() {
        $products= DB::table( $this->table)
                    ->join('category_sub', 'product.category_sub_id', '=', 'category_sub.id') // join bảng category với bảng product với trường category_id bằng bảng id của bảng category
                    ->select('product.*', 'category_sub.name as category_sub_name') // lấy tất cả các trường của bảng product và category_name là tên của trường category_name trong bảng category
                    ->orderBy('product.name', 'asc')
                    ->paginate(10);
        return $products; // trả về dữ liệu products
    }

    public function getAllSearch($search) {
        $products= DB::table( $this->table)
                    ->join('category_sub', 'product.category_sub_id', '=', 'category_sub.id') // join bảng category với bảng product với trường category_id bằng bảng id của bảng category
                    ->select('product.*', 'category_sub.name as category_sub_name') // lấy tất cả các trường của bảng product và category_name là tên của trường category_name trong bảng category
                    ->orderBy('product.name', 'asc')
                    ->when(!empty($search), function ($query) use ($search) {
                        $query->where('product.name', 'like', '%' . $search . '%');
                    })
                    ->paginate(10)
                    ->appends([
                        'search' => $search
                    ]);
        return $products; // trả về dữ liệu products
    }

    public static function getAllProduct($search = ''){
        $products = DB::table('product')
                    ->orderBy('created_at','desc')
                    ->when(!empty($search), function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->get();
        return $products;
    }

    public static function getNewProduct(){
        $products = DB::table('product')
                    ->orderBy('created_at','desc')
                    ->limit(8)
                    ->get();
        return $products;
    }

    
    public static function getHotProduct(){
        $products = DB::table('product')
                    ->select('product.*', DB::raw('sum(order_details.quantity) as quantity'))
                    ->join('order_details', 'product.id', '=', 'order_details.product_id')
                    ->join('order','order_details.order_id','=','order.id')
                    ->where( 'order.status', '=', '2')
                    ->groupBy('product.id')
                    ->orderBy('quantity', 'desc')
                    ->limit(8)
                    ->get();
        return $products;
    }

    public static function getSameProduct($slug){
        $category_sub_id = DB::table('product')
                    ->select( 'category_sub_id')
                    ->where('slug',$slug)
                    ->get();
       
        $sameproducts  = DB::table('product')
                    ->select( 'product.*')
                    ->where('category_sub_id',$category_sub_id[0]->category_sub_id)
                    ->where( 'slug','!=',$slug) // loại bỏ sản phẩm đã được chọn
                    ->limit(8)
                    ->get();
        return $sameproducts;
    }

    public static  function getProductByCategorySub($category_sub_slug){
        $products = DB::table('product')
                    ->select( 'product.*')
                    ->join( 'category_sub', 'product.category_sub_id', '=', 'category_sub.id')
                    ->where('category_sub.slug', $category_sub_slug)
                    ->orderBy('name','asc')
                    ->get(); // lấy tất cả các sản phẩm của category_sub_id được truyền vào
        return $products; // trả về dữ liệu products
    }

    public static  function getProductByCategory($category_slug){
        $products =  DB::table('product')
                    ->select( 'product.*') // lấy tất cả các trường của bảng product
                    ->join( 'category_sub', 'product.category_sub_id', '=', 'category_sub.id') // join bảng category với bảng product với trường category_id bằng bảng id của bảng category
                    ->join( 'category', 'category_sub.category_id', '=', 'category.id') // join bảng category với bảng category_sub với trường category_id bằng bảng id của bảng category_sub
                    ->where('category.slug', $category_slug)
                    ->orderBy('product.name','asc')
                    ->get(); // lấy tất cả các sản phẩm của category_sub_id được truyền vào
        return $products; // trả về dữ liệu products
    }

    public static function getCategorySub() {
        $category_sub = DB::table('category_sub')
                        ->orderBy('name', 'asc')
                        ->get();
        return $category_sub;
    }
    public static function getCategorySub2() {
        $category_sub = DB::table('category_sub')
                        ->orderBy('name', 'desc')
                        ->paginate(2);
        return $category_sub;
    }
    public static function getCategorySub3() {
        $category_sub = DB::table('category_sub')
                        ->orderBy('name', 'asc')
                        ->paginate(3);
        return $category_sub;
    }
    
    public function addProduct($datainsert) {
        DB::table($this->table)->insert($datainsert); // gọi phương thức insert của đối tượng product để insert dữ liệu vào bảng product
    }

    public function getProductById($id) {
        $product = DB::table($this->table)
                    ->where('id', $id)
                    ->first();
        return $product;
    }
    public static function getProductDetails($slug) {
        $product = DB::table('product')
                    ->where('slug', $slug)
                    ->first();
        return $product;
    }

    public function updateProduct($id,$dataUpdate) {
        DB::table($this->table)
            ->where('id', $id)
            ->update($dataUpdate); // gọi phương thức update của đối tượng product để update dữ liệu vào bảng product
    }

    public function deleteProduct($id) {
        DB::table($this->table)
            ->where('id', $id)
            ->delete(); // gọi phương thức delete của đối tượng product để xóa dữ liệu vào bảng product
    }
}
