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

class PagesController extends Controller {

	public function getIndex()
    {
        $order = self::getOrder();
        //echo '<pre>'; print_r($order['result']); echo '</pre>';die();

        return view('pages.index')
            ->with('order',$order['result']);
	}


    public static function getOrder() {

        $purchase = DB::table('purchase')
            ->leftJoin('purchase_item','purchase.id','=','purchase_item.purchase_id')
            ->leftJoin('meal','purchase_item.meal_id','=','meal.id')
            ->where('status','=','pending')
            ->orderby('purchase.created_at','DESC');

        if(isset($_GET['q'])){
            if($_GET['q'] != null){
                $purchase = $purchase->where('purchase.id','=',$_GET['q']);
            }
        }

        $purchase=$purchase->get();

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
                    $wait = $it->waiting;
                }

                $group[$k]['purchaseID'] = $k;
                $group[$k]['user_id'] = $gp['items'][0]->user_id;
                $group[$k]['total_meal'] = count($gp['items']);
                $group[$k]['total_items'] = $tl_item;
                $group[$k]['total_price'] = $tl_price;
                $group[$k]['datetime'] = $date;
                $group[$k]['waiting'] = $wait;
                $group[$k]['status'] = $status;
            }
        }

        $arr = array();
        foreach ($group as $k => $v){
            $arr[] = $v;
        }
        //print_r($arr);die();

        $response['result'] = $arr;

        return $response;
    }

    public function updateStatus($id){

        $purchase = Purchase::where('id','=',$id)->first();

        if($purchase != null){
            $purchase->status = 'deliver';
            $purchase->save();
        }

        return response()->json($purchase);
    }


    public function getUser()
    {
        $users = User::all()->toArray();

        return view('pages.users')
            ->with('users',$users);
    }
}