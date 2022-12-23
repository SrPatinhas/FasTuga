<template>
	<div v-if="customersLoading">
		<div class="p-5 bg-faded-info rounded-3">
			<div class="">
				<h1 class="align-items-center d-flex fw-bold justify-content-between">
					Loading Customers
					<span class="spinner-border text-primary" role="status">
							<span class="visually-hidden">Loading...</span>
						</span>
				</h1>
			</div>
		</div>
	</div>
	<div v-else-if="customers.length === 0">
		<div class="p-5 bg-faded-warning rounded-3">
			<div class="">
				<h1 class="fw-bold">No Customers to show <i class="bi bi-emoji-frown fs-2 text-danger"></i></h1>
			</div>
		</div>
	</div>
	<div v-else>
		<div class="d-block d-sm-flex align-items-center py-4 border-bottom" v-for="(customer, index) of customers" :key="index">
			<div class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto width-110">
				<img :src="customer.user.photo_url || avatarNoneUrl" class="card-img-top" :alt="customer.user.name">
			</div>
			<div class="text-center text-sm-start flex-1">
				<h3 class="h6 product-title mb-2">{{ customer.user.name }} - {{ customer.user.email }}</h3>
				<div class="d-inline-block text-accent">
					<p>{{ customer.user.blocked ? 'Blocked' : 'Active' }}</p>
				</div>
				<div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">
					<div class="fw-medium">
						<p>Number of Orders: {{ customer.orders }}</p>
					</div>
				</div>
			</div>
			<div class="btn-group me-2" role="group" aria-label="First group">
				<button type="button" class="btn btn-secondary text-white" aria-label="Edit" data-bs-toggle="modal" data-bs-target="#customer-detail" @click="fetchCustomer(customer.id)">
					<i class="bi bi-eye"></i>
				</button>
				<button type="button" class="btn btn-warning text-white" aria-label="Edit" @click="customerToggleBlock(customer.user_id, !customer.user.blocked)">
					<i class="bi m-0" :class="customer.user.blocked ? 'bi-lock-fill' : 'bi-unlock-fill'"></i>
				</button>
			</div> 	
		</div>
		<div v-if="pagination !== undefined">
			<Pagination v-if="pagination.last_page > 1" @page-change="updateUsers" :pagination="pagination"/>
		</div>
	</div>


	<div class="modal fade" id="customer-detail" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">View details of customer</h5>
				</div>
				<div class="modal-body">
					<div class="row gx-4 gy-3">
						<div class="col-12">
							<p></p><label class="form-label"><b>Points:</b> {{ customerDetail.points }}</label>
							<p></p><label class="form-label"><b>NIF:</b> {{ customerDetail.nif }}</label>
							<p></p><label class="form-label"><b>Default payment type:</b> {{ customerDetail.default_payment_type }}</label>
							<p></p><label class="form-label"><b>Default payment reference:</b> {{ customerDetail.default_payment_reference }}</label>
							<p></p><label class="form-label"><b>NIF:</b> {{ customerDetail.nif }}</label>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
					</div>
				</div>

				<div class="modal fade" id="delete-product" tabindex="-1" aria-hidden="true">
	</div>

</template>

<script setup>
	import {ref, inject} from 'vue';
	import avatarNoneUrl from '@/assets/avatar-none.png';
	import Pagination from "@/components/navigation/Pagination.vue";

	const axios = inject('axios');
	const customers = ref([]);
	const pagination = ref({});
	const customer = ref({});
	const customerDetail = ref({});
	const customersLoading = ref(true);

	async function fetchCustomers(page = 1) {
		try {
			customersLoading.value = true;
			const response = await axios.get('/customers?page=' + page);
			customers.value = response.data.data;
			pagination.value = response.data.meta;
			customersLoading.value = false;
			return customers.value;
		} catch (error) {
			customersLoading.value = false;
			customers.value = [];
			customer.value = {};
			throw error;
		}
	}

	function updateUsers(newPage) {
		fetchCustomers(newPage);
	}

	async function fetchCustomer(id) {
		try {
			const response = await axios.get('/customers/' + id);
			customerDetail.value = response.data.data;
			return true;
		} catch (error) {
			customerDetail.value = {};
			throw error;
		}
	}
	
	
	async function customerToggleBlock(id, isToBlock) {
		try {
			await axios.patch('users/' + id + (isToBlock ? "/block" : "/unblock"));
			await fetchCustomers();
			return true
		} catch (error) {
			return false
		}
	}


	fetchCustomers();
</script>