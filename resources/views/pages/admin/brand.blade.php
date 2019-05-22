@extends('layouts.default')
@section('content')
  <div class="users-table">
     <div class="table-top-links pull-right">
        <a href="" class="btn btn-default btn-icon" data-toggle="modal" data-target="#myModal">
        Add Brand
        <i class="entypo-list-add"></i>
        </a>
        <!-- Modal for Create -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form method="POST" action="{{ route('brand.add') }} " id ="addCategory">
                {{ csrf_field() }}
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="addChargeModal">Add Brand</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control"  name="name" placeholder="Brand Name" required>
                      </div>
                  </div><br>
                </div>
                <div class="modal-footer">
                  <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" form="addCategory" class="btn btn-info">Create</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- End Modal for Create -->
     </div>
     <h3>Brand Table</h3>
     <br>
     <table class="table table-bordered responsive" id="table-2">
        <thead>
           <tr>
              <th>Brand Name</th>
              <th>Status</th>
              <th>Created</th>
              <th>Actions</th>
           </tr>
        </thead>
        <tbody>
          <?php foreach ($brandList as $brand) { ?>
            <tr>
               <td>{{ ucfirst($brand->name) }}</td>
               <td>{{ ($brand->status) == 1 ? 'Active' : 'Inactive' }}</td>
               <td>{{ $brand->created_at }}</td>
               <td>
                 <a href="#" data-toggle="modal" data-target="#update_category{{$brand->id}}">
                    <button type="button" class="btn btn-info btn-xs">Edit</button>
                </a>
                <a href="#" data-toggle="modal" data-target="#delete_category{{$brand->id}}">
                   <button type="button" class="btn btn-danger btn-xs">Delete</button>
               </a>
               </td>
            </tr>

            <!-- Modal for Update -->
            <div class="modal fade" id="update_category{{$brand->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{ route('brand.update') }}" id ="updateBrandForm{{$brand->id}}">
                    <input type="hidden" value="{{$brand->id}}" name="id">
                    {{ csrf_field() }}
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="addChargeModal">Update Category</h4>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                          <label class="col-sm-3 control-label"> Name</label>
                          <div class="col-sm-9">
                            <input type="text" value="{{$brand->name}}" class="form-control"  name="name" placeholder="Category Name" required>
                          </div>
                      </div><br>
                    </div>
                    <div class="modal-footer">
                      <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" form="updateBrandForm{{$brand->id}}" class="btn btn-info">Save changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- End Modal for Update -->

            <!-- Modal for Delete -->
            <div class="modal fade" id="delete_category{{$brand->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{ route('brand.delete') }} " id ="deleteBrandForm{{$brand->id}}">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{$brand->id}}" name="id">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="addChargeModal">Are you sure you want to Delete {{ucfirst($brand->name)}}</h4>
                    </div>
                    <div class="modal-footer">
                      <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" form="deleteBrandForm{{$brand->id}}" class="btn btn-info">Delete</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- End Modal for Delete -->
          <?php } ?>
        </tbody>
     </table>
    {{ $brandList->links() }}
  </div>

@stop
