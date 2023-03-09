<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class SubCategoryController extends Controller
{
    
    public function Index(){
        $allsubcategories= Subcategory::latest()->get();
        return view('admin.allsubcategory',compact('allsubcategories'));
    }
    public function AddSubCategory(){
        $categories= Category::latest()->get();
        return view('admin.addsubcategory',compact('categories'));
    }
    public function StoreSubCategory(Request $request){
         
        $request->validate([
            'subcategory_name'=>'required|unique:subcategories',
            'category_id'=>'required'
        ]);
      
        $category_id= $request->category_id;
        $category_name= Category::where('id',$category_id)->value('category_name');
        Subcategory::insert([
            'subcategory_name' => $request->subcategory_name,
        
            'category_id'=> $category_id,
            'category_name'=> $category_name,	
            'slug'=>strtolower(str_replace(' ','-',$request->subcategory_name))
        ]);
        Category::where('id',$category_id)->increment('subcategory_count',1);
        return redirect()->route('allsubcategory')->with('message','Sub Category Addded Successfully!');
    }
    public function EditSubCategory($id){
        $categories= Category::latest()->get();
        $subcategory_info = Subcategory::findOrFail($id);
        return view('admin.editsubcategory', compact('subcategory_info','categories'));
    }
    public function UpdateCategory(Request $request){
        $request->validate([
            'subcategory_name' => 'required|unique:subcategories',
            'category_id'=> 'required'
        ]);
        $subcat_id=$request->subcategory_id;
        $oldcategory_id=$request->oldcat_id;
        Category::where('id',$oldcategory_id)->decrement('subcategory_count',1);
        $category_id=$request->category_id;
        $category_name= Category::where('id',$category_id)->value('category_name');
        Subcategory::findOrFail($subcat_id)->update([
            'subcategory_name' => $request->subcategory_name,
            'category_id'=>$category_id,
            'category_name'=> $category_name,	
            'slug'=>strtolower(str_replace(' ','-',$request->subcategory_name))
        ]);
        Category::where('id',$category_id)->increment('subcategory_count',1);
        return redirect()->route('allsubcategory')->with('message','Sub Category Updated Successfully!');

    }
    public function DeleteSubCategory($id,$catid){
        $category_info= Category::findOrFail($catid);
        Category::where('id',$catid)->decrement('subcategory_count',1);
        Subcategory::findOrFail($id)->delete();
        return redirect()->route('allsubcategory')->with('message','SubCategory Deleted Successfully!');
    }
}
