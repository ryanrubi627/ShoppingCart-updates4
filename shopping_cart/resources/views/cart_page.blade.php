@extends('layouts.app_shoppingCart')

@section('cart')
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">

        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    	@role('super admin')
                    		<a class="dropdown-item" onclick="window.location='{{ url("/superAdmin_page") }}'">Super admin page</a>
                    	@endrole
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
<br>

@if(Session::exists('cart_item'))
<div class="container-fluid">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="card">
				<h5 class="card-header">
					<button type="button" class="btn btn-success" id="open_add_product_modal" onclick="window.location='{{ url("/user_page") }}'">Back to Shop</button>
				</h5>
				<div class="card-body">
					<table class="table table-bordered table-hover myTable" style="table-layout: fixed;">
						<thead>
							<tr>
								<th hidden>ID</th>
								<th>Name of Item</th>
								<th>Description</th>
								<th>quantity</th>
								<th hidden>Price</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						{{-- {{ dd(Session::get('cart_item')) }} --}}
						@foreach(Session::get('cart_item') as $cart_item)
							<tr>
								<td hidden>{{ $cart_item[0]['id'] }}</td>
								<td>{{ $cart_item[0]['nameofitem'] }}</td>
								<td>{{ $cart_item[0]['description'] }}</td>
								<td>{{ $cart_item[0]['quantity'] }}</td>
								<td hidden>{{ $cart_item[0]['price'] }}</td>
								<td>
									<a href="#" class="btn btn-primary buy-item">Buy</a>
									<a href="#" class="btn btn-primary remove" id="{{ $cart_item[0]['id'] }}" >Remove</a>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-1">
		</div>
	</div>
</div>
@else
<div class="container-fluid">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="card">
				<h5 class="card-header">
					<button type="button" class="btn btn-success" id="open_add_product_modal" onclick="window.location='{{ url("/user_page") }}'">Go to Shop</button>
				</h5>
				<div class="card-body">
					<table class="table table-bordered table-hover myTable" style="table-layout: fixed;">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name of Item</th>
								<th>Description</th>
								<th>quantity</th>
								<th>Price</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-1">
		</div>
	</div>
</div>
@endif
<!--------------------------------ADD ITEM MODAL-------------------------------->
<div class="modal fade" id="item_cart_modal" role="dialog">
<div class="modal-dialog">
  <!--Modal content-->
  <div class="modal-content">
    <div class="modal-header">
    <h5 id="h2"></h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h5 name="item_id" id="item_id" hidden></h5>
					<div class="card">
						<img class="card-img-top img_cart_item" alt="Bootstrap Thumbnail First" src="">
						<div class="card-block" style="margin:20px">
							<center><i id="i2"></i><br><br>
							<p id="quantity_avail"></p></center>
							<hr>
							<input type="number" class="form-control prc" id="item_cart_quantity" maxlength="2" hidden/>
							Quantity:<input type="number" class="form-control prc" id="cart_quantity" maxlength="2" disabled/>
							Price:<input type="number" class="form-control prc" id="item_cart_price" disabled/>
							Total:<input type="number" class="form-control prc" id="item_cart_result" disabled/><br>
							@can('can checkout item')
								<button type="button" style="float:right;"class="btn btn-primary" id="buy_item">Check Out</button>
							@endcan
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
  </div>  
</div>
</div>
<!------------------------------------------------------------------------------>

<script>
$(document).ready(function(){

	//DATA TABLE..
    $('.myTable').DataTable();

    //RETRIEVING ITEM_ID FROM TABLE..
	$('.buy-item').on('click', function(){
		$('#item_cart_modal').modal('show');

		let tr = $(this).closest('tr');

		let data = tr.children("td").map(function(){
			return $(this).text();
		}).get();

		$('#item_id').text(data[0]);
		$('#cart_quantity').val(data[3]);
		$('#item_cart_price').val(data[4]);

		let item_id = $('#item_id').text()

		$.ajax({
           type:'POST',
           url:'/cart_page/item_id',
	       data:{
	       		item_id:item_id
	       },
           success:function(data){
           		$('#quantity_avail').text(data.quantity+' pcs available');
           		$('#h2').text(data.nameofitem);
           		$('#i2').text(data.description);
           		$('#item_cart_quantity').val(data.quantity);
           		//$('#item_cart_price').val(data.price);
           		$(".img_cart_item").attr('src', '/images/'+data.image); 
           }
        });

	});


	//COMPUTATION OF QUANTITY & PRICE..
	function comp(){
		let quantity = $('#cart_quantity').val();
		let item_price = $('#item_cart_price').val();

		let result = quantity * item_price;
		let item_result = $('#item_cart_result').val(result);
	}
	$("#buy_item").mouseenter(function() {
        comp();
    });

    $('#buy_item').on('click', function(){

    	let id = $('#item_id').text();
		let item_quantity = $('#item_cart_quantity').val();
		let quantity = $('#cart_quantity').val();

		let result_quantity = item_quantity - quantity;

        $.ajax({
           type:'post',
           url:'/cart_page/quantity_update',
           data:{
           		id:id,
           		result_quantity:result_quantity
           },
           success:function(){
           		alert('Successfully purchase this item');
           		$('#item_cart_modal').modal('hide');
	        	location.reload(true);
	        }
		});
	});

	//REMOVE DATA FROM CART
	$('.remove').on('click', function(){
		var id = this.id;

		var delete_confirmation = confirm("Are you sure you want to delete this?");
	    if(delete_confirmation == true){
	        alert('Successfuly Deleted Item');

		    $.ajax({
		       type:'get',
		       url:'/cart/remove',
		       data:{
		       		id:id
	       	   },
	       	   success:function(data){
	       	   		location.reload(true);
		        }

	       	});
	    }
	});
});
</script>
@endsection