<template>
	<section>
		<h4 class="text-uppercase text-bold">Public Board</h4>

		<div class="row row-cols-2 mt-3 m-0">
			<div class="col border-end border-r-2">
				<div class="bg-white m-auto mb-3 p-2 shadow-sm text-center w-75 fs-3">
					Preparing<span class="badge bg-primary mx-2">{{ filterOrder_Preparing }}</span>
				</div>
				<div v-if="ordersLoading">
					<h1 class="align-items-center d-flex fw-bold justify-content-around">
						Loading orders Preparing
						<span class="spinner-border text-primary" role="status">
						<span class="visually-hidden">Loading...</span>
					</span>
					</h1>
				</div>
				<div v-else class="column px-2 row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
					<PublicBoardItem v-for="(item, index) of orderList.preparing" v-bind="item" :key="index"/>
				</div>
			</div>
			<div class="col">
				<div class="bg-white m-auto mb-3 p-2 shadow-sm text-center w-75 fs-3">
					Ready<span class="badge bg-primary mx-2">{{ filterOrder_Ready }}</span>
				</div>
				<div v-if="ordersLoading">
					<h1 class="align-items-center d-flex fw-bold justify-content-around">
						Loading orders Ready
						<span class="spinner-border text-primary" role="status">
						<span class="visually-hidden">Loading...</span>
					</span>
					</h1>
				</div>
				<div v-else class="column px-2 row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
					<PublicBoardItem v-for="(item, index) of orderList.ready" v-bind="item" :key="index"/>
				</div>
			</div>
		</div>
	</section>
</template>

<script setup>
	import {ref, computed, inject} from 'vue'
	import PublicBoardItem from "@/components/publicboard/PublicBoardItem.vue";

	const axios = inject('axios');
	const socket = inject("socket");

	const orderList = ref([]);
	const ordersLoading = ref(true);

	const filterOrder_Preparing = computed(() => {
		if(orderList.value.preparing === undefined){
			return 0;
		}
		return orderList.value.preparing.length;
	});

	const filterOrder_Ready = computed(() => {
		if(orderList.value.ready === undefined){
			return 0;
		}
		return orderList.value.ready.length;
	});

	async function fetchOrders() {
		try {
			ordersLoading.value = true;
			const response = await axios.get('/orders/board');
			orderList.value = response.data;
			ordersLoading.value = false;
			return true;
		} catch (error){
			orderList.value = [];
			ordersLoading.value = false;
			throw error;
		}
	}
	fetchOrders();

	socket.on('orderNew', () => {
		fetchOrders();
	});
</script>