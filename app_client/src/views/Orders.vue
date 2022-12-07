<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
</script>

<template>
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <div class="column">
        <div class="title-left">
        <span>#1</span>
      </div>
    </div>
    <div class="column">
    <div class="title-center">
    <span style="color:#FF0000"> Cancelled</span>
        2022/12/12
        20:00
      </div>
    </div>
    <div class="column">
      <div class="title-right">
        <p>Jéssica Grácio</p>
      </div>
    </div>
    <button class="accordion">Items</button>
    <div class="panel">
      <p>Item 1.</p>
      <p>SubItem 1.</p>
      <p>SubItem 1.</p>
    </div>

    <button class="accordion">Payment</button>
    <div class="panel">
      <b>Method:</b><p>Card</p>
      <b>Price:</b>&nbsp<p>18€</p>  
      <b>Paid:</b>&nbsp<p>20€</p>  
    </div>

    <button class="accordion">Client</button>
    <div class="panel">
      <b>Name:</b>&nbsp<p>XPTO</p>
      <b>Points:</b>&nbsp<p>5</p>
    </div>
      </div>
      
    
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-end"><strong>[Kitchen] OK</strong></button>
        <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal"><strong>[Delivery] OK</strong></button>
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
        <div class="column">
        <div class="title-left">
        <span>#1</span>
      </div>
    </div>
    <div class="column">
    <div class="title-center">
    <span style="color:#FF0000"> Cancelled</span>
        2022/12/12
        20:00
      </div>
    </div>
    <div class="column">
      <div class="title-right">
        <p>Jéssica Grácio</p>
      </div>
    </div>
    <button class="accordion">Items</button>
    <div class="panel">
      <p>Item 1.</p>
      <p>SubItem 1.</p>
      <p>SubItem 1.</p>
    </div>

    <button class="accordion">Payment</button>
    <div class="panel">
      <b>Method:</b><p>Card</p>
      <b>Price:</b>&nbsp<p>18€</p>  
      <b>Paid:</b>&nbsp<p>20€</p>  
    </div>

    <button class="accordion">Client</button>
    <div class="panel">
      <b>Name:</b>&nbsp<p>XPTO</p>
      <b>Points:</b>&nbsp<p>5</p>
    </div>
      </div>
      
    
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-end"><strong>[Kitchen] OK</strong></button>
        <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal"><strong>[Delivery] OK</strong></button>
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
        <div class="column">
        <div class="title-left">
        <span>#1</span>
      </div>
    </div>
    <div class="column">
    <div class="title-center">
    <span style="color:#FF0000"> Cancelled</span>
        2022/12/12
        20:00
      </div>
    </div>
    <div class="column">
      <div class="title-right">
        <p>Jéssica Grácio</p>
      </div>
    </div>
    <button class="accordion">Items</button>
    <div class="panel">
      <p>Item 1.</p>
      <p>SubItem 1.</p>
      <p>SubItem 1.</p>
    </div>

    <button class="accordion">Payment</button>
    <div class="panel">
      <b>Method:</b><p>Card</p>
      <b>Price:</b>&nbsp<p>18€</p>  
      <b>Paid:</b>&nbsp<p>20€</p>  
    </div>

    <button class="accordion">Client</button>
    <div class="panel">
      <b>Name:</b>&nbsp<p>XPTO</p>
      <b>Points:</b>&nbsp<p>5</p>
    </div>
      </div>
      
    
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-end"><strong>[Kitchen] OK</strong></button>
        <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal"><strong>[Delivery] OK</strong></button>
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
.title-left{
  text-align: left;
}
.title-right{
  text-align: right;
}

.title-center{
  text-align: center;
}

.accordion {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
}

.active, .accordion:hover {
  background-color: #ccc; 
}

.panel {
  padding: 0 18px;
  display: none;
  background-color: white;
  overflow: hidden;
}

</style>
  
  