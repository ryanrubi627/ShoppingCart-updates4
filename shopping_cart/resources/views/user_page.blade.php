@extends('layouts.app_shoppingCart')

@section('user')
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
                    	<a class="dropdown-item" onclick="window.location='{{ url("/cart_page") }}'">My Cart</a>
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
<div class="container-fluid">
	<div class="row">
		<div class="col-md-2">
		</div>
		<div class="col-md-8">
			<div class="row">
				@foreach($items as $item)
				<div class="col-md-4">
					<div class="card">
						<img class="card-img-top" alt="Bootstrap Thumbnail First" src="/images/{{ $item->image }}" id="{{ $item->id }}">
						<div class="card-block" style="margin:20px">
							<center>
								<h5 hidden>{{ $item->id }}</h5>
								<h5 class="card-title">{{ $item->nameofitem }}</h5>
								<p>{{ $item->quantity }}&nbsp pcs available</p>
								<h5 style="color:rgb(242,103,49);">{{ $item->price }} PHP</h5>
								<button type="button" class="btn btn-primary buy_item" id="{{ $item->id }}" hidden>Buy Now</button>
								<button type="button" class="btn btn-primary cart_item" id="{{ $item->id }}">Add to Cart</button>
							</center>
						</div>
					</div>
				</div>
				@endforeach
		<div class="col-md-2">
		</div>
	</div>
</div>
<br><br>
</body>
</html>


<!--------------------------------BUY ITEM MODAL-------------------------------->
<div class="modal fade" id="buy_item_modal" name="buy_item_modal" role="dialog">
	<div class="modal-dialog">
	  <!--Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
	      <h5 id="h1"></h5>
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	    </div>
	    <div class="modal-body">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
					<div class="card">
						<img class="card-img-top img_item" alt="Bootstrap Thumbnail First">
						<div class="card-block" style="margin:20px">
							<center><input type="text" name="item_id" id="item_id" hidden>
							<i id="i1"></i><br><br></center>
							<hr>
							<input type="number" class="form-control prc" id="item_quantity" maxlength="2" hidden/>
							Quantity:<input type="number" class="form-control prc" id="quantity" maxlength="2"/>
							Price:<input type="number" class="form-control prc" id="item_price" disabled/>
							Total:<input type="number" class="form-control prc" id="item_result" disabled/><br>
							<button type="button" style="float:right;"class="btn btn-primary" id="buy_item">Buy Now</button>
						</div>
					</div>
					</div>
				</div>
			</div>
	    </div>
	  </div>  
	</div>
</div>
<!--------------------------------CART ITEM MODAL-------------------------------->
<div class="modal fade" id="cart_item_modal" name="cart_item_modal" role="dialog">
	<div class="modal-dialog">
	  <!--Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	    </div>
	    <div class="modal-body">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<form form enctype="multipart/form-data" id="insert_cart_data">
								{{ csrf_field() }}
								<img class="card-img-top img_cart_item" alt="Bootstrap Thumbnail First">
								<div class="card-block" style="margin:20px">
									<center>
										<h5 id="h2" name="h2"></h5>
										<input type="text" name="item_cart_id" id="item_cart_id" hidden/>
										<i id="i2" name="i2"></i><br><br>
										<input type="number" class="form-control prc" id="item_quantityy" hidden/>
										</center>
										<hr>
										Enter Quantity:<input type="number" class="form-control prc" name="item_cart_quantity2" id="item_cart_quantity2" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
										Price:<input type="number" class="form-control prc" name="item_cart_price2" id="item_cart_price2" disabled/>
										<h5 style="color:rgb(242,103,49);" id="item_cart_price" name="item_cart_price" hidden></h5><br>
										@can('can add to cart')
											<button type="button" class="btn btn-primary cart-item" id="cart-item" style="float:right">Add to Cart</button><br><br>
										@endcan
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
	    </div>
	  </div>  
	</div>
</div>
<!------------------------------------------------------------------------------->

<script>
$(document).ready(function(){

	//FETCH DATA TO MODAL..
	$('.buy_item').on('click', function(){
		let id = this.id;

        $.ajax({
           type:'get',
           url:'/user_page/item_id',
           data:{
                id:id
            },
           success:function(data){
           		$('#h1').text(data.nameofitem);
           		$('#item_id').val(data.id);
           		$('#i1').text(data.description);
           		$('#item_quantity').val(data.quantity);
           		$('#item_price').val(data.price);
           		$(".img_item").attr('src', '/images/'+data.image); 
           		$('#buy_item_modal').modal('show');
           }
        });
	});

    //FETCH DATA TO MODAL CART..
	$('.cart_item').on('click', function(){
		let id = this.id;

        $.ajax({
           type:'get',
           url:'/user_page/item_cart_id',
           data:{
                id:id
            },
           success:function(data){
           		$('#h2').text(data.nameofitem);
           		$('#item_cart_id').val(data.id);
           		$('#i2').text(data.description);
           		$('#item_quantityy').val(data.quantity);
           		$('#item_cart_quantity').text(data.quantity);
           		// $('#item_cart_quantity2').val(data.quantity);
           		$('#item_cart_price').text(data.price);
           		$('#item_cart_price2').val(data.price);
           		$(".img_cart_item").attr('src', '/images/'+data.image); 
           		$('#cart_item_modal').modal('show');
           }
        });
	});

	//ADD ITEM IN SESSION..
	$('#cart-item').on('click', function(){
		let id = $('#item_cart_id').val();
		let name = $('#h2').text();
   		let description = $('#i2').text();
   		let quantity = $('#item_cart_quantity2').val();
   		let item_quantity = $('#item_quantityy').val();
   		let price = $('#item_cart_price2').val();

   		if(quantity == ''){
   			alert('Enter your quantity');
   		}else if(quantity != item_quantity && quantity >= item_quantity){
			alert('Out of stock');
		}else {
	   		$.ajax({
	           type:'POST',
	           url:'/user_page/add_to_cart',
		       data: {
		       		id,
		       		name,
		       		description,
		       		quantity,
		       		price
		       },
	           success:function(data){
	           	console.log(data);
	           	alert(data);
	           	$('#cart_item_modal').modal('hide');
	           },
	           error:function(data){

	           	alert(data);
	           }
	        });
   		}
	});
});
</script>
@endsection