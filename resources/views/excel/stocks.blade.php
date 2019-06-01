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
      <tr>
        <td>{{$key + 1}}</td>
        <td>{{$value->stock_num}}</td>
        <td>{{$value->brand_name}}</td>
        <td>{{$value->category_name}}</td>
        <td>{{$value->generic_name}}</td>
        <td>{{$value->supplier_name}}</td>
        <td>{{$value->size}}</td>
        <td>{{$value->unit_price}}</td>
        <td>{{$value->selling_price}}</td>
        <td>{{$value->expiry_date}}</td>
        <td>{{$value->available}}</td>
      </tr>
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
