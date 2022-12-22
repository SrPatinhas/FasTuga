<script setup>
	import {useOrdersStore} from "@/stores/order";
	import {ref, reactive, inject, computed} from 'vue';
	import Pagination from "@/components/navigation/Pagination.vue";

	const axios = inject('axios');

	const orders = ref([]);

	function updateOrders(newPage) {
		fetchOrders(newPage);
	}

	async function fetchOrders(page = 1) {
        try {
            const response = await axios.get('/orders?page=' + page);
            orders.value = response.data;
            return orders.value;
        } catch (error){
            orders.value = {};
            throw error;
        }
    } 

	fetchOrders();

	const countingOrders = computed(() => {
		return orders.value.length;
	});

	async function deleteOrders (id) {
		try {
			const formData = new FormData();
			for (const [key, value] of Object.entries(order)) {
						formData.append(key, value);
			}
			const response = await axios.delete('orders/' + id, formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			});
			fetchOrders()
			return true
		} catch (error) {
			return false
		}
	}

</script>

<template>
	<div v-if="countingOrders === 0">
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
					<th>Cancel</th>
				</tr>
				</thead>
				<tbody>
				<tr v-for="(order,index) of orders.data" :key="index">
					<td class="py-3">{{ order.created_at }}</td>
					<td class="py-3">{{ order.ticket_number }}</td>
					<td class="py-3">{{ order.total_price }}</td>
					<td class="py-3">{{ order.points_gained }}</td>
					<td class="py-3">{{ order.points_used_to_pay }}</td>
					<td class="py-3">{{ order.payment_type }}</td>
					<td class="py-3">
						<button class="btn bg-faded-danger btn-icon" type="button" @click="deleteOrders(order.id)"> 
						<i class="bi bi-x-circle-fill"></i>
						</button>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div v-if="orders?.meta !== undefined">
			<Pagination @page-change="updateOrders" :pagination="orders.meta"/>
		</div>
	</div>

		<!--<div class="modal fade" id="cancelling-order" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Cancel Order - {{ order.ticket_number }} </h5>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row gx-4 gy-3">
                <div class="col-12">
                  <label class="form-label" for="ticket-subject">Do you want cancel this order?</label>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">No</button>
              <button class="btn btn-primary" type="submit" @click="deleteOrders(order.id)" >Yes</button>
            </div>
          </div>
        </div>
      </div>
	</div>
      </div>
	</div>-->

	
</template>