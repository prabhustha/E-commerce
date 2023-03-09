@extends('user_template.layouts.user_profile_template')
@section('main-content')
    <h2>Provide Your Shipping Information</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="row">
        <div class="col-12">
            <div class="box_main"> 
                <form action="{{route('addshippingaddress')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="number" name="phone_number" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="city_name">City</label>
                        <input type="text" name="city_name" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Postal Code</label>
                        <input type="number" name="postal_code" id="" class="form-control">
                    </div>
                    <input type="submit" value="Next" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
@endsection
