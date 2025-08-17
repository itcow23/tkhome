<?php

namespace App\Http\Controllers;

use App\Events\OrderSuccessEvent;
use App\Models\CategorySub;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontedController extends Controller
{
    public function index()
    {
        $category_sub2 = Product::getCategorySub2();
        $category_sub3 = Product::getCategorySub3();
        $newproducts =  Product::getNewProduct(); // gọi phương thức getNewProduct của đối tượng Product để lấy danh sách sản phẩm mới nhất
        $hotproducts = Product::getHotProduct(); // gọi phương thức getHotProduct của đối tượng Product để lấy danh sách sản phẩm bán chạy nhất
        return view('client.home',compact( 'category_sub2', 'category_sub3','newproducts','hotproducts'));
    }

    public function product(Request $request) {
       
        $search = $request->input('search');
       
        $products = Product::getAllProduct($search);
     
       
        return view('client.product',compact('products', 'search')); // truyền dữ liệu products vào view
    }

    public function productCategory($slug) {
        $product_category = Product::getProductByCategory( $slug); // gọi phương thức getProductByCategory của đối tượng Product để lấy danh sách sản phẩm theo category_id
        if($product_category->isEmpty()){
            $products = Product::getProductByCategorySub($slug);
        }else{
            $products = $product_category;
        }
       
        return view('client.product',compact('products')); // truyền dữ liệu products vào view
    }

    public function productDetail($slug) {
        $product = Product::getProductDetails($slug);
        $sameproducts =  Product::getSameProduct($slug);
        return view('client.product_details',compact('product','sameproducts')); // truyền dữ liệu products vào view
    }

    public function filterProducts(Request $request){
        $category =  $request->category;
        $filter = $request->filter;

        switch($filter)
        {
            case 'new':
                if($category === 'all'){
                    $products = DB::table('product')
                                ->orderBy('created_at','desc')
                                ->get();
                }else{
                    $products = DB::table('product')
                                ->select( 'product.*', 'category.id as category_id')
                                ->join( 'category_sub', 'product.category_sub_id', '=', 'category_sub.id')
                                ->join( 'category', 'category_sub.category_id', '=', 'category.id')
                                ->where('category_id', $category)
                                ->orderBy('created_at','desc')
                                ->get();
                }
                break;
            case 'desc':
                if($category === 'all'){
                    $products = DB::table('product')
                                ->orderBy('price','desc')
                                ->get();
                }else{
                    $products = DB::table('product')
                                ->select( 'product.*', 'category.id as category_id')
                                ->join( 'category_sub', 'product.category_sub_id', '=', 'category_sub.id')
                                ->join( 'category', 'category_sub.category_id', '=', 'category.id')
                                ->where('category_id', $category)
                                ->orderBy('price','desc')
                                ->get();
                }
                break;
            case 'asc':
                if($category === 'all'){
                    $products = DB::table('product')
                                ->orderBy('price','asc')
                                ->get();
                }else{
                    $products = DB::table('product')
                                ->select( 'product.*', 'category.id as category_id')
                                ->join( 'category_sub', 'product.category_sub_id', '=', 'category_sub.id')
                                ->join( 'category', 'category_sub.category_id', '=', 'category.id')
                                ->where('category_id', $category)
                                ->orderBy('price','asc')
                                ->get();
                }
                break;
        }

        return view('client.product',compact('products','filter')); // truyền dữ liệu products vào view
    }


    public function addToCart($slug){
        //session()->flush('cart'); // xóa toàn bộ dữ liệu trong session cart
        $product = Product::getProductDetails($slug);
        $carts = session()->get('cart');

        if(isset(request()->addquantity)){
            $quantity = request()->addquantity;
        }else{
            $quantity = 1;
        }


        if(isset($carts[$slug])){
            $carts[$slug]['quantity'] += $quantity;
        }else{
            $carts[$slug] = [
                'slug'=> $product->slug,
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "img" => $product->img,
            ];
        }
     
        session()->put('cart',$carts);

        $carts = session()->get('cart');
        $header_component = view( 'client.components.header_component',compact('carts'))->render();
        $num_product = count( $carts);
        return response()->json([
            'code' => 200,
            'message' => 'Thêm sản phẩm vào giỏ hàng thành công',
            'header_component' => $header_component,
            'num_product' => $num_product,
        ],200);
    }

    public  function showCart(){
        
        $carts = session()->get('cart', []);
        return view('client.cart',compact('carts'));
    }

    public function updateCart(){ // cập nhật giỏ hàng
        $carts = session()->get('cart');
        $slug = request()->slug;
        $type = request()->type;
        $value = request()->value;

        switch ((int)$type) {
            case 0:
                $carts[$slug]['quantity']--;
                if ($carts[$slug]['quantity'] <= 0) {
                    $carts[$slug]['quantity'] = 1;
                }
                break;
            case 1:
                $carts[$slug]['quantity']++;
                if ($carts[$slug]['quantity'] >= 100) {
                    $carts[$slug]['quantity'] = 100;
                }
                break;
            case -1:
                $carts[$slug]['quantity'] = (int)$value;
                if ($carts[$slug]['quantity'] <= 0) {
                    $carts[$slug]['quantity'] = 1;
                }
                if ($carts[$slug]['quantity'] >= 100) {
                    $carts[$slug]['quantity'] = 100;
                }
                break;
        }

        session()->put('cart', $carts); // cập nhật lại session cart
        $carts = session()->get('cart');
        $header_component = view( 'client.components.header_component',compact('carts'))->render();

        //cap nhat tien san pham
        $carts[$slug]['sum_price'] = currency_format($carts[$slug]['quantity'] * $carts[$slug]['price']);

        $total = 0;
        foreach ($carts as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        return  response()->json([
            'cart' => $carts[$slug],
            'total' => currency_format($total),
            'header_component' => $header_component,
        ]);
    }

    function destroyCart(){ // xóa sản phẩm khỏi giỏ hàng
        $slug = request()->input('slug');
        $cart = session()->get('cart');
        // dd($carts);
        if(isset($cart[$slug])){
            unset($cart[$slug]);
            session()->put('cart', $cart);

            $carts = session()->get('cart');
            $header_component = view( 'client.components.header_component',compact('carts'))->render();
            $cart_component =  view( 'client.components.cart_component',compact('carts'))->render();
            $num_product = count( $carts);
        }
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        return  response()->json([
            'total' => currency_format($total),
            'header_component' => $header_component,
            'cart_component' => $cart_component,
            'num_product' => $num_product,
        ]);
    }

    public function showCheckout(){
        $provinces = DB::table('province')->get();
        return view('client.checkout',compact('provinces'));
    }

    public function getDistrict(Request $request){
        $province_id = $request->province_id;
        $districts = DB::table('district')->where('province_id',$province_id)->get();

        $district_component = view( 'client.components.district_component',compact('districts'))->render();
        $district_option_component = view( 'client.components.district_option_component',compact('districts'))->render();

        return response()->json([
            'district_component' => $district_component,
            'district_option_component' => $district_option_component,
        ]);
    }

    public function getWard(Request $request){
        $district_id = $request->district_id;
        $wards = DB::table('wards')->where('district_id',$district_id)->get();

        $ward_component = view( 'client.components.ward_component',compact('wards'))->render();
        $ward_option_component = view( 'client.components.ward_option_component',compact('wards'))->render();

        return response()->json([
            'ward_component' => $ward_component,
            'ward_option_component' => $ward_option_component,
        ]);
    }

    public function processCheckout(Request $request){

        //validation
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|numeric', // số điện thoại
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required',
            'pay' => 'required',
        ],[
            'fullname.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Vui lòng nhập đúng định dạng email',
            'phone_number.required' => 'Vui lòng nhập số điện thoại',
            'phone_number.numeric' => 'Vui lòng nhập đúng định dạng số điện thoại',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'province.required' => 'Vui lòng chọn tỉnh/thành phố',
            'district.required' => 'Vui lòng chọn quận/huyện',
            'ward.required' => 'Vui lòng chọn phường/xã',
            'pay.required' => 'Vui lòng chọn hình thức thanh toán',
        ]);



        $province =  DB::table('province')->where('province_id',$request->province)->first();
        $district =  DB::table('district')->where('district_id',$request->district)->first();
        $ward =  DB::table('wards')->where('wards_id',$request->ward)->first();
        $address = $request->address . '-( ' . $ward->name . ', ' . $district->name . ', ' . $province->name . ' )'; // địa chỉ

        $dataInsert = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $address,
            'note' => $request->note,
            'pay' => $request->pay,
            'user_id' => Auth::guard('client')->user()->id,
        ];

        DB::table('order')->insert($dataInsert);
        $order_id = DB::getPdo()->lastInsertId(); // lấy id của đơn hàng vừa được thêm vào

        $carts = session()->get('cart');
        foreach ($carts as $item) {
            $dataInsertDetail = [
                'order_id' => $order_id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
            DB::table('order_details')->insert($dataInsertDetail); // thêm chi tiết đơn hàng
        }

        $order =  DB::table('order')->where('id', $order_id)->first();

        $orderCount =  DB::table('order')->where('status', 0)->count();

        event(new OrderSuccessEvent($order, $orderCount));

        session()->forget('cart'); // xóa toàn bộ dữ liệu trong session cart
        return redirect()->route('client.checkout_success'); // chuyển hướng đến trang thanh toán thành công
        

    }

    public function order(){
        if(Auth::guard('client')->check()){
            $orders =  DB::table('order')
                        ->where( 'user_id', Auth::guard('client')->user()->id)
                        ->orderBy('order.order_date','desc')
                        ->get();
            return view('client.order',compact('orders')); // truyền dữ liệu products vào view
        }
        return redirect()->route('client.login');
    }

    public function cancelOrder($id){
        $dataUpdate = [
            'status' => -1,
        ];
        DB::table('order')->where('id',$id)->update($dataUpdate); // cập nhật trạng thái đơn hàng thành hủy
        return redirect()->route('client.order');

    }

    public function filterOrders(Request $request){
        $filter = $request->input('filter');
        switch ($filter){
            case 'all':
                $orders =  DB::table('order')
                            ->where( 'user_id', Auth::guard('client')->user()->id)
                            ->orderBy('order.order_date','desc')
                            ->get();
                break;
            case -1:
                $orders =  DB::table('order')
                            ->where( 'user_id', Auth::guard('client')->user()->id)
                            ->where('status', -1)
                            ->orderBy('order.order_date','desc')
                            ->get();
                break;
            case 0:
                $orders =  DB::table('order')
                            ->where( 'user_id', Auth::guard('client')->user()->id)
                            ->where('status', 0)
                            ->orderBy('order.order_date','desc')
                            ->get();
                break;
            case 1:
                    $orders =  DB::table('order')
                                ->where( 'user_id', Auth::guard('client')->user()->id)
                                ->where('status', 1)
                                ->orderBy('order.order_date','desc')
                                ->get();
                    break;
            case 2:
                        $orders =  DB::table('order')
                                    ->where( 'user_id', Auth::guard('client')->user()->id)
                                    ->where('status', 2)
                                    ->orderBy('order.order_date','desc')
                                    ->get();
                        break;
        }
        return view('client.order',compact('orders','filter')); // truyền dữ liệu products vào view
    }
    
}
