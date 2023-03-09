@extends('admin.layouts.template')
@section('page_title')
    Edit SubCategory - Single Ecom
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Page/</span>Edit SubCategory</h4>
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit SubCategory</h5>
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
                    <form action="{{ route('updatesubcategory') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{$subcategory_info->category_id}}" name="oldcat_id">
                        <input type="hidden" value="{{$subcategory_info->id}}" name="subcategory_id">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">SubCategory Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="subcategory_name" name="subcategory_name"
                                    value="{{$subcategory_info->subcategory_name}}"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Select Category</label>
                            <div class="col-sm-10">
                                <select id="category_id" class="form-select" name="category_id">
                                    <option >{{$subcategory_info->category_name}}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Edit SubCategory</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
