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
				<button type="button" class="btn btn-secondary text-white" aria-label="Edit">
					<i class="bi bi-pencil-square m-0"></i>
				</button>
				<button type="button" class="btn btn-warning text-white" aria-label="Edit">
					<i class="bi bi-lock m-0"></i>
				</button>
				<button type="button" class="btn btn-danger text-white" aria-label="Delete">
					<i class="bi bi-trash m-0"></i>
				</button>
			</div>
		</div>
		<div v-if="pagination !== undefined">
			<Pagination v-if="pagination.last_page > 1" @page-change="updateUsers" :pagination="pagination"/>
		</div>
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

	fetchCustomers();
</script>