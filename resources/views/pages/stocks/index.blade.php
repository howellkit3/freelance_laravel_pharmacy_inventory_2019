@extends('layouts.default')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="users-table">
       <div class="table-top-links pull-right">
          <a href="" class="btn btn-default btn-icon" data-toggle="modal" data-target="#addStockItem">
          Add Stock Item
          <i class="entypo-list-add"></i>
          </a>

          <a href="" class="btn btn-default btn-icon" data-toggle="modal" data-target="#addStockSale">
          Add Sale
          <i class="entypo-list-add"></i>
          </a>
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
                               <option value="{{$stock->id}}">
                                 {{ $stock->stock_num . ' : ' .  ucfirst($brands[$stock->brand_id]) .' - '. ucfirst($categories[$stock->category_id]) .' - '. $stock->size }}</option>
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
                    <button type="submit" form="addSaleStock" class="btn btn-info" onclick="return confirm('Are you sure about your input?');">Create</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- End Modal for Create -->
          <!-- Modal for Create -->
          <div class="modal fade" id="addStockItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form method="POST" action="{{ route('stock.add') }} " id ="addStock">
                  {{ csrf_field() }}
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addChargeModal">Add Stock Item</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group{{ $errors->has('brand_id') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label"> Brand</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="brand_id" required>
                            <option disabled>Select Brand</option>
                            @foreach ($brands as $key => $brand)
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
                            @foreach ($categories as $key => $category)
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
                            @foreach ($generics as $key => $generic)
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
                             @foreach ($suppliers as $key => $supplier)
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
                          <input type="number" min="0" value="0.00" name="selling_price" required class="form-control" >
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
                 <td>{{ !empty($categories[$stock->category_id]) ? $categories[$stock->category_id] : 'undefined'  }}</td>
                 <td>{{ !empty($generics[$stock->generic_id]) ? $generics[$stock->generic_id] : 'undefined'  }}</td>
                 <td>{{ !empty($suppliers[$stock->supplier_id]) ? $suppliers[$stock->supplier_id] : 'undefined'  }}</td>
                 <td>{{ $stock->size }}</td>
                 <td>{{ $stock->unit_price }}</td>
                 <td>{{ $stock->selling_price }}</td>
                 @if($stock->available  < 11)
                  <td style="color:red"><b>{{ $stock->available }}</b></td>
                @else
                  <td><b>{{ $stock->available }}</b></td>
                @endif
                 <td>{{ date('Y-m-d', strtotime($stock->expiry_date)) }}</td>
                 <td>
                   <a href="#" data-toggle="modal" data-target="#update_stock{{$stock->stocks_id}}">
                      <button type="button" class="btn btn-info btn-xs">Edit</button>
                  </a>
                  <a href="#" data-toggle="modal" data-target="#add_stock{{$stock->stocks_id}}">
                     <button type="button" class="btn btn-success btn-xs">Add Quantity</button>
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

<div class="row">
    <div class="col-md-6">
      <!-- brand -->
      <div class="users-table">
         <div class="table-top-links pull-right">
            <a href="" class="btn btn-default btn-icon" data-toggle="modal" data-target="#addBrandModal">
            Add Brand
            <i class="entypo-list-add"></i>
            </a>
            <!-- Modal for Create -->
            <div class="modal fade" id="addBrandModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{ route('brand.add') }} " id ="addBrandForm">
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
                      <button type="submit" form="addBrandForm" class="btn btn-info">Create</button>
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
      <!-- end of brands -->

      <!-- generics -->

      <div class="users-table">
         <div class="table-top-links pull-right">
            <a href="" class="btn btn-default btn-icon" data-toggle="modal" data-target="#addGenericModal">
            Add Generic
            <i class="entypo-list-add"></i>
            </a>
            <!-- Modal for Create -->
            <div class="modal fade" id="addGenericModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

      <!-- generics end -->
    </div>
    <div class="col-md-6">
      <!-- categories -->
      <div class="users-table">
         <div class="table-top-links pull-right">
            <a href="" class="btn btn-default btn-icon" data-toggle="modal" data-target="#addCategoryModal">
            Add Category
            <i class="entypo-list-add"></i>
            </a>
            <!-- Modal for Create -->
            <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{ route('category.add') }} " id ="addCategory">
                    {{ csrf_field() }}
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="addChargeModal">Add Category</h4>
                    </div>
                    <div class="modal-body">
                      <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                          <label class="col-sm-3 control-label"> Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  name="name" placeholder="Category Name" required>
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
         <h3>Categories Table</h3>
         <br>
         <table class="table table-bordered responsive" id="table-2">
            <thead>
               <tr>
                  <th>Category Name</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
              <?php foreach ($categoryList as $category) { ?>
                <tr>
                   <td>{{ ucfirst($category->name) }}</td>
                   <td>{{ ($category->status) == 1 ? 'Active' : 'Inactive' }}</td>
                   <td>{{ $category->created_at }}</td>
                   <td>
                     <a href="#" data-toggle="modal" data-target="#update_category{{$category->id}}">
                        <button type="button" class="btn btn-info btn-xs">Edit</button>
                    </a>
                    <a href="#" data-toggle="modal" data-target="#delete_category{{$category->id}}">
                       <button type="button" class="btn btn-danger btn-xs">Delete</button>
                   </a>
                   </td>
                </tr>

                <!-- Modal for Update -->
                <div class="modal fade" id="update_category{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('category.update') }}" id ="updateCategoryForm{{$category->id}}">
                        <input type="hidden" value="{{$category->id}}" name="id">
                        {{ csrf_field() }}
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="addChargeModal">Update Category</h4>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                              <label class="col-sm-3 control-label"> Name</label>
                              <div class="col-sm-9">
                                <input type="text" value="{{$category->name}}" class="form-control"  name="name" placeholder="Category Name" required>
                              </div>
                          </div><br>
                        </div>
                        <div class="modal-footer">
                          <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" form="updateCategoryForm{{$category->id}}" class="btn btn-info">Save changes</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End Modal for Update -->

                <!-- Modal for Delete -->
                <div class="modal fade" id="delete_category{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('category.delete') }} " id ="deleteCategoryForm{{$category->id}}">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{$category->id}}" name="id">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="addChargeModal">Are you sure you want to Delete {{ucfirst($category->name)}}</h4>
                        </div>
                        <div class="modal-footer">
                          <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" form="deleteCategoryForm{{$category->id}}" class="btn btn-info">Delete</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End Modal for Delete -->
              <?php } ?>
            </tbody>
         </table>
        {{ $categoryList->links() }}
      </div>
      <!-- end of categories -->

      <!-- start of suppliers -->
      <div class="users-table">
         <div class="table-top-links pull-right">
            <a href="" class="btn btn-default btn-icon" data-toggle="modal" data-target="#addSupplierModal">
            Add Suppliers
            <i class="entypo-list-add"></i>
            </a>
            <!-- Modal for Create -->
            <div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

      <!-- end of suppliers -->
    </div>
</div>
@stop
