<!-- Modal -->
<div class="modal fade" id="role-update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form action="{{ url('role/update')}}" method="POST" id="frm-update">
          <input type="hidden" id="id" class="form-control" name="id">

      	<label>Role Name</label><input type="text" id="name" name="name" class="form-control">
        <label>Assign Role</label>
        <?php $a = 0; ?>
           @foreach ($permission as $p)
           <input type="hidden" id="rpid{{ $a++ }}" name="rpid[]">
            <div class="checkbox">
              <label><input type="checkbox" value="{{$p->id}}" id="up_id[]" name="up_id[]'" class="checkbox">{{ $p->name }}</label>
            </div> 
          <?php $a++; ?>
          @endforeach
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="update">
      </div>
  </form>
    </div>
  </div>
</div>