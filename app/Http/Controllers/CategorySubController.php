<?php

namespace App\Http\Controllers;

use App\Models\CategorySub;
use App\Models\User;
use Illuminate\Http\Request;

class CategorySubController extends Controller
{
    private $categories_sub;

    public function __construct(){
        $this->categories_sub = new CategorySub();
    }

    public function index(){

        $categories_sub = $this->categories_sub->getAll();
        return view('admin.categorySub.home', compact('categories_sub'));
    }

    public function create(){
        $categories = $this->categories_sub->getCategory();
        return view('admin.categorySub.create',compact( 'categories'));
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|unique:category_sub',
            'category_id' => 'required',
        ],
        [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Tên danh mục đã tồn tại',
            'category_id.required' => 'Danh mục không được để trống',
        ]);
        if($request->hasFile('img')){
            $file = $request->file('img');
            $extension = $request->file('img')->extension();
            $fileName = time() .'.' . $extension; // tạo tên file với thời gian và phần mở rộng
            $file->move(public_path('categorySubs'), $fileName);

            $datainsert = [
                'name'=>$request->name,
                'category_id'=>$request->category_id,
                'img' => $fileName,
                'slug'=> \Illuminate\Support\Str::slug($request->name). '.html',
               ];
        }else{

            $datainsert = [
                'name'=>$request->name,
                'category_id'=>$request->category_id,
                'slug'=> \Illuminate\Support\Str::slug($request->name). '.html',
               ];
        }


       
       $this->categories_sub->addCategorySub($datainsert);
        return redirect()->route('admin.category_sub.home')->with('success', 'Thêm danh mục thành công');
    }

    public function edit(Request $request, $id){
        $category_sub = $this->categories_sub->getById($id);
        $categories = $this->categories_sub->getCategory();
        $request->session()->put('id', $id);
        return view('admin.categorySub.edit', compact('category_sub', 'categories'));
    }

    public function update(Request $request){
        $id = session( 'id');

        $request->validate([
            'name' => 'required|unique:category_sub,name,'.$id,
            'category_id' => 'required',
        ],
        [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Tên danh mục đã tồn tại',
            'category_id.required' => 'Danh mục không được để trống',
        ]);
        if($request->hasFile('img')){
            $file = $request->file('img');
            $extension = $request->file('img')->extension();
            $fileName = time() .'.' . $extension; // tạo tên file với thời gian và phần mở rộng
            $file->move(public_path('categorySubs'), $fileName);

            $dataupdate = [
                'name'=>$request->name,
                'category_id'=>$request->category_id,
                'img' => $fileName,
            ];
        }else{
            $dataupdate = [
                'name'=>$request->name,
                'category_id'=>$request->category_id,
                'img' =>  $request->old_img,
            ];

        }

        $this->categories_sub->updateCategorySub($dataupdate, $id);
        return redirect()->route('admin.category_sub.home')->with('success', 'Cập nhật danh mục thành công');
    }

    public function delete( $id){
        $this->categories_sub->deleteCategorySub($id);
        return redirect()->route('admin.category_sub.home')->with('success', 'Xóa danh mục thành công');
    }
}
