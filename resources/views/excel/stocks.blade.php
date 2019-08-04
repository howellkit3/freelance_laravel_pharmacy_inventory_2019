<style>
  td, th {
    border: 1px solid black;
  }

  table {
    border-collapse: collapse;
  }
</style>
<button id="printpagebutton" onclick="printStocks()">Print this page</button>
<h1>Stocks Table</h1>
<table style="width:100%">
  <thead>
    <tr>
      <th>#</th>
      <th>Stock #</th>
      <th>Brand</th>
      <th>Category</th>
      <th>Generic</th>
      <th>Supplier</th>
      <th>Size</th>
      <th>Unit Price</th>
      <th>Selling Price</th>
      <th>Expiry Date</th>
      <th>Available</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($stockList as $key => $value) { ?>
      @if(!empty($value->unit_price))
        <tr>
          <td>{{$key + 1}}</td>
          <td>{{$value->newStockNum}}</td>
          <td>{{ !empty($brands[$value->brand_id]) ? $brands[$value->brand_id] : 'undefined'  }}</td>
          <td>{{ !empty($categories[$value->category_id]) ? $categories[$value->category_id] : 'undefined'  }}</td>
          <td>{{ !empty($generics[$value->generic_id]) ? $generics[$value->generic_id] : 'undefined'  }}</td>
          <td>{{ !empty($suppliers[$value->supplier_id]) ? $suppliers[$value->supplier_id] : 'undefined'  }}</td>
          <td>{{$value->size}}</td>
          <td>{{$value->unit_price}}</td>
          <td>{{$value->selling_price}}</td>
          <td>{{$value->expiry_date}}</td>
          <td>{{$value->available}}</td>
        </tr>
      @endif
    <?php } ?>
  </tbdody>
</table>

<script>
  function printStocks() {
    var printButton = document.getElementById("printpagebutton");
    printButton.style.visibility = 'hidden';
    window.print()
    printButton.style.visibility = 'visible';
  }
</script>
