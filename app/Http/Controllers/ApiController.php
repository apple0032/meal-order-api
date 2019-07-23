<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Meal;
use App\Cart;
use App\Purchase;
use App\PurchaseItem;
use Validator;
use Session;
use DB;

class ApiController extends Controller
{
    public function getAllMeal() {
        
       $meal = Meal::get();

       return response()->json($meal);

    }

    public function getMealById($id) {
        
       $meal = Meal::where('id','=',$id)->first()->toArray();

       return response()->json($meal);

    }
    
    public function getMealByCategory($name) {
        
       $meal = Meal::where('category','=',$name)->get();

       return response()->json($meal);

    }

    public function createCart(Request $request) {
        
       $meal = Meal::where('id','=',$request->meal_id)->first();
       $single = $meal->price;
       $total = ($meal->price) * ($request->qty);

       //Check for duplicate in cart
        $exist = Cart::where('user_id','=',$request->user_id)
            ->where('meal_id', '=',$request->meal_id)
            ->first();

        if($exist == null) {
            $cart = new Cart();
            $cart->meal_id = $request->meal_id;
            $cart->qty = $request->qty;
            $cart->single_price = $single;
            $cart->total_price = $total;
            $cart->user_id = $request->user_id;
            $cart->save();
        } else {
            //if exist, update it;
            $qty = $request->qty + $exist->qty;
            $total_price = $exist->total_price + $total;

            $exist->qty = $qty;
            $exist->total_price = $total_price;
            $exist->save();
            $cart = $exist;
        }
        
       return response()->json($cart);

    }
        
    
    public function createOrder(Request $request){

        $cart = Cart::where('user_id','=',$request->user_id)->get();
        $tl_price = 0;
        foreach ($cart as $c){
            $tl_price += $c->total_price;
        }

        $purchase = new Purchase();
        $purchase->user_id = $request->user_id;
        $purchase->total_item = count($cart);
        $purchase->total_price = $tl_price;
        $purchase->waiting = $request->waiting;
        $purchase->status = 'pending';
        $purchase->save();

        $items = array();
        foreach ($cart as $c){
            $item = new PurchaseItem();
            $item->purchase_id = $purchase->id;
            $item->user_id = $request->user_id;
            $item->meal_id = $c->meal_id;
            $item->qty = $c->qty;
            $item->single_price = $c->single_price;
            $item->total_price = $c->total_price;
            $item->save();
            $items[] = $item;

            $c->delete();
        }

        return response()->json($purchase);
    }


    public function getCart($user) {

        $cart = DB::table('cart')
                ->leftJoin('meal','cart.meal_id','=','meal.id')
                ->where('user_id','=',$user)
                ->get();

        return response()->json($cart);
    }


    public function getOrder($user) {

        $purchase = DB::table('purchase')
            ->leftJoin('purchase_item','purchase.id','=','purchase_item.purchase_id')
            ->leftJoin('meal','purchase_item.meal_id','=','meal.id')
            ->where('purchase.user_id','=',$user)
            ->get();

        $group = array();
        foreach ($purchase as $p){
            if(!in_array($p->purchase_id,$group)){
                $group[$p->purchase_id]['items'][] = $p;
            }
        }

        if($group != null) {
            foreach ($group as $k => $gp) {
                $tl_item = 0;
                $tl_price = 0;
                foreach ($gp['items'] as $it) {
                    $tl_item += $it->qty;
                    $tl_price += $it->total_price;
                    $date = $it->created_at;
                    $status = $it->status;
                }

                $group[$k]['total_items'] = $tl_item;
                $group[$k]['total_price'] = $tl_price;
                $group[$k]['datetime'] = $date;
                $group[$k]['status'] = $status;
            }
        }

        return response()->json($group);
    }


    public function getWaiting($user) {

        $cart = DB::table('purchase')
            ->where('user_id','=',$user)
            ->where('status','=','pending')
            ->get();

        return response()->json($cart);
    }


    public function checkOut($purchaseId){
        $purchase = Purchase::where('id','=',$purchaseId)->first();

        if($purchase != null){
            $purchase->status = 'done';
            $purchase->save();
        }

        //test git pull on aws

        return response()->json($purchase);
    }



    protected function validator(array $data)
    {
        //print_r($data);die();
        return response()->json([
            'result' => 'error',
            'status' => '400',
            'error_message' => $data
        ],200);
    }

}
