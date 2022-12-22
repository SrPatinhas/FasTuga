<script setup>
	  import {ref, computed, inject} from 'vue';
	import {useUserStore} from "@/stores/user.js";
	import avatarNoneUrl from '@/assets/avatar-none.png';
	import Pagination from "@/components/navigation/Pagination.vue";

	const axios = inject('axios');
	const customer = ref();
	const customers = ref([]);
	
	function updateUsers(newPage) {
		fetchCustomers(newPage);
	}

	async function fetchCustomers(page = 1) {
		try {
			const response = await axios.get('/customers?page=' + page);
			customers.value = response.data;
			return customers.value;
		} catch (error){
			customers.value = {};
			throw error;
		}
	}

	fetchCustomers()
</script>

<template>
	<div class="d-block d-sm-flex align-items-center py-4 border-bottom" v-for="(customer, index) of customers.data" :key="index">
		<div class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto" style="width: 12.5rem;">
				<img v-if="customer.user.photo_url==''" :src="avatarNoneUrl" class="card-img-top" :alt="name">
				<img v-else :src="customer.user.photo_url" class="card-img-top" :alt="name">
			</div>
			<div class="text-center text-sm-start">
				<h3 class="h6 product-title mb-2">{{ customer.user.name }} - {{ customer.user.email }}</h3>
				<div class="d-inline-block text-accent">
					<p v-if="customer.user.blocked==0">Active</p>
    				<p v-else-if="customer.user.blocked==1">Blocked</p>
				</div>
				<div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">
					<span class="fw-medium"> 
						<p v-if="customer.user.type=='EM'">Type: Managers</p>
						<p v-if="customer.user.type=='EC'">Type: Chefs</p>
						<p v-if="customer.user.type=='ED'">Type: Delivery</p>
						<p v-if="customer.user.type=='C'">Type: Customer</p>
					</span>
				</div>
				<div class="d-flex justify-content-center justify-content-sm-start pt-3">
					<button class="btn bg-faded-info btn-icon me-2" type="button" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit">
						<i class="bi bi-pencil-square"></i>
					</button>
					<button class="btn bg-faded-danger btn-icon" type="button" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
						<i class="bi bi-trash"></i>
					</button>
				</div>
			</div>
		</div>
		<div v-if="customers?.meta !== undefined">
			<Pagination @page-change="updateUsers" :pagination="customers.meta"/>
		</div>
</template>