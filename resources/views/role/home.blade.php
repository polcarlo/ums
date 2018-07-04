@extends('layouts.app')

@include('role.add')
@include('role.update')
@section('content')
<div class="container">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
 + Add Roles
</button>
<table class="table table-dark">
	<tr>
		<th colspan="3">Roles</th>
	</tr>
<tr>
	<td>Id</td>
	<td>Name</td>
	<td>Action</td>
</tr>
<tbody id="roleInfo">
@foreach($roles as $role)
<tr id="{{ $role->id }}">
	<td>{{$role->id}}</td>
	<td>{{$role->name}}</td>
    
	<td>
		<button type="button" class="btn btn-warning btn-sm" id="roleEdit" data-id="{{$role->id }}">Edit</button>
		
		<button type="button" class="btn btn-danger btn-sm" id="roleDelete" data-id="{{$role->id }}">Delete</button>
	</td>
</tr>
@endforeach 
</tbody>
</table>
</div>



@endsection

@section ('footer')
      
     
       <script>
       	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
           $(document).ready(function() {

        $("#frm-insert").on('submit', function(e){
        	e.preventDefault();
        	var data = $(this).serialize();
        	var url = $(this).attr('action');
        	var post = $(this).attr('method');

        	$.ajax({
        		type: post,
        		url: url,
        		data: data,
        		dataType: 'json',
        		success:function (data)
        		{
        			console.log(data);
        			var tr = $('<tr/>',{
					id : data.id
					});
        			tr.append($('<td/>',{
        				text: data.id
        			})).append($('<td/>',{
        				text: data.name
        			})).append($('<td/>',{
        				html: '<button type="button" class="btn btn-warning btn-sm" id="roleEdit" data-id="'+data.id+'">Edit</button><button type="button" class="btn btn-danger btn-sm" id="roleDelete" data-id="'+data.id+'">Delete</button>'
        			}));
 					

        			$('#roleInfo').append(tr);
        			$('#exampleModal').modal('hide'); 
        		}

        	})
        })
             
           });

//delete
           $(document).on('click','#roleDelete', function(e){
 
           		var id = $(this).data('id');
           		$.post('{{ url("role/destroy") }}', {id:id}, function(data){
             			$("#roleInfo #"+id).remove();
             		});
             });


//update

$('body').delegate('#roleInfo #roleEdit','click', function(e){
	var id = $(this).data('id');
   // / console.log(id);
	$.get("{{ url('role/edit')}}",{id:id}, function(data){
   // console.log(data.role);

   //console.log(data.role2[1].id);

		$("#frm-update").find('#name').val(data.role.name);
		$("#frm-update").find('#id').val(data.role.id);
    //    var check = [];
     $('.checkbox').prop('checked', false); 


       
    for (var i = 0; i < data.cr; i++) { 
     //   console.log(data.role2[i].id);
        var b = $("input[value='"+data.role2[i].id+"']").val();

         $("#frm-update").find('#rpid'+i).val(data.role2[i].rpid);    
        if(data.role2[i].id == b){
        $(':checkbox[value="'+data.role2[i].id+'"]').prop("checked","true");
       }
    }       
   //  $(':checkbox[data-id="2"]').prop("checked","true");
		 $('#role-update').modal('show'); 
     


	});
	
});


//update

$('#frm-update').on('submit', function(e){
	e.preventDefault();
	var data = $(this).serialize();
	var url = $(this).attr('action');
	$.post(url, data, function(data){
		$("#frm-update").trigger('reset');
        			var tr = $('<tr/>',{
					id : data.id
					});
        			tr.append($('<td/>',{
        				text: data.id
        			})).append($('<td/>',{
        				text: data.name
        			})).append($('<td/>',{
        				html: '<button type="button" class="btn btn-warning btn-sm" id="roleEdit" data-id="'+data.id+'">Edit</button> <button type="button" class="btn btn-danger btn-sm" id="roleDelete" data-id="'+data.id+'">Delete</button>'
        			}));
 					
        			$('#roleInfo tr#'+data.id).replaceWith(tr);
        			 $('#role-update').modal('hide'); 
	});
});





       </script>
       @endsection