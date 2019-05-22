@extends('layouts.default')
@section('content')
  <div class="users-table">
     <div class="table-top-links pull-right">
        <a href="" class="btn btn-default btn-icon" data-toggle="modal" data-target="#myModal">
        Add Generic
        <i class="entypo-list-add"></i>
        </a>
        <!-- Modal for Create -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form method="POST" action="{{ route('generic.add') }} " id ="addGeneric">
                {{ csrf_field() }}
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="addChargeModal">Add Generic</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control"  name="name" placeholder="Generic Name" required>
                      </div>
                  </div><br>
                </div>
                <div class="modal-footer">
                  <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" form="addGeneric" class="btn btn-info">Create</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- End Modal for Create -->
     </div>
     <h3>Generics Table</h3>
     <br>
     <table class="table table-bordered responsive" id="table-2">
        <thead>
           <tr>
              <th>Generic Name</th>
              <th>Status</th>
              <th>Created</th>
              <th>Actions</th>
           </tr>
        </thead>
        <tbody>
          <?php foreach ($genericList as $generic) { ?>
            <tr>
               <td>{{ ucfirst($generic->name) }}</td>
               <td>{{ ($generic->status) == 1 ? 'Active' : 'Inactive' }}</td>
               <td>{{ $generic->created_at }}</td>
               <td>
                 <a href="#" data-toggle="modal" data-target="#update_generic{{$generic->id}}">
                    <button type="button" class="btn btn-info btn-xs">Edit</button>
                </a>
                <a href="#" data-toggle="modal" data-target="#delete_generic{{$generic->id}}">
                   <button type="button" class="btn btn-danger btn-xs">Delete</button>
               </a>
               </td>
            </tr>

            <!-- Modal for Update -->
            <div class="modal fade" id="update_generic{{$generic->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{ route('generic.update') }}" id ="updateGenericForm{{$generic->id}}">
                    <input type="hidden" value="{{$generic->id}}" name="id">
                    {{ csrf_field() }}
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="addChargeModal">Update Generic</h4>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                          <label class="col-sm-3 control-label"> Name</label>
                          <div class="col-sm-9">
                            <input type="text" value="{{$generic->name}}" class="form-control"  name="name" placeholder="Generic Name" required>
                          </div>
                      </div><br>
                    </div>
                    <div class="modal-footer">
                      <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" form="updateGenericForm{{$generic->id}}" class="btn btn-info">Save changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- End Modal for Update -->

            <!-- Modal for Delete -->
            <div class="modal fade" id="delete_generic{{$generic->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{ route('generic.delete') }} " id ="deleteGenericForm{{$generic->id}}">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{$generic->id}}" name="id">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="addChargeModal">Are you sure you want to Delete {{ucfirst($generic->name)}}</h4>
                    </div>
                    <div class="modal-footer">
                      <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" form="deleteGenericForm{{$generic->id}}" class="btn btn-info">Delete</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- End Modal for Delete -->
          <?php } ?>
        </tbody>
     </table>
    {{ $genericList->links() }}
  </div>
@stop
