@extends('layouts.default')
@section('content')

      <div class="users-table">
         <div class="table-top-links pull-right">
            <a href="" class="btn btn-default btn-icon" data-toggle="modal" data-target="#myModal">
            Add Suppliers
            <i class="entypo-list-add"></i>
            </a>
            <!-- Modal for Create -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{ route('supplier.add') }} " id ="addSupplier">
                    {{ csrf_field() }}
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="addChargeModal">Add Suppliers</h4>
                    </div>
                    <div class="modal-body">
                      <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                          <label class="col-sm-3 control-label"> Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  name="name" placeholder="Supplier Name" required>
                          </div>
                      </div><br>
                    </div>
                    <div class="modal-footer">
                      <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" form="addSupplier" class="btn btn-info">Create</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- End Modal for Create -->
         </div>
         <h3>Suppliers Table</h3>
         <br>
         <table class="table table-bordered responsive" id="table-2">
            <thead>
               <tr>
                  <th>Suppliers Name</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
              <?php foreach ($supplierList as $supplier) { ?>
                <tr>
                   <td>{{ ucfirst($supplier->name) }}</td>
                   <td>{{ ($supplier->status) == 1 ? 'Active' : 'Inactive' }}</td>
                   <td>{{ $supplier->created_at }}</td>
                   <td>
                     <a href="#" data-toggle="modal" data-target="#update_supplier{{$supplier->id}}">
                        <button type="button" class="btn btn-info btn-xs">Edit</button>
                    </a>
                    <a href="#" data-toggle="modal" data-target="#delete_supplier{{$supplier->id}}">
                       <button type="button" class="btn btn-danger btn-xs">Delete</button>
                   </a>
                   </td>
                </tr>

                <!-- Modal for Update -->
                <div class="modal fade" id="update_supplier{{$supplier->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('supplier.update') }}" id ="updateSupplierForm{{$supplier->id}}">
                        <input type="hidden" value="{{$supplier->id}}" name="id">
                        {{ csrf_field() }}
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="addChargeModal">Update Category</h4>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                              <label class="col-sm-3 control-label"> Name</label>
                              <div class="col-sm-9">
                                <input type="text" value="{{$supplier->name}}" class="form-control"  name="name" placeholder="Category Name" required>
                              </div>
                          </div><br>
                        </div>
                        <div class="modal-footer">
                          <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" form="updateSupplierForm{{$supplier->id}}" class="btn btn-info">Save changes</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End Modal for Update -->

                <!-- Modal for Delete -->
                <div class="modal fade" id="delete_supplier{{$supplier->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('supplier.delete') }} " id ="deleteSupplierForm{{$supplier->id}}">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{$supplier->id}}" name="id">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="addChargeModal">Are you sure you want to Delete {{ucfirst($supplier->name)}}</h4>
                        </div>
                        <div class="modal-footer">
                          <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" form="deleteSupplierForm{{$supplier->id}}" class="btn btn-info">Delete</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End Modal for Delete -->
              <?php } ?>
            </tbody>
         </table>
        {{ $supplierList->links() }}
      </div>

@stop
