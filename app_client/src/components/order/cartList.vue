<template>
	<div v-if="orderStore.totalItems > 0">
		<div class="card border-0 shadow-sm px-sm-4 py-4">
			<!-- Item-->
			<div v-for="(item, index) in orderStore.orderItems" :key="index" class="cart-item d-sm-flex justify-content-between align-items-center"
				 :class="{ 'mt-3': index > 0 && index < orderStore.orderItems.length, 'mb-4 pb-3 border-bottom': index != orderStore.orderItems.length - 1 }">
				<div class="d-block d-sm-flex align-items-center text-center text-sm-start">
					<div class="d-inline-block flex-shrink-0 mx-auto me-sm-4">
						<img :src="item.photo_url" width="120" alt="Pizza">
					</div>
					<div class="pt-2">
						<div class="fs-4 fw-medium mb-0 product-title">{{ item.name }}</div>
						<div v-if="item.type !== 'hot dish'">
							<label class="form-label" for="quantity1">Quantity</label>
							<div class="d-flex align-items-center width-110 justify-content-between">
								<button class="btn btn-icon btn-small" :disabled="item.quantity === 1" @click="updateItem(item, -1)">
									<i class="bi-dash"></i>
								</button>
								<span class="px-2">{{ item.quantity }}</span>
								<button class="btn btn-icon btn-small" @click="updateItem(item, 1)">
									<i class="bi-plus"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div  class="text-center">
					<div class="fs-3 text-black">
						€{{ (item.quantity * item.price).toFixed(2).split(".")[0] }}.<small>{{ (item.quantity * item.price).toFixed(2).split(".")[1] }}</small>
					</div>
					<a class="btn btn-link text-danger" data-bs-toggle="modal" data-bs-target="#deleteItemModal" @click="itemToDelete(item)">
						<i class="bi-trash me-2"></i>
						<span class="fs-sm">Remove</span>
					</a>
				</div>
			</div>
		</div>
		<div class="d-flex flex-row-reverse mt-3">
			<button class="btn btn-outline-danger" @click="showModalClearBag" data-bs-toggle="modal" data-bs-target="#clearBagModal">
				<i class="bi-trash me-2"></i> Clear all items from your bag
			</button>
		</div>
	</div>
	<div v-else>
		<div class="card border-0 shadow-sm p-5 mt-3">
			<h1>No items on your bag</h1>
			<p class="lead">Go to the menu to add items to your bag</p>
			<router-link class="btn btn-outline-primary" :to="{ name: 'Menus' }">
				<i class="bi-receipt"></i>
				Menu
			</router-link>
		</div>
	</div>

	<!-- Modal Confirm Delete Item -->
	<div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="deleteItemModalLabel">Delete {{ deleteItem.name }}?</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>This will remove the product <b>{{ deleteItem.name }}</b>.</p>
					<p>This item costs <b>€{{ (deleteItem.quantity * deleteItem.price).toFixed(2) }}</b>, that will be removed from your bag.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="confirmDeleteItem">Confirm</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Confirm Clear Bag -->
	<div class="modal fade" id="clearBagModal" tabindex="-1" aria-labelledby="clearBagModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="clearBagModalLabel">Clear your bag?</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>This will remove all <b>{{ orderStore.totalItems }}</b> products from your bag.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="confirmClearBag">Confirm</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
	import {useOrdersStore} from "@/stores/order";
	import {ref} from "vue";

	const orderStore = useOrdersStore();
	const OpenModal = ref(false);
	const OpenModalClearBag = ref(false);

	const deleteItem = ref({});

	// orderStore.updateQuantityItemOnOrder
	const updateItem = (item, quantity) => {
		if(item.quantity == 1 && quantity == -1){
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

	const showModalClearBag = () => {
		OpenModalClearBag.value = true
	}
	const confirmClearBag = () => {
		orderStore.cancelOrder();
	}
</script>