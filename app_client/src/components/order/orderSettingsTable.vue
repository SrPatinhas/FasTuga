<script setup>
	import {useOrdersStore} from "@/stores/order";
	import Pagination from "@/components/navigation/Pagination.vue";
	const orderStore = useOrdersStore();
	orderStore.fetchOrders();

	function updateOrders(newPage){
		orderStore.fetchOrders(newPage);
	}
</script>

<template>
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
	<div v-if="orderStore.orders.meta !== undefined">
		<Pagination @page-change="updateOrders"  :pagination="orderStore.orders.meta"/>
	</div>
</template>