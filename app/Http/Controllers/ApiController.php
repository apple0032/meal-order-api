<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Meal;
use App\Cart;
use App\Purchase;
use App\PurchaseItem;
use App\User;
use App\Favourite;
use Validator;
use Session;
use DB;

class ApiController extends Controller
{
    public function getAllMeal() {
        
        $meal = null;
        if(isset($_GET['q'])){
            if($_GET['q'] != null){
                $key = $_GET['q'];
                $meal = Meal::where('name', 'LIKE', '%'.$key.'%')->get();
            }
        }
        
        if($meal == null){
            $meal = Meal::get();
        }
        
       $response['result'] = $meal;

       return response()->json($response);

    }
    
    public function getMealById($id,$userid) {
        
       //Step1 - Search in cart, find existed food qty & total price
        $exist = Cart::where('user_id','=',$userid)
            ->where('meal_id', '=',$id)
            ->first();
        if($exist == null){
            $exist = 'null';
        } else {
            $exist->toarray();
        }
        
       $meal = Meal::where('id','=',$id)->first()->toArray();
       $meal['exist'] = $exist;

       return response()->json($meal);

    }
    
    public function getMealByCategory($name) {
        
       $meal = Meal::where('category','=',$name)->get();
       $response['result'] = $meal;

       return response()->json($response);

    }

    public function createCart(Request $request) {
        
       $meal = Meal::where('id','=',$request->meal_id)->first();
       $single = $meal->price;
       $total = $request->total;
       $qty = $total/$single;

       //Check for duplicate in cart
        $exist = Cart::where('user_id','=',$request->user_id)
            ->where('meal_id', '=',$request->meal_id)
            ->first();

        if($exist != null) {
            //if exist, delete it;
            $exist->delete();
        }
        
        $cart = new Cart();
        $cart->meal_id = $request->meal_id;
        $cart->qty = $qty;
        $cart->single_price = $single;
        $cart->total_price = $total;
        $cart->user_id = $request->user_id;
        $cart->save();
        
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

        $total = DB::table('cart')
            ->where('user_id','=',$user)
            ->sum('cart.total_price');

        $qty = DB::table('cart')
            ->where('user_id','=',$user)
            ->sum('cart.qty');

        $response['total'] = $total;
        $response['qty'] = $qty;
        $response['result'] = $cart;


        return response()->json($response);
    }


    public function getOrder($user) {

        $purchase = DB::table('purchase')
            ->leftJoin('purchase_item','purchase.id','=','purchase_item.purchase_id')
            ->leftJoin('meal','purchase_item.meal_id','=','meal.id')
            ->where('purchase.user_id','=',$user)
            ->where('status','=','pending')
            ->orderby('purchase.created_at','DESC')
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

        $arr = array();
        foreach ($group as $k => $v){
            $arr[] = $v;
        }
        //print_r($arr);die();

        $response['result'] = $arr;

        return response()->json($response);
    }


    public function getWaiting($user) {

        $cart = DB::table('purchase')
            ->where('user_id','=',$user)
            ->where('status','=','pending')
            ->get();

        $result['result'] = $cart;

        return response()->json($result);
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


    public function deleteFromCart(Request $request){
        $exist = Cart::where('user_id','=',$request->user_id)
            ->where('meal_id', '=',$request->meal_id)
            ->first();
        $exist->delete();

        return response()->json($exist);
    }

    public function login(Request $request){
        
        $user = User::where('email','=',$request->email)
                ->where('password', '=',$request->password)
                ->first();
        
        if($user != null){
            $result['result'] = 'success';
            $result['info']['id'] = $user->id;
            $result['info']['name'] = $user->name;
        } else {
            $result['result'] = 'fail';
        }
        
        return response()->json($result);
    }
    
    
    public function addFavourite(Request $request){
        
        $fav = new Favourite();
        $fav->user_id = $request->user_id;
        $fav->meal_id = $request->meal_id;
        $fav->save();
        
        $result['favourite'] = $fav;
        
        return response()->json($result);
    }
    
    
    public function removeFavourite(Request $request){
        
        $fav = Favourite::where('id','=',$request->fav_id)->first();
        $fav->delete();
        
        $result['deleted'] = $fav;
        
        return response()->json($result);
    }

    
    public function getFavourite($userid){

        $fav = DB::table('favourite')
                ->leftJoin('meal','favourite.meal_id','=','meal.id')
                ->where('user_id','=',$userid)
                ->get();
        

        $result['fav'] = $fav;
        
       return response()->json($result);
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
