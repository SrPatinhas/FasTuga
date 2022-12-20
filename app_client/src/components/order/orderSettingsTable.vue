<script setup>
	import {useOrdersStore} from "@/stores/order";
	import Pagination from "@/components/navigation/Pagination.vue";

	const orderStore = useOrdersStore();
	orderStore.fetchOrders();

	function updateOrders(newPage) {
		orderStore.fetchOrders(newPage);
	}
</script>

<template>
	<div v-if="orderStore.orders?.data?.length === 0">
		<div class="p-5 bg-faded-warning rounded-3">
			<div class="">
				<h1 class="fw-bold">No orders until now <i class="bi bi-emoji-frown fs-2 text-danger"></i></h1>
				<p class="col-md-8 fs-5">Create your first order by going to our menu and order some items</p>
				<router-link class="btn btn-primary btn-lg" :to="{ name: 'Menus' }">Menu</router-link>
			</div>
		</div>
	</div>
	<div v-else>
		<div class="table-responsive fs-md mb-4">
			<table class="table table-hover mb-0">
				<thead>
				<tr>
					<th>Created at</th>
					<th>ticket Number</th>
					<th>Total Price</th>
					<th>Points Gained</th>
					<th>Points Used to Pay</th>
					<th>Payment Type</th>
				</tr>
				</thead>
				<tbody>
				<tr v-for="(order,index) of orderStore.orders.data" :key="index">
					<td class="py-3">{{ order.created_at }}</td>
					<td class="py-3">{{ order.ticket_number }}</td>
					<td class="py-3">{{ order.total_price }}</td>
					<td class="py-3">{{ order.points_gained }}</td>
					<td class="py-3">{{ order.points_used_to_pay }}</td>
					<td class="py-3">{{ order.payment_type }}</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div v-if="orderStore.orders?.meta !== undefined">
			<Pagination @page-change="updateOrders" :pagination="orderStore.orders.meta"/>
		</div>
	</div>
</template>