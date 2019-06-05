@extends('layouts.default')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="users-table">
       <div class="table-top-links pull-right">
          <a href="{{route('daily-sales-excel')}}" target="_blank" class="btn btn-default btn-icon">
            Export Stock Table
          <i class="entypo-list-add"></i>
          </a>
       </div>
       <h3>Stocks Table</h3>
       <br><br>
       <table class="table table-bordered responsive" id="table-2">
          <thead>
             <tr>
                <th>#</th>
                <th>Stock Num</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Generic</th>
                <th>Supplier</th>
                <th>Size</th>
                <th>Unit Price</th>
                <th>Selling Price</th>
                <th>Quantity</th>
                <th>Expiry Date</th>
                <th>Actions</th>
             </tr>
          </thead>
          <tbody>
            <?php foreach ($stockList as $key => $stock) { ?>
              <tr>
                 <td>{{ $key + 1 }} </td>
                 <td>{{ ucfirst($stock->stock_num) }}</td>
                 <td>{{ !empty($brands[$stock->brand_id]) ? $brands[$stock->brand_id] : 'undefined'  }}</td>
                 <td>{{ !empty($categories[$stock->category_id]) ? substr($categories[$stock->category_id], 0, 15) . "..." : 'undefined'  }}</td>
                 <td>{{ !empty($generics[$stock->generic_id]) ? substr($generics[$stock->generic_id], 0, 15) . "..." : 'undefined'  }}</td>
                 <td>{{ !empty($suppliers[$stock->supplier_id]) ? $suppliers[$stock->supplier_id] : 'undefined'  }}</td>
                 <td>{{ $stock->size }}</td>
                 <td>{{ $stock->unit_price }}</td>
                 <td>{{ $stock->selling_price }}</td>
                 @if($stock->available  < 6)
                  <td style="color:red"><b>{{ $stock->available }}</b></td>
                @else
                  <td><b>{{ $stock->available }}</b></td>
                @endif
                <?php
                  $todayDate = time();
                  $date_6_months = strtotime("+6 months");
                  $givenDate = strtotime($stock->expiry_date);
                ?>
                @if($givenDate > $todayDate && $givenDate < $date_6_months)
                  <td style="color:green">{{ date('Y-m-d', strtotime($stock->expiry_date)) }}</td>
                @elseif($givenDate < $todayDate)
                  <td style="color:orange">{{ date('Y-m-d', strtotime($stock->expiry_date)) }}</td>
                @else
                <td>{{ date('Y-m-d', strtotime($stock->expiry_date)) }}</td>
                @endif

                 <td>
                   <a href="#" data-toggle="modal" data-target="#update_stock{{$stock->stocks_id}}">
                      <button type="button" class="btn btn-info btn-xs">Edit</button>
                  </a>
                  <a href="#" data-toggle="modal" data-target="#add_stock{{$stock->stocks_id}}">
                     <button type="button" class="btn btn-success btn-xs">Add</button>
                 </a>
                 </td>
              </tr>

              <!-- Modal for Add Stock -->
              <div class="modal fade" id="add_stock{{$stock->stocks_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <form method="POST" action="{{ route('stock.addQuantity') }}" id ="addStockForm{{$stock->stocks_id}}">
                      <input type="hidden" value="{{$stock->stocks_id}}" name="stocks_id">
                      {{ csrf_field() }}
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="addChargeModal">Add Quantity To Stock</h4>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Stock#</label>
                            <div class="col-sm-9">
                              <input type="text" disabled value="{{$stock->stock_num}}" class="form-control"  name="stock_num" placeholder="Category Name" required>
                            </div>
                        </div><br><br>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Quantity</label>
                            <div class="col-sm-9">
                              <input type="number" min="0" class="form-control"  name="quantity" placeholder="Quantity" required>
                            </div>
                        </div><br><br>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Date Delivered</label>
                            <div class="col-sm-9">
                              <input type="date" name="date_sold" required class="form-control" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div><br><br>
                      </div>
                      <div class="modal-footer">
                        <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" form="addStockForm{{$stock->stocks_id}}" class="btn btn-info">Add to Quantity</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- End Modal for Update -->
            <?php } ?>
          </tbody>
       </table>
      {{ $stockList->links() }}
    </div>
  </div>
</div>
@stop
