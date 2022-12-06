<script setup>
</script>

<template>
  <div id="filters">
		<a href="#" id="newer" class="selected">All</a>
		<a href="#" id="older">Kitchen</a>
    <a href="#" id="older">Delivery</a>
    <a href="#" id="older">Me</a>
	</div>
  <div class="row">
  <div class="column">
    <div class="modal modal-alert position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalChoice">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-3 shadow">
      <div class="modal-body p-4 text-center">
        <span>#1</span>
        <span style="color:#FF0000">&emsp; CANCELLED</span>
        <p>2022/12/12 - 20:00</p>
        <div class="description">
          <div class="row">
            <div class="column">
            <b>Method:</b><p>Card</p>
            <b>Price:</b>&nbsp<p>18€</p>
            </div>
            <div class="column">
            <b>Paid:</b>&nbsp<p>20€</p>
            <b>Employee:</b>&nbsp<p>Jéssica Grácio</p>
            </div>
            <div class="column">
            <b>Points:</b>&nbsp<p>5</p>
            </div>
            </div>
      </div>
      </div>
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-end"><strong>Yes, enable</strong></button>
        <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal">No thanks</button>
      </div>
    </div>
  </div>
</div>
  </div>
  <div class="column">
    <div class="modal modal-alert position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalChoice">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-3 shadow">
      <div class="modal-body p-4 text-center">
        <h5 class="mb-0">Enable this setting?</h5>
        <p class="mb-0">You can always change your mind in your account settings.</p>
      </div>
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-end"><strong>Yes, enable</strong></button>
        <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal">No thanks</button>
      </div>
    </div>
  </div>
</div>
  </div>
  <div class="column">
    <div class="modal modal-alert position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalChoice">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-3 shadow">
      <div class="modal-body p-4 text-center">
        <h5 class="mb-0">Enable this setting?</h5>
        <p class="mb-0">You can always change your mind in your account settings.</p>
      </div>
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-end"><strong>Yes, enable</strong></button>
        <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal">No thanks</button>
      </div>
    </div>
  </div>
</div>
  </div>
  </div>
</template>

<style scoped>
#filters {
	height: 2em;
	text-align: center;
	margin-bottom: 1.5em;
}

#filters a {
	font: bold 1.2em Arial, sans-serif;
	display: inline-block;
	height: 2em;
	line-height: 2;
	text-align: center;
	padding: 0 1em;
	margin-left: 1em;
	border: 2px solid #ccc;
	color: #000;
	text-decoration: none;
}

#filters a.selected {
	color: #08c;
	border-color: #08c;
}


* {
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

.description{
  text-align: left;
}
</style>
  
  