<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categories;

    public function __construct(){
        $this->categories = new Category();
    }

    public function index(){
        $categories = $this->categories->getAll();
        return view('admin.category.home', compact('categories'));
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store(Request $request){
        //validation
        $request->validate([
            'name' => 'required|unique:category',  // bắt buộc phải nhập
        ],[
            'name.required' => 'Bạn chưa nhập tên danh mục', // bắt buộc phải nhập
            'name.unique' => 'Tên danh mục đã tồn tại', // bắt buộc phải nhập
        ]);

       $datainsert = [
        'name'=>$request->name,
        'slug'=> \Illuminate\Support\Str::slug($request->name). '.html',
       ];
       $this->categories->addCategory($datainsert);
        return redirect()->route('admin.category.home')->with('success', 'Thêm danh mục thành công');
    }

    public function edit(Request $request, $id){
        $category = $this->categories->getById($id);
        $request->session()->put('id', $id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request){
        $id = session( 'id');
        $request->validate([
            'name' => 'required|unique:category,name,'.$id,  // bắt buộc phải nhập
        ]
        ,[
            'name.required' => 'Bạn chưa nhập tên danh mục', // bắt buộc phải nhập
            'name.unique' => 'Tên danh mục đã tồn tại', // bắt buộc phải nhập
        ]);
        $dataupdate = [
            'name'=>$request->name,
        ];
        $this->categories->updateCategory($dataupdate, $id);
        return redirect()->route('admin.category.home')->with('success', 'Cập nhật danh mục thành công');
    }

    public function delete( $id){
        $this->categories->deleteCategory($id);
        return redirect()->route('admin.category.home')->with('success', 'Xóa danh mục thành công');
    }
}
