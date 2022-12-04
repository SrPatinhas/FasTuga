<template>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<router-link class="btn " :to="{ name: 'Menus' }">
			<i class="bi-chevron-left"></i>
			Back to menu
		</router-link>
      	<h1 class="h2 text-uppercase text-bold">Bag</h1>
		<div></div>
    </div>
	<div class="px-3 px-sm-4 px-xl-5 pt-1 pb-4 pb-sm-5">
		<div class="row">
			<!-- Items in cart-->
			<div class="col-lg-8 col-md-7 pt-sm-2">
				<cart-list/>
			</div>
			<!-- Sidebar-->
			<div class="col-lg-4 col-md-5 pt-3 pt-sm-4">
				<div class="rounded-3 bg-secondary bg-opacity-10 px-3 px-sm-4 py-4">
					<div class="text-center mb-4 pb-3 border-bottom">
						<h3 class="h5 mb-3 pb-1">Total</h3>
						<h4 class="fw-normal">{{ (orderStore.totalOrderCost).split(".")[0] }}.<small>{{ (orderStore.totalOrderCost).split(".")[1] }}</small></h4>
					</div>
					<div class="mb-4">
						<label class="form-label mb-3" for="order-comments"><span class="badge bg-info fs-xs me-2">Note</span>Additional comments</label>
						<textarea class="form-control" rows="4" id="order-comments"></textarea>
					</div>
					<h3 class="h6 mb-4">Apply promo code</h3>
					<form class="needs-validation" method="post" novalidate="">
						<div class="mb-3">
							<input class="form-control" type="text" placeholder="Promo code" required="">
							<div class="invalid-feedback">Please provide promo code.</div>
						</div>
						<button class="btn btn-outline-primary d-block w-100" type="submit">Apply promo code</button>
					</form><a class="btn btn-primary btn-shadow d-block w-100 mt-4 mb-3" href="food-delivery-checkout.html"><i class="ci-card fs-lg me-2"></i>Proceed to Checkout</a>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
	import {useOrdersStore} from "../stores/order.js";
	import CartList from "../components/order/cartList.vue";

	const orderStore = useOrdersStore();
</script>