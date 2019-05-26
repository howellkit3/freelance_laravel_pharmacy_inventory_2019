@extends('layouts.default')
@section('content')
  <div class="users-table">
     <div class="table-top-links pull-right">
        <a href="" class="btn btn-default btn-icon" data-toggle="modal" data-target="#myModal">
        Add Stock
        <i class="entypo-list-add"></i>
        </a>
        <!-- Modal for Create -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form method="POST" action="{{ route('stock.add') }} " id ="addStock">
                {{ csrf_field() }}
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="addChargeModal">Add Stock</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group{{ $errors->has('brand_id') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Brand</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="brand_id" required>
                          <option disabled>Select Brand</option>
                          @foreach ($brandList as $key => $brand)
                             <option value="{{$key}}" >{{ ucfirst($brand) }}</option>
                          @endforeach
                        </select>
                      </div>
                  </div><br><br>
                  <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Category</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="category_id" required>
                          <option disabled>Select Category</option>
                          @foreach ($categoryList as $key => $category)
                             <option value="{{$key}}" >{{ ucfirst($category) }}</option>
                          @endforeach
                        </select>
                      </div>
                  </div><br><br>
                  <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Generic</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="generic_id" required>
                          <option disabled>Select Generic</option>
                          @foreach ($genericList as $key => $generic)
                             <option value="{{$key}}" >{{ ucfirst($generic) }}</option>
                          @endforeach
                        </select>
                      </div>
                  </div><br><br>
                  <div class="form-group{{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Supplier</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="supplier_id" id="company-select" required>
                           <option disabled>Select Supplier</option>
                           @foreach ($supplierList as $key => $supplier)
                              <option value="{{$key}}" >{{ ucfirst($supplier) }}</option>
                           @endforeach
                        </select>
                      </div>
                  </div><br><br>
                  <div class="form-group{{ $errors->has('size') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Size</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="size" placeholder="Size" required>
                      </div>
                  </div><br><br>
                  <div class="form-group{{ $errors->has('lot_number') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Lot Number</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="lot_number" placeholder="Lot Number" required>
                      </div>
                  </div><br><br>
                  <div class="form-group{{ $errors->has('expiry_date') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Expiry Date</label>
                      <div class="col-sm-9">
                        <input type="date" name="expiry_date" required class="form-control" >
                      </div>
                  </div><br><br>
                  <div class="form-group{{ $errors->has('unit_price') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Unit Price</label>
                      <div class="col-sm-9">
                        <input type="number" min="0" step="0.25" value="0.00" name="unit_price" required class="form-control" >
                      </div>
                  </div><br><br>
                  <div class="form-group{{ $errors->has('selling_price') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label"> Selling Price</label>
                      <div class="col-sm-9">
                        <input type="number" min="0" step="0.25" value="0.00" name="selling_price" required class="form-control" >
                      </div>
                  </div><br><br>
                </div>
                <div class="modal-footer">
                  <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" form="addStock" class="btn btn-info">Create</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- End Modal for Create -->
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
              <th>Actions</th>
           </tr>
        </thead>
        <tbody>
          <?php foreach ($stockList as $key => $stock) { ?>
            <tr>
               <td>{{ $key + 1 }} </td>
               <td>{{ ucfirst($stock->stock_num) }}</td>
               <td>{{ !empty($brandList[$stock->brand_id]) ? $brandList[$stock->brand_id] : 'undefined'  }}</td>
               <td>{{ !empty($categoryList[$stock->category_id]) ? $categoryList[$stock->category_id] : 'undefined'  }}</td>
               <td>{{ !empty($genericList[$stock->generic_id]) ? $genericList[$stock->generic_id] : 'undefined'  }}</td>
               <td>{{ !empty($supplierList[$stock->supplier_id]) ? $supplierList[$stock->supplier_id] : 'undefined'  }}</td>
               <td>{{ $stock->size }}</td>
               <td>{{ $stock->unit_price }}</td>
               <td>{{ $stock->selling_price }}</td>
               <td>
                 <a href="#" data-toggle="modal" data-target="#update_stock{{$stock->stocks_id}}">
                    <button type="button" class="btn btn-info btn-xs">Edit</button>
                </a>
               </td>
            </tr>

            <!-- Modal for Update -->
            <div class="modal fade" id="update_stock{{$stock->stocks_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{ route('stock.update') }}" id ="updateStockForm{{$stock->stocks_id}}">
                    <input type="hidden" value="{{$stock->stocks_id}}" name="stocks_id">
                    <input type="hidden" value="{{$stock->stock_infos_id}}" name="stock_infos_id">
                    {{ csrf_field() }}
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="addChargeModal">Update Category</h4>
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
                               @foreach ($brandList as $key => $brand)
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
                               @foreach ($categoryList as $key => $category)
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
                               @foreach ($genericList as $key => $generic)
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
                               @foreach ($supplierList as $key => $supplier)
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
                            <input type="number" min="0" value="{{$stock->unit_price}}" class="form-control"  name="unit_price" placeholder="Unit Price" required>
                          </div>
                      </div><br><br>
                      <div class="form-group">
                          <label class="col-sm-3 control-label"> Selling Price</label>
                          <div class="col-sm-9">
                            <input type="number" min="0"  value="{{$stock->selling_price}}" class="form-control"  name="selling_price" placeholder="Selling Price" required>
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
                            <input type="date" value="{{date('Y-m-d',strtotime($stock->expiry_date))}}" class="form-control"  name="expiry_date" placeholder="Expiry Date" required>
                          </div>
                      </div><br><br>
                    </div>
                    <div class="modal-footer">
                      <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" form="updateStockForm{{$stock->stocks_id}}" class="btn btn-info">Save changes</button>
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
@stop
