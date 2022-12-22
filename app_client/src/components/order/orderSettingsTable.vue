<script setup>
	import {ref, inject, computed} from 'vue';
	import { useUserStore } from "@/stores/user";
	import Pagination from "@/components/navigation/Pagination.vue";
	import OrderDetailItem from "@/components/order/orderDetailItem.vue";

	const userStore = useUserStore();
	const axios = inject('axios');

	const orders = ref([]);
	const pagination = ref({});
	const orderDetail = ref({});
	const ordersLoading = ref(true);

	const orderToDelete = ref({});

	function updateOrders(newPage) {
		fetchOrders(newPage);
	}

	async function fetchOrders(page = 1) {
        try {
			ordersLoading.value = true;
            const response = await axios.get('/orders?page=' + page);
            orders.value = response.data.data;
			pagination.value = response.data.meta;
			ordersLoading.value = false;
            return orders.value;
        } catch (error){
            orders.value = [];
			orderDetail.value = {};
			ordersLoading.value = false;
            throw error;
        }
    } 

	fetchOrders();

	const countingOrders = computed(() => {
		return orders.value.length;
	});

	async function deleteOrders () {
		try {
			await axios.delete('orders/' + orderToDelete.value.id);
			await fetchOrders();
			return true
		} catch (error) {
			return false
		}
	}
	function seeOrderDetail(order) {
		orderDetail.value = order;
	}
	function modalDeleteOrders(order) {
		orderToDelete.value = order;
	}
</script>

<template>
	<div v-if="ordersLoading">
		<div class="p-5 bg-faded-info rounded-3">
			<div class="">
				<h1 class="align-items-center d-flex fw-bold justify-content-between">
					Loading orders
					<span class="spinner-border text-primary" role="status">
						<span class="visually-hidden">Loading...</span>
					</span>
				</h1>
			</div>
		</div>
	</div>
	<div v-else-if="countingOrders === 0">
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
					<th>Actions</th>
				</tr>
				</thead>
				<tbody>
				<tr v-for="(order, index) of orders" :key="index">
					<td class="py-3">{{ order.created_at }}</td>
					<td class="py-3">{{ order.ticket_number }}</td>
					<td class="py-3">{{ order.total_price }}</td>
					<td class="py-3">{{ order.points_gained }}</td>
					<td class="py-3">{{ order.points_used_to_pay }}</td>
					<td class="py-3">{{ order.payment_type }}</td>
					<td class="py-3">
						<div class="btn-group me-2" role="group" aria-label="Actions">
							<a class="btn btn-outline-success" href="#order-details" data-bs-toggle="modal" @click="seeOrderDetail(order)">
								<i class="bi bi-eye m-0"></i>
							</a>
							<a v-if="userStore.isManager && order.status.toLowerCase() !== 'd'"  href="#cancelling-order" data-bs-toggle="modal" class="btn btn-outline-danger" @click="modalDeleteOrders(order)">
								<i class="bi bi-trash m-0"></i>
							</a>
						</div>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div v-if="pagination !== undefined">
			<Pagination v-if="pagination.last_page > 1" @page-change="updateOrders" :pagination="pagination"/>
		</div>
	</div>


	<div class="modal fade" id="order-details" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content" v-if="orderDetail.id !== undefined">
				<div class="modal-header">
					<h5 class="modal-title">Order No - {{ orderDetail.id }}</h5>
					<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pb-0 last-item-no-border">
					<order-detail-item v-for="item of orderDetail.items" v-bind="item" />
				</div>
				<!-- Footer-->
				<div class="modal-footer flex-wrap justify-content-between bg-secondary fs-md">
					<div class="px-2 py-1"><span class="text-muted">Subtotal:&nbsp;</span><span>{{ orderDetail?.total_price.toFixed(2) }}€</span></div>
					<div class="px-2 py-1"><span class="text-muted">Points earned:&nbsp;</span><span>{{ orderDetail.points_gained }}</span></div>
					<div class="px-2 py-1"><span class="text-muted">Discount:&nbsp;</span><span>{{ orderDetail?.total_paid_with_points.toFixed(2) }}€</span></div>
					<div class="px-2 py-1"><span class="text-muted">Total:&nbsp;</span><span class="fs-lg">{{ orderDetail?.total_paid.toFixed(2) }}€</span></div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="cancelling-order" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content" v-if="orderToDelete.id != undefined">
				<div class="modal-header">
					<h5 class="modal-title">Cancel Order - {{ orderToDelete.ticket_number }} </h5>
					<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row gx-4 gy-3">
						<div class="col-12">
							<label class="form-label" for="ticket-subject">Do you want cancel this order?</label>
							<p>It has <b>{{ orderToDelete.items.length }}</b> items and it costed <b>{{ orderToDelete.total_paid.toFixed(2) }}</b></p>
							<div class="modal-footer">
								<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">No</button>
								<button class="btn btn-primary" type="submit" @click="deleteOrders(orderDetail.id)">Yes
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
</template>