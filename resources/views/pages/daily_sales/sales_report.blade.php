@extends('layouts.default')
@section('content')
  <div class="users-table">
     <div class="table-top-links pull-right">
        <a href="" class="btn btn-default btn-icon" data-toggle="modal" data-target="#myModal">
          Daily Sales
        <i class="entypo-list-add"></i>
        </a>

        <a href="{{route('daily-sales-excel')}}" class="btn btn-default btn-icon">
          Print Daily Sales
        <i class="entypo-list-add"></i>
        </a>
     </div>
     <h3> Sales and Develiry Logs</h3>
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
              <th>Quantity Sold</th>
              <th>Unit Price</th>
              <th>Selling Price</th>
              <th>Profit</th>
              <th>Profit</th>
              <th>Balance Available</th>
           </tr>
        </thead>
        <tbody>
          <?php foreach ($dailySalesList as $key => $dailySales) { ?>
            <tr>
               <td>{{ $key + 1 }}</td>
               <td>{{ date('Y-m-d', strtotime($dailySales->date_sold)) }}</td>
               <td>{{ $dailySales->stock_num }}</td>
               <td>{{ ucfirst($brandList[$dailySales->brand_id]) }}</td>
               <td>{{ ucfirst($genericList[$dailySales->category_id]) }}</td>
               <td>{{ $dailySales->size }}</td>
               <td>{{ $dailySales->quantity }}</td>
               <td>{{ $dailySales->unit_price }}</td>
               <td>{{ $dailySales->selling_price }}</td>
               <td>{{ $dailySales->profit }}</td>
               <th>{{ $dailySales->substractions }}</th>
               <td>{{ $dailySales->available_stock }}</td>
            </tr>
          <?php } ?>
        </tbody>
     </table>
    {{ $dailySalesList->links() }}
  </div>
@stop
