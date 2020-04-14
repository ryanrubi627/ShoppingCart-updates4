
$(document).ready(function(){

    $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
    }); 
    
	//DATA TABLE..
	$('#myTable').DataTable()

	//OPEN INSERT ITEM MODAL..
	$('#open_add_product_modal').on('click', function(){
		$('#add_item_modal').modal('show'); 
	});

   	//INSERT ITEM..
	$('#insert_data').submit(function(){
		CKEDITOR.instances['description'].updateElement();
		let formData = new FormData(this);
		
        $.ajax({
           type:'POST',
           url:'/admin_page/add_item',
           data: formData,
           cache: false,
           contentType: false,
           processData: false,
           success:function(data){
           }
        });
	});

	//RETRIEVING DATA FROM TABLE..
	$('.edtbtn').on('click', function(){
		$('#edit_item_modal').modal('show');

		let tr = $(this).closest('tr');

		let data = tr.children("td").map(function(){
			return $(this).text();
		}).get();

		$('#edt_id').val(data[0]);
		$('#edt_nameofitem').val(data[1]);
		$('#edt_description').val(data[2]);
		$('#edt_quantity').val(data[3]);
		$('#edt_price').val(data[4]);
	});

	//UPDATE ITEM..
	$("#form_update_item").submit(function(){

		let formData = new FormData(this);
		
        $.ajax({
           type:'POST',
           url:'/admin_page/update_item',
           data: formData,
           cache: false,
           contentType: false,
           processData: false,
           success:function(){
           	location.reload(true);
           }
        });
	});

	//DELETE CONFIRMATION..
	$(".delete_btn").click(function(){
		var delete_confirmation = confirm("Are you sure you want to delete this?");
	    if(delete_confirmation == true){
	        alert('Successfuly Deleted Item');
	    }
	    else{
	        return false;
	    }
	});


});

