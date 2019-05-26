@extends('layouts.default')
@section('content')
  <div class="users-table">
     <div class="table-top-links pull-right">
        <a href="" class="btn btn-default btn-icon" data-toggle="modal" data-target="#myModal">
        Add Stock Sale
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
                  <h4 class="modal-title" id="addChargeModal">Add Stock Sale</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Stock Num</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="brand_id" required>
                          <option disabled>Select Stock Num</option>
                          @foreach ($stockList as $key => $stock)
                             <option value="{{$stock->id}}">
                               {{ $stock->stock_num . ' : ' .  ucfirst($brandList[$stock->brand_id]) .' - '. ucfirst($categoryList[$stock->category_id]) .' - '. $stock->size }}</option>
                          @endforeach
                        </select>
                      </div>
                  </div><br><br>
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Quantity</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="quantity" placeholder="Quantity" required>
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
     <h3>Stock by Quantity Table</h3>
     <br>
     <table class="table table-bordered responsive" id="table-2">
        <thead>
           <tr>
              <th>#</th>
              <th>Stock #</th>
              <th>Stock Brand</th>
              <th>Stock Category</th>
              <th>Size</th>
              <th>Quantity</th>
              <th>Created</th>
              <th>Actions</th>
           </tr>
        </thead>
        <tbody>
          <?php foreach ($dailySalesList as $key => $dailySales) { ?>
            <tr>
               <td>{{ $key + 1 }}</td>
               <td>{{ $dailySales->stock_num }}</td>
               <td>{{ ucfirst($brandList[$dailySales->brand_id]) }}</td>
               <td>{{ ucfirst($categoryList[$dailySales->category_id]) }}</td>
               <td>{{ $dailySales->quantity }}</td>
               <td>{{ ($dailySales->type) == 1 ? 'Active' : 'Inactive' }}</td>
               <td>{{ $dailySales->created_at }}</td>
               <td>
                 <a href="#" data-toggle="modal" data-target="#update_daily_sales{{$dailySales->id}}">
                    <button type="button" class="btn btn-info btn-xs">Edit</button>
                </a>
                <a href="#" data-toggle="modal" data-target="#update_daily_sales{{$dailySales->id}}">
                   <button type="button" class="btn btn-danger btn-xs">Delete</button>
               </a>
               </td>
            </tr>
          <?php } ?>
        </tbody>
     </table>
    {{ $dailySalesList->links() }}
  </div>
@stop
