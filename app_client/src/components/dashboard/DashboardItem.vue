<template>
<div class="card">
  <div class="row">
    <div class="column">
    <div class="modal modal-alert position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalChoice">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-3 shadow">
      <div class="modal-body p-4 text-center">
        <div class="column">
        <div class="title-left"> {{ id }} </div>
    </div>
    <div class="column">
    <div class="title-center"><span style="color:#FF0000"> {{ status }} </span>
      {{ date }}
      </div>
    </div>
    <div class="column">
      <div class="title-right">
        <p> {{ employeeName }} </p>
      </div>
    </div>
    <!--<div v-if="orderStore.totalItems > 0" button class="accordion_items">
		<div v-for="(item, index) in orderStore.orderItems"
			 :key="index" 
       class="d-sm-flex justify-content-between align-items-center" :class="{ 'mt-3': index > 0 && index < orderStore.orderItems.length, 'mb-4 pb-3 border-bottom': index != orderStore.orderItems.length - 1 }">
       <button class="accordion">Items</button>
       <div class="panel">
       <h5 class="card-title">{{ itemName }} </h5>
			<p class="card-text text-muted">{{ itemDescription }}</p>
    -->
  </div>
    <button class="accordion">Payment</button>
    <div class="panel">
      <b>Method:</b><p>{{ method }}</p>
      <b>Price:</b>&nbsp<p>{{ price }}</p>  
      <b>Paid:</b>&nbsp<p>{{ paid }}</p>  
    </div>

    <button class="accordion">Client</button>
    <div class="panel">
      <b>Name:</b>&nbsp<p>{{ clientName}}</p>
      <b>Points:</b>&nbsp<p> {{ numberOfPoints}}</p>
    </div>
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
</template>

<script setup>

  const item =defineProps({
		id: Number,
		status: String,
		employeeName: String,
		method: String,
    price: Number,
		Paid: String,
		clientName: String,
    numberOfPoints: Number
	});
  
</script>