<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $product;
    public function __construct() {
        $this->product = new Product();  // khởi tạo đối tượng product
    }

    public function index(Request  $request) {
        $search = $request->input('search');
        if(isset($search)){
           $products = $this->product->getAllSearch($search);
        }else{
            $products = $this->product->getAll();
        }
        return view('admin.product.home', compact('products','search'))->with('i',(request()->input('page',1)-1)*10); // truyền dữ liệu products vào view
    }
    public function create() {
        $category_sub = $this->product->getCategorySub();
        return view('admin.product.create', compact('category_sub')); // truyền dữ liệu categories vào view
    }

    public function store(Request $request) {

        //validation
        $request->validate([
            'name' => 'required|unique:product',  // bắt buộc phải nhập
            'price' => 'required', // bắt buộc phải nhập
            'category_sub_id' => 'required', // bắt buộc phải nhập
        ],
        [
            'name.required' => 'Bạn chưa nhập tên sản phẩm',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'price.required' => 'Bạn chưa nhập giá sản phẩm',
            'category_sub_id.required' => 'Bạn chưa chọn danh mục sản phẩm',
        ]);// kiểm tra dữ liệu

        if( $request->hasFile('img')) {
            $file = $request->file('img');
            $extension = $request->file('img')->extension();
            $fileName = time() .'.' . $extension; // tạo tên file với thời gian và phần mở rộng
            $file->move(public_path('products'), $fileName);

            $dataInsert = [
                'name' => $request->name,
                'price' => $request->price,
                'discount'=> $request->discount,
                'description'=> $request->description,
                'img'=> $fileName,
                'category_sub_id' => $request->category_sub_id,
                'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . \Illuminate\Support\Str::random(3) . '.html',
            ]; // tạo mảng dữ liệu để insert vào bảng product
        } else{

            $dataInsert = [
                'name' => $request->name,
                'price' => $request->price,
                'discount'=> $request->discount,
                'description'=> $request->description,
                'category_sub_id' => $request->category_sub_id,
                'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . \Illuminate\Support\Str::random(3) . '.html',
            ]; // tạo mảng dữ liệu để insert vào bảng product
        }

       
        
        $this->product->addProduct($dataInsert); // gọi phương thức addProduct của đối tượng product để insert dữ liệu vào bảng product
        return redirect()->route('admin.product.home')->with('success', 'Thêm sản phẩm thành công'); // trả về thông báo thành công
    }

    public function edit(Request $request, $id) {
        $product = $this->product->getProductById($id); // gọi phương thức getProductById của đối tượng product để lấy dữ liệu của sản phẩm theo id
        $category_sub = $this->product->getCategorySub(); // gọi phương thức getCategory của đối tượng product để lấy dữ liệu của category
        $request->session() -> put('id', $id);  // lưu id của sản phẩm vào session
        session()->put('current-page-update-product', $request->input('last_page'));
        return view('admin.product.edit', compact('product', 'category_sub')); // truyền dữ liệu product và category vào view
    }

    public function update(Request $request) {
        $id = session( 'id'); // lấy id của sản phẩm từ session
        //validation
        $request->validate([
            'name' => 'required|unique:product,name,'.$id, // bắt buộc phải nhập
            'price' => 'required', // bắt buộc phải nhập
            'category_sub_id' => 'required', // bắt buộc phải nhập
        ],
        [
            'name.required' => 'Bạn chưa nhập tên sản phẩm',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'price.required' => 'Bạn chưa nhập giá sản phẩm',
            'category_sub_id.required' => 'Bạn chưa chọn danh mục sản phẩm',
        ]);// kiểm tra dữ liệu


        $currentPage = session()->get('current-page-update-product');
        session()->forget('current-page-update-product');
        if( $request->hasFile('img')) {
            $file = $request->file('img');
            $extension = $request->file('img')->extension();
            $fileName = time() .'.' . $extension; // tạo tên file với thời gian và phần mở rộng
            $file->move(public_path('products'), $fileName);

            $dataUpdate = [
                'name' => $request->name,
                'price' => $request->price,
                'discount'=> $request->discount,
                'description'=> $request->description,
                'img'=> $fileName,
                'category_sub_id' => $request->category_sub_id,
                'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . \Illuminate\Support\Str::random(3) . '.html',
                
            ]; // tạo mảng dữ liệu để insert vào bảng product
        } else{

            $dataUpdate = [
                'name' => $request->name,
                'price' => $request->price,
                'discount'=> $request->discount,
                'description'=> $request->description,
                'img'=> $request->img_old,
                'category_sub_id' => $request->category_sub_id,
                'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . \Illuminate\Support\Str::random(3) . '.html',
                
            ]; // tạo mảng dữ liệu để insert vào bảng product
        }

        $this->product->updateProduct($id, $dataUpdate); // gọi phương thức updateProduct của đối tượng product để update dữ liệu vào bảng product
        return redirect()->route('admin.product.home', [
            'page' => $currentPage,
        ])->with( 'success', 'Cập nhật sản phẩm thành công'); // trả về thông báo thành công
    }

    public function delete($id) {
        $this->product->deleteProduct($id); // gọi phương thức deleteProduct của đối tượng product để xóa dữ liệu vào bảng product
        return redirect()->route('admin.product.home')->with( 'success', 'Xóa sản phẩm thành công'); // trả về thông báo thành công
    }
}
