<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form action="{{ url('role/store') }}" method="POST" id="frm-insert">
      	<label>Role Name</label><input type="text" id="name" name="name" class="form-control">

        <label>Assign Permission</label>
 
          @foreach ($permission as $p)
            <div class="checkbox">
              <label><input type="checkbox" value="{{$p->id}}" id="p_id[]" name="p_id[]'">{{ $p->name }}</label>
            </div>
          

          @endforeach
        </select>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" id="roleAdd" class="btn btn-primary" value="Add">
      </div>
  </form>
    </div>
  </div>
</div>