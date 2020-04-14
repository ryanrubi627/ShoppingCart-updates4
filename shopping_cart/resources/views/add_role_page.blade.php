@extends('layouts.app_shoppingCart')

@section('add_role_page')
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto nav">
			<li class="nav-item">
				<a class="nav-link active" href="{{ url('/superAdmin_page') }}">Manage Account</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ url('/add_role_page') }}">Add Role</a>
			</li>
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
                    	<a class="dropdown-item" onclick="window.location='{{ url("/admin_page") }}'">Admin page</a>
                    	<a class="dropdown-item" onclick="window.location='{{ url("/user_page") }}'">User page</a>
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
		<div class="col-md-1">
		</div>
		<div class="col-md-10">
			<div class="card">
				<h5 class="card-header">
					<a href="#" class="btn btn-success" id="create_new_role">Add role</a>
				</h5>
				<div class="card-body">
					<table class="table table-bordered table-hover" style="table-layout: fixed;" id="myTable">
						<thead>
							<tr>
								<th hidden>ID</th>
								<th>Role</th>
								<th>Permissions</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($roles as $role)
							<tr>
								<td hidden>{{ $role->id }}</td>
								<td>{{ $role->name }}</td>
								<td>
									@foreach($role->permissions as $permission)
										<li class="list-item">
											{{ $permission->name }}<br>
										</li>
									@endforeach
								</td>
								<td>
									<a href="#" class="btn btn-primary edit_btn">Edit</a>
									<a href="#" class="btn btn-primary delete_btn" id="{{ $role->id }}">Delete</a>
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

<!--------------------------ADD ROLE MODAL-------------------------->
<div class="modal fade" id="add_role_modal" role="dialog">
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
							<form>
								{{ csrf_field() }}
								<div class="form-group">
									<label>Role:</label>
									<input type="text" class="form-control" name="role" id="role"/>
								</div>
								<div class="form-group" id="role_permission">
									<label>Permission:</label><br>
								    <label class="checkbox-inline">
								    	<input type="checkbox" name="checkbox[]" value="1">can add item
								    </label><br>
								    <label class="checkbox-inline">
								    	<input type="checkbox" name="checkbox[]" value="2">can edit item
								    </label><br>
								    <label class="checkbox-inline">
								    	<input type="checkbox" name="checkbox[]" value="3">can delete item
								    </label><br>
								    <label class="checkbox-inline">
								    	<input type="checkbox" name="checkbox[]" value="4">can add to cart
								    </label><br>
								    <label class="checkbox-inline">
								    	<input type="checkbox" name="checkbox[]" value="5">can checkout item
								    </label>
								</div>
							    <hr>
								<button type="submit" id="add_role" class="btn btn-primary" style="float:right">Add</button><br>
							</form>
						</div>
					</div>
				</div>
	        </div>
      	</div>  
    </div>
</div>
<!----------------------------EDIT MODAL---------------------------->

  <div class="modal fade" id="edit_role_modal" role="dialog">
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
						<form>
							{{ csrf_field() }}
							<div class="form-group">
								<label>ID:</label>
								<input type="text" class="form-control" name="id" id="id"/>
							</div>
							<div class="form-group">
								<label>Role:</label>
								<input type="text" class="form-control" name="edt_role" id="edt_role"/>
							</div>
							<div class="form-group">
								<label>Permission:</label><br>
							    <label class="checkbox-inline">
							    	<input type="checkbox" name="checkbox[]" value="1">can add item
							    </label><br>
							    <label class="checkbox-inline">
							    	<input type="checkbox" name="checkbox[]" value="2">can edit item
							    </label><br>
							    <label class="checkbox-inline">
							    	<input type="checkbox" name="checkbox[]" value="3">can delete item
							    </label><br>
							    <label class="checkbox-inline">
							    	<input type="checkbox" name="checkbox[]" value="4">can add to cart
							    </label><br>
							    <label class="checkbox-inline">
							    	<input type="checkbox" name="checkbox[]" value="5">can checkout item
							    </label>
							</div>
							<hr>
							<button type="submit" id="update_role" class="btn btn-primary" style="float:right">Update</button><br><br>
						</form>
					</div>
				</div>
			</div>
        </div>
      </div>  
    </div>
  </div>


<script>
$(document).ready(function(){

	//OPEN ADD ROLE MODAL..
	$('#create_new_role').on('click', function(){
		$('#add_role_modal').modal('show'); 
	});

	//ADD NEW ROLE..
	$('#add_role').on('click', function(e){
		e.preventDefault();

		let role = $('#role').val();

		//GET THE CHECKED OF THE CHECKEDBOX..
		let role_permission = [];
        $(':checkbox:checked').each(function(i){
          role_permission[i] = $(this).val();
        });

        $.ajax({
           type:'POST',
           url:'/add_role_page/add_role',
           data:{
           		role,
           		role_permission
           },
           success:function(){
           	alert('Add role Successfuly');
           	location.reload(true);
           }
        });
	});

	//RETRIEVE DATA FROM TABLE TO MODAL..
	$('.edit_btn').on('click', function(){
		$('#edit_role_modal').modal('show'); 

		let tr = $(this).closest('tr');

		let data = tr.children("td").map(function(){
			return $(this).text();
		}).get();

		$('#id').val(data[0]);
		$('#edt_role').val(data[1]);
	});

	//UPDATE ROLE..
	$('#update_role').on('click', function(e){
		e.preventDefault();

		let id = $('#id').val();
		let role = $('#edt_role').val();

		let edt_permission = [];
        $(':checkbox:checked').each(function(i){
          edt_permission[i] = $(this).val();
        });

        $.ajax({
           type:'POST',
           url:'/add_role_page/update_role',
           data:{
           		id,
           		role,
           		edt_permission
           },
           success:function(){
           		alert("Update Successfuly");
           		$('#edit_role_modal').modal('hide');
           		location.reload(true);
           }
        });
	});

	//DELETE USER..
	$(".delete_btn").click(function(){
		let id = this.id;

	    if(confirm("Are you sure you want to delete this?")){
	        alert('Role Successfuly Deleted');

	        $.ajax({
	           type:'POST',
	           url:'/add_role_page/delete_role',
	           data:{id},
	           success:function(){
           		location.reload(true);
           	  }
        	});

	    }
	    else{
	        return false;
	    }
	});

	//DATA TABLE..
	$('#myTable').DataTable();

});
</script>
@endsection