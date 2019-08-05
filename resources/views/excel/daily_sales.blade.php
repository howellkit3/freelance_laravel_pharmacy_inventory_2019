<style>
  td, th {
    border: 1px solid black;
  }

  table {
    border-collapse: collapse;
  }
</style>
<button id="printpagebutton" onclick="printStocks()">Print this page</button>
<h1>Daily Sales Table</h1>
<table style="width:100%">
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
    </tr>
  </thead>
  <tbody>
    <?php foreach ($dailySalesList as $key => $dailySales) { ?>
      <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ date('Y-m-d', strtotime($dailySales->date_sold)) }}</td>
        <td>{{ $dailySales->newStockNum }}</td>
        <td>{{ ucfirst($brandList[$dailySales->brand_id]) }}</td>
        <td>{{ ucfirst($genericList[$dailySales->category_id]) }}</td>
        <td>{{ $dailySales->size }}</td>
        <td>{{ date('Y-m-d', strtotime($dailySales->expiry_date)) }}</td>
        <td>{{ $dailySales->quantity }}</td>
        <td>{{ $dailySales->unit_price }}</td>
        <td>{{ $dailySales->selling_price }}</td>
        <td>{{ $dailySales->profit }}</td>
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
