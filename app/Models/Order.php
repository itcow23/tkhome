<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';

    public function getAll(){
        $orders = DB::table($this->table)
                    ->orderBy('order.order_date','desc')
                    ->paginate(10);
        return $orders; // trả về dữ liệu orders
    }

    public function accept($id){
        DB::table($this->table)
            ->where('id',$id)
            ->update(['status'=>1]);
    }

    public function ship_success($id){
        DB::table($this->table)
            ->where('id',$id)
            ->update(['status'=>2]);
    }

    public function cancel($id){
        DB::table($this->table)
            ->where('id',$id)
            ->update(['status'=>-1]);
    }
}
