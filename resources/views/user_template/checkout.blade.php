@extends('user_template.layouts.template');
@section('main-content')
<h2>Final Step To Place Your Order</h2>
<div class="row">
    <div class="col-8">
        <div class="box_main">
            
        <h3>Product will Send At-</h3>
        <p>City- {{$shipping_address->city_name}}</p>
        <p>Phone Number- {{$shipping_address->phone_number}}</p>
        
        <p>Postal Number- {{$shipping_address->postal_code}}</p>
        </div>
    </div>
    <div class="col-4">
        <div class="box_main">
            Your FInal Product Are-
            <div class="table-responsive">
                <table class="table">
                    <tr>
                     
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                   
                    </tr>
                    @php
                        $total=0;
                    @endphp
                    @foreach ($cart_items as $item)
                    @php
                        $product_id=$item->product_id;
                        $product_name= App\Models\Product::where('id',$product_id)->value('product_name');
                    @endphp
                        <tr>
                      
                            <td>{{$product_name}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->price}}</td>
                        </tr>

                        @php
                            $total= $total + $item->price;
                        @endphp

                    @endforeach
                    @if ($total > 0)
                    <tr>
                        
                       
                        <td></td>
                        <td>Total</td>
                        <td>{{$total}}</td>
                     
                     
                    </tr>
                    @endif
                </table>

            </div>
        </div>
    </div>
    <form action="{{route('placeorder')}}" method="POST">
        @csrf
        <input type="submit" name="" id="" value="Place Order" class="btn btn-primary mr-3">
    </form>
    
    <form action="" method="POST">
        @csrf
        <input type="submit" name="" id="" value="Cancel Order" class="btn btn-danger ">
    </form>
</div>
@endsection