<template>
	<section class="pt-4">
		<div v-if="topProducts.length > 0">
			<h2 class="text-center pt-4 pt-sm-3">Your most bought on this restaurant</h2>
			<p class="text-muted text-center">Buy again if you liked it</p>
			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
				<ProductItemTop v-for="(food, index) of topProducts" :key="'trending_' + index" v-bind="food"/>
			</div>
		</div>
		<div v-if="lastOrders.length > 0" class="mt-4">
			<h2 class="text-center pt-4 pt-sm-3">Your last orders on this restaurant</h2>
			<p class="text-muted text-center">Check what you most buy</p>
			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
				<OrderLast v-for="(orders, index) of lastOrders" :key="'trending_' + index" v-bind="orders"/>
			</div>
		</div>
	</section>
</template>

<script setup>
	import ProductItemTop from "@/components/products/ProductItemTop.vue";
	import OrderLast from "@/components/order/orderLast.vue";
	import {inject, ref} from "vue";
	import {useUserStore} from "@/stores/user";
	const axios = inject('axios');
	const userStore = useUserStore();


	const topProducts = ref([]);
	const lastOrders = ref([]);

	if(userStore.isCustomer) {
		loadTopProducts();
		loadLastOrders();
	}
	async function loadTopProducts() {
		try {
			const response = await axios.get('customers/top-products');
			topProducts.value = response.data.data
		} catch (error) {
			topProducts.value = [];
			throw error
		}
	}
	async function loadLastOrders() {
		try {
			const response = await axios.get('customers/last-orders');
			lastOrders.value = response.data.data
		} catch (error) {
			lastOrders.value = [];
			throw error
		}
	}
</script>

<style scoped>

</style>