<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function Index(){
        $products=Product::latest()->get();
        return view('admin.allproducts',compact('products'));
    }
    public function AddProduct(){
        $categories=Category::latest()->get();
        $subcategories= Subcategory::latest()->get();
        return view('admin.addproduct',compact('categories','subcategories'));
    }
    public function StoreProduct(Request $request){
        $request->validate([
            'product_name' => 'required|unique:products',
            'price'=> 'required',
            'quantity'=> 'required',
            'product_short_des'=> 'required',
            'product_long_des'=> 'required',
            'product_category_id'=> 'required',
            'product_subcategory_id'=> 'required',
            'product_img'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $image= $request->file('product_img');
        $img_name= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $request->product_img->move(public_path('upload'),$img_name);
        $img_url= 'upload/'.$img_name;

        $category_id= $request->product_category_id;
        $subcategory_id= $request->product_subcategory_id;

        $category_name= Category::where('id',$category_id)->value('category_name');
        $subcategory_name= Subcategory::where('id',$subcategory_id)->value('subcategory_name');
    
        Product::insert([
            'product_name' => $request->product_name,
            'product_short_des' => $request->product_short_des,
            'product_long_des' => $request->product_long_des,
            'price' => $request->price,
            'product_category_name' => $category_name,
            'product_subcategory_name' => $subcategory_name,
            'product_category_id' => $request->product_category_id,
            'product_subcategory_id' => $request->product_subcategory_id,
            'quantity' => $request->quantity,
            'product_img' =>   $img_url,
            'slug'=> strtolower(str_replace(' ','-',$request->product_name))

        ]);

        Category::where('id',$category_id)->increment('product_count',1);
        SubCategory::where('id',$subcategory_id)->increment('product_count',1);

        return redirect()->route('allproducts')->with('message','Product Added Successfully!');
    }

    public function EditProductImg($id){
        $productinfo= Product::findOrFail($id);
        return view('admin.editproductimg',compact('productinfo'));
    }
    public function UpdateProductImg(Request $request){
        $request->validate([
            'product_img'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $id= $request->id;

        $image= $request->file('product_img');
        $img_name= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $request->product_img->move(public_path('upload'),$img_name);
        $img_url= 'upload/'.$img_name;

        Product::findOrFail($id)->update([
            'product_img'=> $img_url,
        ]);
        
        return redirect()->route('allproducts')->with('message','Product Image Added Successfully!');
        
    }
    public function EditProduct($id){
        $categories= Category::latest()->get();
        $subcategories= Subcategory::latest()->get();
        $productinfo= Product::findOrFail($id);
        return view('admin.editproduct',compact('productinfo','categories','subcategories'));
    }
    public function UpdateProduct(Request $request){
        $request->validate([
            'product_name' => 'required|unique:products',
            'price'=> 'required',
            'quantity'=> 'required',
            'product_short_des'=> 'required',
            'product_long_des'=> 'required',
            'product_category_id'=> 'required',
            'product_subcategory_id'=> 'required',
        ]);
       
        $oldcatid= $request->catid;
        $oldsubcatid= $request->subcatid;
        Category::where('id',$oldcatid)->decrement('product_count',1);
        SubCategory::where('id',$oldsubcatid)->decrement('product_count',1);
       

        $catid= $request->product_category_id;
        $subcatid= $request->product_subcategory_id;
        $cat_name= Category::where('id', $catid)->value('category_name');
        $subcat_name= SubCategory::where('id', $subcatid)->value('subcategory_name');
        
        $pid=$request->pid;
    
        Product::findOrFail($pid)->update([
            'product_name' => $request->product_name,
            'product_short_des' => $request->product_short_des,
            'product_long_des' => $request->product_long_des,
            'price' => $request->price,
            'product_category_name' => $cat_name,
            'product_subcategory_name' => $subcat_name,
            'product_category_id' => $request->product_category_id,
            'product_subcategory_id' => $request->product_subcategory_id,
            'quantity' => $request->quantity,
            'slug'=> strtolower(str_replace(' ','-',$request->product_name))
        ]);
       

        Category::where('id',$catid)->increment('product_count',1);
        SubCategory::where('id',$subcatid)->increment('product_count',1);

        return redirect()->route('allproducts')->with('message','Product Updated Successfully!');

    }

    public function DeleteProduct($id,$catid,$subcatid){
        $category_info= Category::findOrFail($catid);
        Category::where('id',$catid)->decrement('product_count',1);
        $subcategory_info= SubCategory::findOrFail($subcatid);
        SubCategory::where('id',$subcatid)->decrement('product_count',1);
        Product::findOrFail($id)->delete();
        return redirect()->route('allproducts')->with('message','Product Deleted Successfully!');
    }
}
