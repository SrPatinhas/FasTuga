<script setup>
</script>

<template>
<div class="row">
  <div class="column">
<h3>Waiting list</h3>
<ul class="list-group">
			<li class="list-group-item d-flex justify-content-between align-items-start">
				<div class="ms-2 me-auto">
					<div class="fw-bold h3">
						<span class="h5 text-muted">#</span>4
					</div>
				</div>
				<span class="text-muted">13:32</span>
      </li>

      <li class="list-group-item d-flex justify-content-between align-items-start">
				<div class="ms-2 me-auto">
					<div class="fw-bold h3">
						<span class="h5 text-muted">#</span>5
					</div>
				</div>
				<span class="text-muted">13:35</span>
      </li>

      <li class="list-group-item d-flex justify-content-between align-items-start">
				<div class="ms-2 me-auto">
					<div class="fw-bold h3">
						<span class="h5 text-muted">#</span>6
					</div>
				</div>
				<span class="text-muted">13:35</span>
      </li>
		</ul>
	</div>

  <div class="column">
<h3>Orders to make</h3>
<ul class="list-group">
			<li class="list-group-item d-flex justify-content-between align-items-start">
				<div class="ms-2 me-auto">
					<div class="fw-bold h3">
						<span class="h5 text-muted">#</span>2
					</div>
				</div>
				<span class="text-muted">13:32</span>
      </li>

      <li class="list-group-item d-flex justify-content-between align-items-start">
				<div class="ms-2 me-auto">
					<div class="fw-bold h3">
						<span class="h5 text-muted">#</span>3
					</div>
				</div>
				<span class="text-muted">13:35</span>
      </li>
		</ul>
	</div>

  <div class="column">
<h3>Finished orders</h3>
<ul class="list-group">
			<li class="list-group-item d-flex justify-content-between align-items-start">
				<div class="ms-2 me-auto">
					<div class="fw-bold h3">
						<span class="h5 text-muted">#</span>1
					</div>
				</div>
				<span class="text-muted">13:32</span>
      </li>
		</ul>
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

body{
	background: gray;
}
</style>
  