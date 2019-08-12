@extends('layouts.default')
@section('content')
  <div class="users-table">
     <div class="table-top-links pull-right">
        <a href="{{route('daily-sales-excel')}}" target="_blank" class="btn btn-default btn-icon">
          Print Daily Sales
          <i class="entypo-list-add"></i>
        </a>
     </div>
     <h3> Sales and Delivery Logs</h3>

     <div class="row filter-row-date">
       <form method="POST" action="{{ route('filter_stock_by_date') }}" id ="filterByDate">
           {{ csrf_field() }}
           <div class="col-md-5">
             <input type="date" class="form-control" name="date_from">
           </div>
           <div class="col-md-5">
             <input type="date" class="form-control" name="date_to">
           </div>
           <div class="col-md-2">
             <button type="submit" form="filterByDate" class="btn btn-info filter-by-date">Filter by Date</button>
           </div>
         </form>
       </div>

      <!-- Modal for Create -->
      <div class="modal fade" id="addStockSale" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form method="POST" action="{{ route('stock.addSale') }} " id ="addSaleStock">
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
                         @if(!empty($brands[$stock->brand_id]) && !empty($categories[$stock->category_id]))
                           <option value="{{$stock->stock_id}}">
                             {{ $stock->stock_num . ' : ' .  ucfirst($brands[$stock->brand_id]) .' - '. ucfirst($categories[$stock->category_id]) .' - '. $stock->size }}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                </div><br><br>
                <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label"> Quantity</label>
                    <div class="col-sm-9">
                      <input type="number" min="1" class="form-control" name="quantity" placeholder="Quantity" required>
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
                <button type="submit" form="addSaleStock" class="btn btn-info" onclick="return confirm('Are you sure about your input?');">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- End Modal for Create -->
   </div>
     <br>
     <table class="table table-bordered responsive" id="table-2">
        <thead>
           <tr>
              <th>#</th>
              <th>Date Sold</th>
              <th>Stock#</th>
              <th>Brand</th>
              <th>Generic</th>
              <th>Size</th>
              <th>Expiration</th>
              <th>Qty Sold</th>
              <th>Unit Price</th>
              <th>Selling Price</th>
              <th>Profit</th>
              <th>Action</th>
           </tr>
        </thead>
        <tbody>
          <?php $total_profit = 0 ?>
          @foreach ($dailySalesList as $key => $dailySales)
            <tr>
               <td>{{ $key + 1 }}</td>
               <td>{{ date('Y-m-d', strtotime($dailySales->date_sold)) }}</td>
               <td>{{ $dailySales->newStockNum }}</td>
               <td>{{ ucfirst($brandList[$dailySales->brand_id]) }}</td>
               <td>{{ ucfirst($genericList[$dailySales->generic_id]) }}</td>
               <td>{{ $dailySales->size }}</td>
               <td>{{ date('Y-m-d', strtotime($dailySales->expiry_date)) }}</td>
               <td>{{ $dailySales->quantity }}</td>
               <td>{{ $dailySales->unit_price }}</td>
               <td>{{ $dailySales->selling_price }}</td>
               <td>{{ number_format((float)$dailySales->profit, 2, '.', '') }}</td>
               <td>
                 <a href="#" data-toggle="modal" data-target="#void_stock{{$dailySales->st_id}}">
                    <button type="button" class="btn btn-info btn-xs action-button">
                      <span class="glyphicon glyphicon-retweet"></span>
                    </button>
                </a>
               </td>
            </tr>

            <?php $total_profit = $total_profit + $dailySales->profit; ?>

            <!-- Modal for Void -->
            <div class="modal fade" id="void_stock{{$dailySales->st_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{ route('daily_sales.void') }}" id ="updateStockForm{{$dailySales->st_id}}">
                    <input type="hidden" value="{{$dailySales->st_id}}" name="quantity_stock_id">
                    {{ csrf_field() }}
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="addChargeModal">Void Sale</h4>
                      <p>This will return the quantity stock to the inventory.</p>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                          <label class="col-sm-3 control-label"> Stock#</label>
                          <div class="col-sm-9">
                            <input type="text" disabled value="{{$dailySales->newStockNum}}" class="form-control">
                          </div>
                      </div><br><br>
                      <div class="form-group">
                          <label class="col-sm-3 control-label"> Brand</label>
                          <div class="col-sm-9">
                            <input type="text" disabled value="{{$brandList[$dailySales->brand_id]}}" class="form-control">
                          </div>
                      </div><br><br>
                      <div class="form-group">
                          <label class="col-sm-3 control-label"> Size</label>
                          <div class="col-sm-9">
                            <input type="text" disabled value="{{$dailySales->size}}" class="form-control">
                          </div>
                      </div><br><br>
                      <div class="form-group">
                          <label class="col-sm-3 control-label"> Quantity Sold</label>
                          <div class="col-sm-9">
                            <input type="text" disabled value="{{$dailySales->quantity}}" class="form-control">
                          </div>
                      </div><br><br>
                      <div class="form-group">
                          <label class="col-sm-3 control-label"> Unit Price</label>
                          <div class="col-sm-9">
                            <input type="text" disabled value="{{$dailySales->unit_price}}" class="form-control">
                          </div>
                      </div><br><br>
                      <div class="form-group">
                          <label class="col-sm-3 control-label"> Selling Price</label>
                          <div class="col-sm-9">
                            <input type="text" disabled value="{{$dailySales->selling_price}}" class="form-control">
                          </div>
                      </div><br><br>
                    </div>
                    <div class="modal-footer">
                      <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" form="updateStockForm{{$dailySales->st_id}}" class="btn btn-info">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- End Modal for Update -->
          @endforeach
          <tr>
            <td class="total-row"></td>
            <td class="total-row"></td>
            <td class="total-row"></td>
            <td class="total-row"></td>
            <td class="total-row"></td>
            <td class="total-row"></td>
            <td class="total-row"></td>
            <td class="total-row"></td>
            <td class="total-row"></td>
            <td>Total:</td>
            <td><b>{{ number_format((float)$total_profit, 2, '.', '')}}</b></td>
            <td class="total-row"></td>
          </tr>
        </tbody>
     </table>
    {{ $dailySalesList->links() }}
  </div>
@stop
