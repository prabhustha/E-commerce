@extends('admin.layouts.template')
@section('page_title')
Edit Product - Single Ecom
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Page/</span>Edit Product</h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit Product</h5>
                <small class="text-muted float-end">Input Information</small>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div class="card-body">
                <form action="{{route('updateproduct')}}" method="POST" >
                    @csrf
                    <input type="hidden" value="{{$productinfo->product_category_id}}" name="catid">
                    <input type="hidden" value="{{$productinfo->product_subcategory_id}}" name="subcatid">
                    <input type="hidden" value="{{$productinfo->id}}" name="pid">
                    
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Product Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="product_name" name="product_name" value="{{$productinfo->product_name}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Product Price</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="price" name="price" value="{{$productinfo->price}}"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Product Quantity</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{$productinfo->quantity}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Product Short Description</label>
                        <div class="col-sm-10">
                        <textarea class="form-control" name="product_short_des" id="product_short_des" cols="30" rows="10" >{{$productinfo->product_short_des}}</textarea>   
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Product Long Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="product_long_des" id="product_long_des" cols="30" rows="10" >{{$productinfo->product_long_des}}</textarea>  
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Select Category</label>
                        <div class="col-sm-10">
                            <select id="product_category_id" class="form-select" name="product_category_id">
                              <option>{{$productinfo->product_category_name}}</option>
                              @foreach ($categories as $category)
                                  
                              
                              <option value="{{$category->id}}">{{$category->category_name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Select SubCategory</label>
                        <div class="col-sm-10">
                            <select id="product_subcategory_id" class="form-select" name="product_subcategory_id">
                              <option>{{$productinfo->product_subcategory_name}} </option>
                              @foreach ($subcategories as $subcategory)
                                  
                             
                              <option value="{{$subcategory->id}}">{{$subcategory->subcategory_name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    
                 
                   
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection