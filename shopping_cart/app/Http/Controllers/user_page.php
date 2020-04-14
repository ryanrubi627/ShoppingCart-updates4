<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\item;
use Session;

class user_page extends Controller
{
    public function index(){
		$item = item::all();
		return view('user_page', ['items'=>$item]);
	}

	public function show_item(Request $request){
		$item_id = item::find($request->id);
		return response()->json($item_id);
	}

	public function quantity_update(Request $request){
		$id = $request->id;
		$result_quantity = $request->result_quantity;

		item::where('id', $id)
                  ->update(['quantity' => $result_quantity]);
	}

	public function cart_item(Request $request){
		$item_id = item::find($request->id);
		return response()->json($item_id);
	}


	public function store_to_session_cart(Request $request){
		$item = ['id' => $request->id,
				 'nameofitem' => $request->name,
				 'description' => $request->description,
				 'quantity' => $request->quantity,
				 'price' => $request->price];

		if(session::exists('cart_item')){
			if($request->session()->get('cart_item') == null){
				Session::push('cart_item.'.$request->id, $item);
				return "Add to cart successfuly";
			}else{
				$cart_id = $request->session()->get('cart_item');

				foreach($cart_id as $key){
					if($key[0]['id'] != $request->id){
						Session::push('cart_item.'.$request->id, $item);
						return "Add to cart successfuly";
					}else {
						$totalQuantity = $request->quantity + $key[0]['quantity'];
						$item = ['id' => $request->id,
								 'nameofitem' => $request->name,
								 'description' => $request->description,
								 'quantity' => $totalQuantity,
								 'price' => $request->price];

						Session::forget('cart_item.'.$key[0]['id']);
						Session::push('cart_item.'.$request->id, $item);
						return "Add to cart successfuly";
					}	
				}
			}
		}
		else{
			Session::push('cart_item.'.$request->id, $item);
			return "Add to cart successfuly";
		}
	}
}
