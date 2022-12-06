<template>
	<div v-if="orderStore.totalItems > 0">
		<!-- Item-->
		<div v-for="item of orderStore.orderItems" class="d-sm-flex justify-content-between align-items-center mt-3 mb-4 pb-3 border-bottom">
			<div class="d-block d-sm-flex align-items-center text-center text-sm-start"><a class="d-inline-block flex-shrink-0 mx-auto me-sm-4" href="#"><img src="img/food-delivery/cart/01.jpg" width="120" alt="Pizza"></a>
				<div class="pt-2">
					<h3 class="product-title fs-base mb-2"><a href="#">{{ item.name }}</a></h3>
					<div class="fs-sm"><span class="text-muted me-2">Size:</span>Medium</div>
					<div class="fs-sm"><span class="text-muted me-2">Base:</span>Standard</div>
					<div class="fs-lg text-accent pt-2">€{{ (item.count * item.price).toFixed(2).split(".")[0] }}.<small>{{ (item.count * item.price).toFixed(2).split(".")[1] }}</small></div>
				</div>
			</div>
			<div class="pt-2 pt-sm-0 ps-sm-3 mx-auto mx-sm-0 text-center text-sm-start" style="max-width: 9rem;">
				<label class="form-label" for="quantity1">Quantity</label>
				<div class="d-flex align-items-center gap-2">
					<button class="btn btn-icon" :disabled="item.count === 1" @click="updateItem(item, -1)">
						<i class="bi-dash"></i>
					</button>
					<span>{{ item.count }}</span>
					<button class="btn btn-icon" @click="updateItem(item, 1)">
						<i class="bi-plus"></i>
					</button>
				</div>
				<button class="btn btn-link px-0 text-danger" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" @click="itemToDelete(item)">
					<i class="ci-close-circle me-2"></i>
					<span class="fs-sm">Remove</span>
				</button>
			</div>
		</div>
	</div>
	<div v-else>
		<div class="bg-light p-5 rounded mt-3">
			<h1>No items on your bag</h1>
			<p class="lead">Go to the menu to add items to your bag</p>
			<router-link class="btn btn-outline-primary" :to="{ name: 'Menus' }">
				<i class="bi-receipt"></i>
				Menu
			</router-link>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel">Delete {{ deleteItem.name }}?</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>This will remove the product <b>{{ deleteItem.name }}</b>.</p>
					<p>This item costs <b>€{{ (deleteItem.count * deleteItem.price).toFixed(2) }}</b>, that will be removed from your bag.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="confirmDeleteItem">Confirm</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
	import {useOrdersStore} from "../../stores/order.js";
	import {ref} from "vue";

	const orderStore = useOrdersStore();
	const OpenModal = ref(false);


	const deleteItem = ref({});

	// orderStore.updateQuantityItemOnOrder
	const updateItem = (item, quantity) => {
		if(item.count == 1 && quantity == -1){
			OpenModal.value = true;
		} else {
			orderStore.updateQuantityItemOnOrder(item, quantity);
		}
	}
	const itemToDelete = (item) => {
	  	deleteItem.value = item;
	}
	const confirmDeleteItem = () => {
		orderStore.deleteItemOnOrder(deleteItem.value);
		deleteItem.value = {};
	}
</script>

<style scoped>

</style>