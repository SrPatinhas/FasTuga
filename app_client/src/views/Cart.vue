<template>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
		<router-link class="btn " :to="{ name: 'Menus' }">
			<i class="bi-chevron-left"></i>
			Back to menu
		</router-link>
      	<h1 class="h2 text-uppercase text-bold">Bag</h1>
		<div class="empty-menu"></div>
    </div>
	<div class="row">
		<!-- Items in cart-->
		<div class="col-lg-8 col-md-7 pt-3 pt-sm-4">
			<cart-list/>
		</div>
		<!-- Sidebar-->
		<div class="col-lg-4 col-md-5 pt-3 pt-sm-4">
			<div class="card border-0 shadow-sm px-sm-4 py-4">
				<div class="text-center mb-4 pb-3 border-bottom">
					<h3 class="h5 mb-3 pb-1">Total</h3>
					<h4 class="fw-normal">{{ (orderStore.totalOrderCost).split(".")[0] }}.<small>{{ (orderStore.totalOrderCost).split(".")[1] }}</small></h4>
				</div>
				<div class="mb-4">
					<label class="form-label mb-3" for="order-comments"><span class="badge bg-info fs-xs me-2">Note</span>Additional comments</label>
					<textarea class="form-control" rows="4" id="order-comments" :disabled="orderStore.totalItems === 0" v-model="orderStore.order.notes" />
				</div>
				<router-link class="btn btn-primary btn-shadow d-block w-100 mt-4 mb-3" :to="{ name: 'Checkout' }" :class="{disabled: orderStore.totalItems == 0}">
					<i class="ci-card fs-lg me-2"></i>
					Proceed to Checkout
				</router-link>
			</div>
		</div>
	</div>
</template>

<script setup>
	import {useOrdersStore} from "@/stores/order";
	import CartList from "../components/order/cartList.vue";

	const orderStore = useOrdersStore();
</script>