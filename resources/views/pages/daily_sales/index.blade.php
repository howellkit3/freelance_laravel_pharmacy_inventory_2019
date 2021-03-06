@extends('layouts.default')
@section('content')
  <div class="users-table">
     <div class="table-top-links pull-right">
        <a href="" class="btn btn-default btn-icon" data-toggle="modal" data-target="#myModal">
        Add Sale
        <i class="entypo-list-add"></i>
        </a>
        <!-- Modal for Create -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form method="POST" action="{{ route('stock.addSale') }} " id ="addSale">
                {{ csrf_field() }}
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="addChargeModal">Add Sale</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group{{ $errors->has('stock_id') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Stock Num</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="stock_id" required>
                          <option disabled>Select Stock Num</option>
                          @foreach ($stockList as $key => $stock)
                             <option value="{{$stock->id}}">
                               {{ $stock->stock_num . ' : ' .  ucfirst($brandList[$stock->brand_id]) .' - '. ucfirst($categoryList[$stock->category_id]) .' - '. $stock->size }}</option>
                          @endforeach
                        </select>
                      </div>
                  </div><br><br>
                  <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Quantity</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" name="quantity" placeholder="Quantity" required>
                      </div>
                  </div><br><br>
                  <div class="form-group{{ $errors->has('date_sold') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Date Sold</label>
                      <div class="col-sm-9">
                        <input type="date" name="date_sold" required class="form-control" value="<?php echo date('Y-m-d'); ?>">
                      </div>
                  </div><br>
                </div>
                <div class="modal-footer">
                  <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" form="addSale" class="btn btn-info" onclick="return confirm('Are you sure about your input?');">Create</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- End Modal for Create -->
     </div>
     <h3> Sales and Develiry Logs</h3>
     <br>
     <table class="table table-bordered responsive" id="table-2">
        <thead>
           <tr>
              <th>#</th>
              <th>Stock #</th>
              <th>Stock Brand</th>
              <th>Stock Category</th>
              <th>Quantity</th>
              <th>Type</th>
              <th>Date Sold/Delivered</th>
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
               <td>{{ ($dailySales->type) == 1 ? 'Additions (+)' : 'Deductions (-)' }}</td>
               <td>{{ date('Y-m-d', strtotime($dailySales->date_sold)) }}</td>
            </tr>
          <?php } ?>
        </tbody>
     </table>
    {{ $dailySalesList->links() }}
  </div>
@stop
