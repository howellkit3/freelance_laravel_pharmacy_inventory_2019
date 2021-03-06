@extends('layouts.default')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="users-table">
       <div class="col-md-3">
         <h3 style="margin-top:0px">Stocks Table</h3>
       </div>
       <div class="col-md-7">
         <div class="table-top-links pull-right">
            <a href="{{route('stocks-excel')}}" target="_blank" class="btn btn-default btn-icon">
              Export Stock Table
            <i class="entypo-list-add"></i>
            </a>
         </div>
       </div>
       <div class="col-md-2">
         <div class="input-group reservation-input-group  pull-right">
           <form method="POST" action="{{ route('search_stock') }}" id ="search_stocks}">
             {{ csrf_field() }}
             <input type="text" class="form-control" name="keyword" id="search_stocks" placeholder="Search Brand">
           </form>
         </div>
       </div>
       <br><br>
       <section class="stock_list">
        <table class="table table-bordered responsive" id="table-2">
          <thead>
             <tr>
                <th>#</th>
                <th>Stock#</th>
                <th>Brand</th>
                <th>Ctgry</th>
                <th>Generic</th>
                <th>Supplier</th>
                <th>Size</th>
                <th>Unit Price</th>
                <th>Selling Price</th>
                <th>Qty</th>
                <th>Expiry Date</th>
                <th>Actions</th>
             </tr>
          </thead>
          <tbody>
            <?php foreach ($stockList as $key => $stock) { ?>
              @if(!empty($stock->unit_price))
                <tr>
                   <td>{{ $key + 1 }} </td>
                   <td>{{ $stock->newStockNum }}</td>
                   <td>{{ !empty($stock->brand_name) ? $stock->brand_name : 'no name'  }}</td>
                   <td>{{ !empty($categories[$stock->category_id]) ? substr($categories[$stock->category_id], 0, 15) . "..." : 'undefined'  }}</td>
                   <td>{{ !empty($generics[$stock->generic_id]) ? substr($generics[$stock->generic_id], 0, 15) . "..." : 'undefined'  }}</td>
                   <td>{{ !empty($suppliers[$stock->supplier_id]) ? $suppliers[$stock->supplier_id] : 'undefined'  }}</td>
                   <td>{{ $stock->size }}</td>
                   <td>{{ $stock->unit_price }}</td>
                   <td>{{ $stock->selling_price }}</td>
                   @if($stock->quantity  < 6)
                    <td style="color:red"><b>{{ $stock->quantity }}</b></td>
                  @else
                    <td><b>{{ $stock->quantity }}</b></td>
                  @endif
                  <?php
                    $todayDate = time();
                    $date_6_months = strtotime("+4 months");
                    $givenDate = strtotime($stock->expiry_date);
                  ?>
                  @if($givenDate > $todayDate && $givenDate < $date_6_months)
                    <td style="color:green"><b>{{ date('Y-m-d', strtotime($stock->expiry_date)) }}</b></td>
                  @elseif($givenDate < $todayDate)
                    <td style="color:orange"><b>{{ date('Y-m-d', strtotime($stock->expiry_date)) }}</b></td>
                  @else
                  <td>{{ date('Y-m-d', strtotime($stock->expiry_date)) }}</td>
                  @endif
                   <td>
                     <a href="#" data-toggle="modal" data-target="#update_stock{{$stock->st_id}}">
                        <button type="button" class="btn btn-info btn-xs action-button"><span class="glyphicon glyphicon-pencil"></span></button>
                    </a>
                    <a href="#" data-toggle="modal" data-target="#add_stock{{$stock->st_id}}">
                       <button type="button" class="btn btn-success btn-xs action-button"><span class="glyphicon glyphicon-plus"></span></button>
                     </a>
                    <a href="#" data-toggle="modal" data-target="#remove_stock{{$stock->st_id}}">
                       <button type="button" class="btn btn-danger btn-xs action-button"><span class="glyphicon glyphicon-remove"></span></button>
                     </a>
                     @if($stock->quantity > 0)
                     <a href="#" data-toggle="modal" data-target="#add_sale{{$stock->st_id}}">
                        <button type="button" class="btn btn-warning btn-xs action-button"><span class="glyphicon glyphicon-shopping-cart"></span></button>
                      </a>
                      @endif
                   </td>
                </tr>

                <!-- Modal for Create -->
                <div class="modal fade" id="add_sale{{$stock->st_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('stock.addSale') }} " id ="addSaleStock{{$stock->st_id}}">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{$stock->st_id}}" name="stock_quantity_id">
                        <input type="hidden" value="{{$stock->quantity}}" name="orig_quantity">
                        <input type="hidden" value="{{$stock->stocks_id}}" name="stock_id">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="addChargeModal">Add Sale to {{ucfirst($stock->brand_name)}} ({{$stock->newStockNum}})</h4>
                        </div>
                        <div class="modal-body">
                          <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                              <label class="col-sm-3 control-label">Current Qty</label>
                              <div class="col-sm-9">
                                 {{$stock->quantity}}
                              </div>
                          </div><br><br>
                          <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                              <label class="col-sm-3 control-label"> Quantity</label>
                              <div class="col-sm-9">
                                <input type="number" min="1" max="{{$stock->quantity}}" class="form-control" name="quantity" placeholder="Quantity" required>
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
                          <button type="submit" form="addSaleStock{{$stock->st_id}}" class="btn btn-info" onclick="return confirm('Are you sure about your input?');">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End Modal for Create -->

                <!-- Modal for Update -->
                <div class="modal fade" id="update_stock{{$stock->st_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('stock.update') }}" id ="updateStockForm{{$stock->st_id}}">
                        <input type="hidden" value="{{$stock->stocks_id}}" name="stocks_id">
                        <input type="hidden" value="{{$stock->stock_infos_id}}" name="stock_infos_id">
                        {{ csrf_field() }}
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="addChargeModal">Update Stock</h4>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                              <label class="col-sm-3 control-label"> Stock#</label>
                              <div class="col-sm-9">
                                <input type="text" disabled value="{{$stock->stock_num}}" class="form-control"  name="stock_num" placeholder="Category Name" required>
                              </div>
                          </div><br><br>
                          <div class="form-group">
                              <label class="col-sm-3 control-label"> Brand {{$stock->brand_id}}</label>
                              <div class="col-sm-9">
                                <select class="form-control" name="brand_id" required>
                                   <option disabled>Select Brand  </option>
                                   @foreach ($brands as $key => $brand)
                                      @if($key == $stock->brand_id)
                                        <option value="{{$key}}" selected>{{ ucfirst($brand) }}</option>
                                      @else
                                        <option value="{{$key}}">{{ ucfirst($brand) }}</option>
                                      @endif
                                   @endforeach
                                </select>
                              </div>
                          </div><br><br>
                          <div class="form-group">
                              <label class="col-sm-3 control-label"> Category</label>
                              <div class="col-sm-9">
                                <select class="form-control" name="category_id" required>
                                   <option disabled>Select Category  </option>
                                   @foreach ($categories as $key => $category)
                                      @if($key == $stock->category_id)
                                        <option value="{{$key}}" selected>{{ ucfirst($category) }}</option>
                                      @else
                                        <option value="{{$key}}">{{ ucfirst($category) }}</option>
                                      @endif
                                   @endforeach
                                </select>
                              </div>
                          </div><br><br>
                          <div class="form-group">
                              <label class="col-sm-3 control-label"> Generic</label>
                              <div class="col-sm-9">
                                <select class="form-control" name="generic_id" required>
                                   <option disabled>Select Generic</option>
                                   @foreach ($generics as $key => $generic)
                                      @if($key == $stock->generic_id)
                                        <option value="{{$key}}" selected>{{ ucfirst($generic) }}</option>
                                      @else
                                        <option value="{{$key}}">{{ ucfirst($generic) }}</option>
                                      @endif
                                   @endforeach
                                </select>
                              </div>
                          </div><br><br>
                          <div class="form-group">
                              <label class="col-sm-3 control-label"> Supplier</label>
                              <div class="col-sm-9">
                                <select class="form-control" name="supplier_id" required>
                                   <option disabled>Select Supplier  </option>
                                   @foreach ($suppliers as $key => $supplier)
                                      @if($key == $stock->supplier_id)
                                        <option value="{{$key}}" selected>{{ ucfirst($supplier) }}</option>
                                      @else
                                        <option value="{{$key}}">{{ ucfirst($supplier) }}</option>
                                      @endif
                                   @endforeach
                                </select>
                              </div>
                          </div><br><br>
                          <div class="form-group">
                              <label class="col-sm-3 control-label"> Size</label>
                              <div class="col-sm-9">
                                <input type="text" value="{{$stock->size}}" class="form-control"  name="size" placeholder="Size" required>
                              </div>
                          </div><br><br>
                          <div class="form-group">
                              <label class="col-sm-3 control-label"> Unit Price</label>
                              <div class="col-sm-9">
                                <input type="number" min="0" step="any" value="{{$stock->unit_price}}" class="form-control"  name="unit_price" placeholder="Unit Price" required>
                              </div>
                          </div><br><br>
                          <div class="form-group">
                              <label class="col-sm-3 control-label"> Selling Price</label>
                              <div class="col-sm-9">
                                <input type="number" min="0" step="any" value="{{$stock->selling_price}}" class="form-control"  name="selling_price" placeholder="Selling Price" required>
                              </div>
                          </div><br><br>
                          <div class="form-group">
                              <label class="col-sm-3 control-label"> Lot Number</label>
                              <div class="col-sm-9">
                                <input type="text" value="{{$stock->lot_number}}" class="form-control"  name="lot_number" placeholder="Lot Number" required>
                              </div>
                          </div><br><br>
                          <div class="form-group">
                              <label class="col-sm-3 control-label"> Expirary Date</label>
                              <div class="col-sm-9">
                                <input type="date" value="{{date('Y-m-d',strtotime($stock->expiry_date))}}" min=<?php echo date('Y-m-d');?> class="form-control"  name="expiry_date" placeholder="Expiry Date" required>
                              </div>
                          </div><br><br>
                        </div>
                        <div class="modal-footer">
                          <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" form="updateStockForm{{$stock->st_id}}" class="btn btn-info">Save changes</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End Modal for Update -->

                <!-- Modal for Remove -->
                <div class="modal fade" id="remove_stock{{$stock->st_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('stock.delete') }}" id ="removeStockForm{{$stock->st_id}}">
                        <input type="hidden" value="{{$stock->stocks_id}}" name="stocks_id">
                        <input type="hidden" value="{{$stock->stock_infos_id}}" name="stock_infos_id">
                        <input type="hidden" value="{{$stock->st_id}}" name="stock_quantity_id">
                        {{ csrf_field() }}
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="addChargeModal">Are you sure you want to remove {{!empty($brands[$stock->brand_id]) ? $brands[$stock->brand_id] : '' }} ? </h4>
                        </div>
                        <div class="modal-footer">
                          <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" form="removeStockForm{{$stock->st_id}}" class="btn btn-warning">Remove</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End Modal for Update -->

                <!-- Modal for Add Stock -->
                <div class="modal fade" id="add_stock{{$stock->st_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('stock.addQuantity') }}" id ="addStockForm{{$stock->st_id}}">
                        <input type="hidden" value="{{$stock->stocks_id}}" name="stocks_id">
                        <input type="hidden" value="{{$stock->st_id}}" name="stocks_quantity_id">
                        <input type="hidden" value="{{$stock->quantity}}" name="orig_quantity">
                        <input type="hidden" value="{{$stock->stock_infos_id}}" name="stocks_info_id">

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
                              <label class="col-sm-3 control-label"> Unit Price</label>
                              <div class="col-sm-9">
                                <input type="number" min="0" step="any" value="{{$stock->unit_price}}" class="form-control"  name="unit_price" placeholder="Unit Price" required>
                              </div>
                          </div><br><br>
                          <div class="form-group">
                              <label class="col-sm-3 control-label"> Selling Price</label>
                              <div class="col-sm-9">
                                <input type="number" min="0" step="any" value="{{$stock->selling_price}}" class="form-control"  name="selling_price" placeholder="Selling Price" required>
                              </div>
                          </div><br><br>
                          <div class="form-group">
                              <label class="col-sm-3 control-label"> Expiry Date</label>
                              <div class="col-sm-9">
                                <input type="date" value="{{date('Y-m-d',strtotime($stock->expiry_date))}}" min=<?php echo date('Y-m-d');?> class="form-control"  name="expiry_date" placeholder="Expiry Date" required>
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
                          <button type="submit" form="addStockForm{{$stock->st_id}}" class="btn btn-info">Add to Quantity</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End Modal Add Stock -->
              @endif
            <?php } ?>
          </tbody>
       </table>
       </section>
       <?php header('Access-Control-Allow-Origin: *'); ?>
       <section class="search_append"></section>
      {{ $stockList->links() }}
    </div>
  </div>
</div>
@stop
