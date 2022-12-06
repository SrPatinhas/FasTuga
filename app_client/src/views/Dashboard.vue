<script setup>
</script>

<template>
<div class="row">
  <div class="column">
<h3>Waiting list</h3>
<table class="table-fill">
<tbody class="table-hover">
<tr>
<td class="text-left">#4</td>
</tr>
<tr>
<td class="text-left">#5</td>
</tr>
<tr>
<td class="text-left">#6</td>
</tr>
</tbody>
</table>
</div>

  <div class="column">
<h3>Orders to make</h3>
<table class="table-fill">
<tbody class="table-hover">
<tr>
<td class="text-left">#2</td>
</tr>
<tr>
<td class="text-left">#3</td>
</tr>
</tbody>
</table>
</div>

  <div class="column">
<h3>Finished orders</h3>
<table class="table-fill">
<tbody class="table-hover">
<tr>
<td class="text-left">#1</td>
</tr>
</tbody>
</table>
</div>
</div>
</template>

<style scoped>* {
  box-sizing: border-box;
}

.row {
  margin-left:-5px;
  margin-right:-5px;
}
  
.column {
  float: left;
  width: 32%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 16px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>
  