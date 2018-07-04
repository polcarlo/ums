@extends ('layouts.app')

@include('user/updateUser')
@section ('content')


<div class="container">
	<a href="{{ url('/register') }}" class="btn btn-primary">+ Add Users</a>

<table class="table table-dark">
	<tr>
		<th colspan="3">Users</th>
	</tr>
<tr>
	<td>Id</td>
	<td>Name</td>
	<td>Email</td>
	<td>Role</td>
	<td>Action</td>
</tr>
<tbody id="userInfo">
@foreach($users as $user)
<tr id="{{ $user->id }}">
	<td>{{$user->id}}</td>
	<td>{{$user->name}}</td>
	<td>{{$user->email}}</td>
	<td>{{$user->role_name}}</td>

	<td>
		<button type="button" class="btn btn-warning btn-sm" id="userEdit" data-id="{{$user->id }}">Edit</button>
		
		<button type="button" class="btn btn-danger btn-sm" id="userDelete" data-id="{{$user->id }}">Delete</button>
	</td>
</tr>
@endforeach 
</tbody>
</table>
</div>




@endsection



@section('footer')

<script>

	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).on('click','#userDelete', function(e){
	var id = $(this).data('id');
	$.post('{{ url("/users/destroy") }}',{id:id}, function(data){
		$("#userInfo #"+id).remove();
	});
});

//edit

$('body').delegate('#userInfo #userEdit', 'click', function(e){
	var id = $(this).data('id');
	
	$.get("{{ url('users/edit')}}",{id:id}, function(data){
		console.log(data.role.name);
		$("#frm-userUpdate").find('#password').val('');
		$("#frm-userUpdate").find('#password-confirm').val('');
		$("#frm-userUpdate").find('#name').val(data.role.name);
		$("#frm-userUpdate").find('#id').val(data.role.id);
		$("#frm-userUpdate").find('#email').val(data.role.email);
		//$('#roles').append('<option value="'+ data.role.role_id +'" selected="selected">'+data.role.role_name+'</option>'); 	
		$('.checkbox').prop('checked', false); 
	//	console.log(data.role2[1].id);
	    console.log(data.role2);
	    for (var i = 0; i < data.cr; i++) { 
    	      var b = $("input[value='"+data.role2[i].id+"']").val();
        	if(data.role2[i].id == b){
       			 $(':checkbox[value="'+data.role2[i].id+'"]').prop("checked","true");
       		}
    	}   
		 $('#user-update').modal('show'); 

	});

	$.get("{{ url('users/roles_details')}}",{id:id}, function(data){

				 $('#user-update').modal('show'); 

	});

	
});
//update

$('#frm-userUpdate').on('submit', function(e){
	e.preventDefault();
	var data = $(this).serialize();
	var url = $(this).attr('action');

	$.post(url, data, function(data){
		console.log(data);
		$("#frm-update").trigger('reset');
        			var tr = $('<tr/>',{
					id : data.id
					});
        			tr.append($('<td/>',{
        				text: data.id
        			})).append($('<td/>',{
        				text: data.name
        			})).append($('<td/>',{
        				text: data.email
        			})).append($('<td/>',{
        				text: data.role_id
        			})).append($('<td/>',{
        				html: '<button type="button" class="btn btn-warning btn-sm" id="userEdit" data-id="'+data.id+'">Edit</button> <button type="button" class="btn btn-danger btn-sm" id="userDelete" data-id="'+data.id+'">Delete</button>'
        			}));
 					
        			$('#userInfo tr#'+data.id).replaceWith(tr);
        			 $('#user-update').modal('hide'); 
	});
});

</script>

@endsection