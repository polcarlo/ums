<!-- Modal -->
<div class="modal fade" id="permission-update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form action="{{ url('permission/update')}}" method="POST" id="p-update">
          <input type="hidden" id="id" class="form-control" name="id">
      	<label>Permission Name</label><input type="text" id="name" name="name" class="form-control">
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="update">
      </div>
  </form>
    </div>
  </div>
</div>