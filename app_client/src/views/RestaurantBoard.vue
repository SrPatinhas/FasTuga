<template>
	<section>
		<div class="sticky-header">
			<h4 class="text-uppercase text-bold">Restaurant Board</h4>
			<ul class="nav nav-pills tabs-filter gap-4">
				<li class="nav-item" role="presentation">
					<button class="nav-link btn rounded-pill d-flex gap-2 align-items-center" id="pills-kitchen-tab" type="button"
							:class="(orderKitchenPlaceActive === 'Kitchen' ? 'btn-secondary active' : 'btn-outline-secondary')"
							@click="orderKitchenPlaceActive = 'Kitchen'">
						Kitchen
						<span class="badge " :class="orderKitchenPlaceActive === 'Kitchen' ? 'bg-white text-primary' : 'bg-primary'">{{ filterOrderKitchen.length }}</span>
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link btn rounded-pill d-flex gap-2 align-items-center" id="pills-delivering-tab" type="button"
							:class="(orderKitchenPlaceActive === 'Delivering' ? 'btn-secondary active' : 'btn-outline-secondary')"
							@click="orderKitchenPlaceActive = 'Delivering'">
						Delivering
						<span class="badge " :class="orderKitchenPlaceActive === 'Delivering' ? 'bg-white text-primary' : 'bg-primary'">{{ filterOrderDelivering.length }}</span>
					</button>
				</li>
			</ul>
			<div class="width-150"></div>
		</div>
		<div v-if="orderKitchenPlaceActive === 'Kitchen'" class="m-0 mt-5 row row-cols-3">
			<RestaurantBoardItem v-for="(item, index) of filterOrderKitchen" :key="index" v-bind="item" @update-list="fetchOrders" />
		</div>
		<div v-if="orderKitchenPlaceActive === 'Delivering'" class="m-0 mt-5 row row-cols-3">
			<RestaurantBoardItem v-for="(item, index) of filterOrderDelivering" :key="index" v-bind="item" @update-list="fetchOrders" />
		</div>
	</section>
</template>

<script setup>
	import {ref, inject, computed} from 'vue';
	import RestaurantBoardItem from "@/components/restaurantBoard/RestaurantBoardItem.vue";
	const axios = inject('axios');
	const socket = inject("socket");

	const orderKitchenPlaceActive = ref('Kitchen');
	const orderKitchenList = ref([]);
	const ordersLoading = ref(true);

	const filterOrderKitchen = computed(() => {
		return orderKitchenList.value.filter((item) => {
			if(item.items.length > 0 && item.status !== "R"){
				return item.items.filter((prod) => {
					return prod.product_type === 'hot dish' && prod.status !== 'R'
				}).length > 0;
			}
			return false;
		});
	});
	const filterOrderDelivering = computed(() => {
		return orderKitchenList.value.filter((item) => item.status.toLowerCase() === "r");
	});

	async function fetchOrders() {
		try {
			ordersLoading.value = true;
			const response = await axios.get('/orders/restaurant');
			orderKitchenList.value = response.data.data;
			ordersLoading.value = false;
			return true;
		} catch (error){
			orderKitchenList.value = [];
			ordersLoading.value = false;
			throw error;
		}
	}
	fetchOrders();

	socket.on('orderNew', () => {
		fetchOrders();
	});
</script>