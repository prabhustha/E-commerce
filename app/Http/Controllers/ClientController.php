<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function CategoryPage($id, $slug)
    {
        $category = Category::findOrFail($id);
        $products = Product::where("product_category_id", $id)->latest()->get();
        return view('user_template.category', compact('category', 'products'));
    }
    public function SingleProduct($id)
    {
        $product = Product::findOrFail($id);
        $subcat_id = Product::where('id', $id)->value('product_subcategory_id');
        $related_products = Product::where('product_subcategory_id', $subcat_id)->latest()->get();
        return view('user_template.product', compact('product', 'related_products'));
    }
    public function AddToCart()
    {
        $userid= Auth::id();
        $cart_items = Cart::where('user_id',$userid)->get();
        return view('user_template.addtocart', compact('cart_items'));
    }
    public function AddProductToCart(Request $request){
        $product_price= $request->price;
        $quantity= $request->quantity;
        $price= $product_price * $quantity;
        Cart::insert([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'quantity' => $request->quantity,
            'price' => $price
        ]);
        return redirect()->route('addtocart')->with('message','Your item added to cart successfully!');
    }
    public function DeleteItem($id){
        Cart::findOrFail($id)->delete();
        return redirect()->route('addtocart')->with('message','Item is Deleted Successfully!');
    }
    public function GetShippingAddress(){
        return view('user_template.shippingaddress');
    }
    public function AddShippingAddress(Request $request){

        $request->validate([
            'phone_number' => 'required|numeric|digits:10',
            'city_name' => 'required',
            'postal_code' => 'required'
        ]);
      
        ShippingInfo::insert([
            'user_id' => Auth::id(),
            'phone_number' => $request->phone_number,
            'city_name' => $request->city_name,	
            'postal_code' => $request->postal_code,
        ]);
        return redirect()->route('checkout');
    }
    public function CheckOut()
    {
        $userid= Auth::id();
        $cart_items=Cart::where('user_id',$userid)->get();
        $shipping_address= ShippingInfo::where('user_id',$userid)->first();
        return view('user_template.checkout',compact('cart_items','shipping_address'));
    }
    public function PlaceORder(Request $request){
        $userid=Auth::id();
        $cart_items=Cart::where('user_id',$userid)->get();
        $shipping_address=ShippingInfo::where('user_id',$userid)->first();

        foreach ($cart_items as $item){
            Order::insert([
                'user_id' => $userid,
                'shipping_phone_number' => $shipping_address->phone_number,
                'shipping_city'=> $shipping_address->city_name,
                'shipping_postal_code'=> $shipping_address->postal_code,
                'product_id'=>$item->product_id,
                'quantity'=>$item->quantity,
                'total_price'=>$item->price,
            ]);
            $id=$item->id;
            Cart::findOrFail($id)->delete();
        }
        ShippingInfo::where('user_id',$userid)->first()->delete();
        return redirect()->route('pendingorders')->with('message','Your Order Has Been Placed Successfully!');
    }
    public function UserProfile()
    {
        return view('user_template.userprofile');
    }
    public function PendingOrders()
    {
        $userid=Auth::id();
        $pending_orders=Order::where('user_id',$userid)->where('status','pending')->latest()->get();
        return view('user_template.pendingorders',compact('pending_orders'));
    }
    public function History()
    {
        return view('user_template.history');
    }
    public function NewRelease()
    {
        return view('user_template.newrelease');
    }
    public function TodaysDeal()
    {
        return view('user_template.todaysdeal');
    }
    public function CustomerService()
    {
        return view('user_template.customerservice');
    }
}
