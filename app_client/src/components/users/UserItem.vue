<script setup>
	import {ref} from "vue";
	import {useUserStore} from "@/stores/user.js";
	import avatarNoneUrl from '@/assets/avatar-none.png';

	const userStore = useUserStore();
	userStore.fetchCustomers();
	userStore.fetchEmployees();
	const userTypeActive = ref('C');

	function changeTab(type) {
		userTypeActive.value = type;
		setTimeout(function () {
			window.scrollTo(0, 0);
		}, 100);
	}

	function updateUsers(newPage) {
		userStore.fetchCustomers(newPage);
	}
</script>

<template>

	<!--<li class="nav-item" role="presentation" v-for="(customer, index) of userStore.customers.data" :key="index">
		<button class="nav-link btn rounded-pill d-flex gap-2 align-items-center"
				:class="(userTypeActive === userType.type ? 'btn-secondary active' : 'btn-outline-secondary')"
				:id="'pills-' + userType.type.replace(' ', '_') + '-tab'" type="button"
				data-bs-toggle="tab" :data-bs-target="'#' + userType.type.replace(' ', '_') + '-tab-pane'"
				role="tab" :aria-controls="userType.type.replace(' ', '_') + '-tab-pane'" :aria-selected="userTypeActive === userType.type"
				@click="changeTab(userType.type)">
			<i :class="'bi ' + userType.icon"></i>
			{{ userType.type }}
			<span class="badge" :class="userTypeActive === userType.type ? 'bg-white text-primary' : 'bg-primary'">
				{{ userStore.getProductsByFilterTotal(userType.type) }}
			</span>
		</button>-->

		<li class="nav-item" role="presentation" v-for="(customer, index) of userStore.customers.data" :key="index">
		<button class="nav-link btn rounded-pill d-flex gap-2 align-items-center"
				:class="(userTypeActive === customer.user.type ? 'btn-secondary active' : 'btn-outline-secondary')"
				:id="'pills-' + customer.user.type.replace(' ', '_') + '-tab'" type="button"
				data-bs-toggle="tab" :data-bs-target="'#' + customer.user.type.replace(' ', '_') + '-tab-pane'"
				role="tab" :aria-controls="customer.user.type.replace(' ', '_') + '-tab-pane'" :aria-selected="userTypeActive === customer.user.type"
				@click="changeTab(customer.user.type)">
			<i :class="'bi ' + customer.user.type.icon"></i>
			{{ customer.user.type }}
			<span class="badge" :class="userTypeActive === customer.user.type ? 'bg-white text-primary' : 'bg-primary'">
				{{ userStore.getUsersByFilterTotal(customer.user.type) }}
			</span>
		</button>	
		</li>

	<div class="d-block d-sm-flex align-items-center py-4 border-bottom" v-for="(customer, index) of userStore.customers.data" :key="index">
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

		<!--<div v-if="userStore.users?.meta !== undefined">
			<Pagination @page-change="updateUsers" :pagination="userStore.users.meta"/>
		</div>-->
</template>