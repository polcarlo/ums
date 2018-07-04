@extends('layouts.app')

@include('permission.pAdd')
@include('permission.pUpdate')
@section('content')
<div class="container">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
 + Add Permission
</button>
<table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
   
            </tr>
        </thead>
    </table>


</div>



@endsection

@section ('footer')
      
     
       <script>

$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'permission/get_datatable',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' }
           
        ]
    });
});


       	$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
           $(document).ready(function() {
/*            $('#p-data').DataTable(
                "processing": true,
                "serverSide": true,
                "ajax": "../server_side/scripts/server_processing.php"
                );*/

        $("#p-insert").on('submit', function(e){
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
        				html: '<button type="button" class="btn btn-warning btn-sm" id="pEdit" data-id="'+data.id+'">Edit</button> <button type="button" class="btn btn-danger btn-sm" id="pDelete" data-id="'+data.id+'">Delete</button>'
        			}));
 					$('#pInfo').append(tr);
        			$('#exampleModal').modal('hide'); 

        		}

        	})
        })
             
           });

//delete
           $(document).on('click','#pDelete', function(e){
 
           		var id = $(this).data('id');

           		$.post('{{ url("permission/destroy") }}', {id:id}, function(data){
             			$("#pInfo #"+id).remove();
             		});
             });


//update

$('body').delegate('#pInfo #pEdit','click', function(e){
	var id = $(this).data('id');
	$.get("{{ url('permission/edit')}}",{id:id}, function(data){
		$("#p-update").find('#name').val(data.name);
		$("#p-update").find('#id').val(data.id);
        $('#permission-update').modal('show'); 

	})
	
});


//update

$('#p-update').on('submit', function(e){
	e.preventDefault();
	var data = $(this).serialize();
	var url = $(this).attr('action');
	$.post(url, data, function(data){
		$("#p-update").trigger('reset');
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
 					
        			$('#pInfo tr#'+data.id).replaceWith(tr);
	                $('#permission-update').modal('hide'); 
	});
});
</script>
 @endsection