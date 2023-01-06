<template>
	<div class="col">
		<div class="card h-100">
			<div class="card-header border-bottom">
				<div class="d-flex justify-content-between align-items-center">
					<h4 class="m-0"><span class="badge bg-info fw-normal">#{{ id }} - {{ ticket_number }}</span> <span class="fs-5 text-muted">{{ status_label }}</span></h4>
					<h5 class="m-0">
						{{ created_at }}
					</h5>
				</div>
			</div>
			<div class="card-body">
				<div v-if="items.length > 0" class="accordion_items">
					<div class="d-flex align-items-center mb-2 border-bottom fw-bold ">
						<span class="flex-1 mb-0 fw-bold">Item</span>
						<span class="mb-0 fw-bold">Status</span>
					</div>
					<div v-for="(item, index) in items" :key="index" class="py-2 border-bottom">
						<div class="d-flex align-items-center" :class="item.product_type !== 'hot dish' && status !== 'R' && 'opacity-25 text-decoration-line-through'">
							<span class="flex-1 mb-0" :class="item.product_type === 'hot dish' && status !== 'R' && 'text-600 fw-medium'">{{ item.order_local_number }} - {{ item.product_name }}</span>
							<span class="mb-0" v-if="item.product_type === 'hot dish' && status !== 'R'">
								<button class="btn btn-primary" @click="udpateItemStatus(item.id)" :disabled="item.status === 'R'">
									{{ (item.status === "W" ? 'Start Preparing' : (item.status === "P" ? 'Mark as Ready' : 'Done')) }}
								</button>
							</span>
							<span class="mb-0 text-muted" v-else>
								{{ item.status_label }}
							</span>
						</div>
						<div v-if="item.notes !== ''">
							{{ item.notes }}
						</div>
					</div>
				</div>
			</div>
			<div class="card-body" v-if="notes !== ''">
				{{ notes }}
			</div>
			<div class="card-footer text-center" v-if="status === 'R' && userStore.isDelivery">
				<button type="button" class="btn btn-primary m-auto" @click="udpateOrderStatus">
					Delivered to Customer
				</button>
			</div>
		</div>
	</div>
</template>

<script setup>
	import { inject } from 'vue';
	import {useUserStore} from "@/stores/user";
	const axios = inject('axios');
	const socket = inject("socket");
	const userStore = useUserStore();

	const emit = defineEmits(["updateList"])

	const order = defineProps({
		id: Number,
		user_id: Number,
		items: Array,
		created_at: String,
		date: String,
		status: String,
		status_label: String,
		ticket_number: String,
		update_at: String,
		notes: String,
	});

	async function udpateItemStatus(orderItemId) {
		try {
			const response = await axios.patch('orders/' + orderItemId + "/item/status");
			emit('updateList');
			if(response.data.order_status === "R"){
				socket.emit('orderUpdateStatus', order.user_id);
			}
			return true
		} catch (error) {
			return false
		}
	}
	async function udpateOrderStatus() {
		try {
			const response = await axios.patch('orders/' + order.id + "/status");
			if(response.data.order_status === "D"){
				emit('updateList');
				socket.emit('orderUpdateStatus', order.user_id);
			}
			return true;
		} catch (error) {
			return false;
		}
	}
</script>