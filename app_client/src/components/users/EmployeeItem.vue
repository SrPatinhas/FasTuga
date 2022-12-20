<script setup>
	import {useUserStore} from "@/stores/user.js";
	import avatarNoneUrl from '@/assets/avatar-none.png';
	import Pagination from "@/components/navigation/Pagination.vue";

	const userStore = useUserStore();
	userStore.fetchEmployees();

	function updateEmployees(newPage) {
		userStore.fetchEmployees(newPage);
	}
</script>

<template>
	<div class="d-block d-sm-flex align-items-center py-4 border-bottom" v-for="(employee, index) of userStore.employees.data" :key="index">
		<div class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto" style="width: 12.5rem;">
				<img v-if="employee.photo_url==''" :src="avatarNoneUrl" class="card-img-top" :alt="name">
				<img v-else :src="employee.photo_url" class="card-img-top" :alt="name">
			</div>
			<div class="text-center text-sm-start">
				<h3 class="h6 product-title mb-2">{{ employee.name }} - {{ employee.email }}</h3>
				<div class="d-inline-block text-accent">
					<p v-if="employee.blocked==0">Active</p>
    				<p v-else-if="employee.blocked==1">Blocked</p>
				</div>
				<div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">
					<span class="fw-medium"> 
						<p v-if="employee.type=='EM'">Type: Managers</p>
						<p v-if="employee.type=='EC'">Type: Chefs</p>
						<p v-if="employee.type=='ED'">Type: Delivery</p>
						<p v-if="employee.type=='C'">Type: Customer</p>
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

		<div v-if="userStore.employees?.meta !== undefined">
			<Pagination @page-change="updateEmployees" :pagination="userStore.employees.meta"/>
		</div>
</template>