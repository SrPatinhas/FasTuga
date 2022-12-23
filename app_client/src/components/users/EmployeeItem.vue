<template>
	<div class="align-items-center d-flex justify-content-between pb-3">
		<h2 class="h3 py-2 text-center text-sm-start">Employees</h2>
		<router-link class="btn btn-success" :to="{ name: 'CreateEmployee' }">+ Add Employee</router-link>
	</div>
	<div v-if="employeesLoading">
		<div class="p-5 bg-faded-info rounded-3">
			<div class="">
				<h1 class="align-items-center d-flex fw-bold justify-content-between">
					Loading Employees
					<span class="spinner-border text-primary" role="status">
							<span class="visually-hidden">Loading...</span>
						</span>
				</h1>
			</div>
		</div>
	</div>
	<div v-else-if="employees.length === 0">
		<div class="p-5 bg-faded-warning rounded-3">
			<div class="">
				<h1 class="fw-bold">No Employees to show <i class="bi bi-emoji-frown fs-2 text-danger"></i></h1>

				<div class="d-flex align-items-center px-4 py-3">
					<router-link class="btn btn-primary" :to="{ name: 'CreateEmployee' }">Add Employee</router-link>
				</div>
			</div>
		</div>
	</div>
	<div v-else>
		<div class="d-block d-sm-flex align-items-center py-4 border-bottom" v-for="(employee, index) of employees" :key="index">
			<div class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto width-110">
				<img :src="employee.photo_url || avatarNoneUrl" class="card-img-top" :alt="employee.name">
			</div>
			<div class="text-center text-sm-start flex-1">
				<h3 class="h6 product-title mb-2">{{ employee.name }} - {{ employee.email }}</h3>
				<div class="d-inline-block text-accent">
					<p>{{ employee.blocked ? 'Blocked' : 'Active' }}</p>
				</div>
				<div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">
					<div class="fw-medium">
						<p v-if="employee.type.toLowerCase() === 'em'">Type: Managers</p>
						<p v-if="employee.type.toLowerCase() === 'ec'">Type: Chefs</p>
						<p v-if="employee.type.toLowerCase() === 'ed'">Type: Delivery</p>
						<p v-if="employee.type.toLowerCase() === 'c'">Type: Customer</p>
					</div>
				</div>
			</div>
			<div class="btn-group btn-group-sm me-2" role="group" aria-label="First group">
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employee-detail" @click="fetchEmployee(employee.id)">
					<i class="bi bi-pencil m-0"></i>
				</button>
				<button type="button" class="btn btn-warning text-white" @click="employeeToggleBlock(employee.id, !employee.blocked)">
					<i class="bi m-0" :class="employee.blocked ? 'bi-lock-fill' : 'bi-unlock-fill'"></i>
				</button>
				<button type="button" class="btn btn-danger" aria-label="Delete" @click="employeeDelete(employee.id)">
					<i class="bi bi-trash m-0"></i>
				</button>
			</div>
		</div>
		<div v-if="pagination !== undefined">
			<Pagination @page-change="updateEmployees" :pagination="pagination"/>
		</div>
	</div>


	<div class="modal fade" id="employee-detail" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit user - {{ employeeDetail.name }}</h5>
				</div>
				<div class="modal-body">
					<div class="row gx-4 gy-3">
						<div class="col-12">
							<label class="form-label" for="ticket-subject">Name</label>
							<input class="form-control" type="text" id="ticket-subject" required v-model="employeeDetail.name">
							<label class="form-label" for="ticket-subject">Email</label>
							<input class="form-control" type="text" id="ticket-subject" required v-model="employeeDetail.email">
							<div class="invalid-feedback">Please fill in the name!</div>
						</div>
						<div class="col-sm-6">
							<label class="form-label" for="ticket-type">Type</label>
							<select class="form-select" id="ticket-type" required="" v-model="employeeDetail.type">
								<option selected value="">Select a role</option>
								<option value="ED">Delivery</option>
								<option value="EC">Chef</option>
								<option value="EM">Manager</option>
							</select>
							<div class="invalid-feedback">Please choose ticket type!</div>
						</div>
						<div class="col-12" id="inputPhoto">
							<PhotoUploader @image-change="changeUploadImage" :url-old="employeeDetail.photo_url"/>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
					<button class="btn btn-primary" type="submit" @click="SaveEmployee(employeeDetail.id)" data-bs-dismiss="modal">
						Save</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
	import {ref, inject} from 'vue';
	const axios = inject('axios');

	import avatarNoneUrl from '@/assets/avatar-none.png';
	import PhotoUploader from "@/components/global/photoUploader.vue";
	import Pagination from "@/components/navigation/Pagination.vue";
	import {RouterLink} from "vue-router"

	const employeeDetail = ref({});
	const pagination = ref({});
	const employees = ref([]);
	const employeesLoading = ref(true);
	const hasNewPhoto = ref(false);

	async function fetchEmployees(page = 1) {
		try {
			employeesLoading.value = true;
			const response = await axios.get('/employees?page=' + page);
			employees.value = response.data.data;
			pagination.value = response.data.meta;
			employeesLoading.value = false;
			return employees.value;
		} catch (error) {
			employees.value = [];
			employeeDetail.value = {};
			employeesLoading.value = false;
			throw error;
		}
	}

	
	const changeUploadImage = (image) => {
		employeeDetail.value.photo = image;
		hasNewPhoto.value = true;
	}

	function updateEmployees(newPage) {
		fetchEmployees(newPage);
	}

	async function fetchEmployee(id) {
		try {
			const response = await axios.get('/employees/' + id);
			employeeDetail.value = response.data.data;
			return employeeDetail.value;
		} catch (error) {
			employeeDetail.value = {};
			throw error;
		}
	}

	async function employeeToggleBlock(id, isToBlock) {
		try {
			await axios.patch('users/' + id + (isToBlock ? "/block" : "/unblock"));
			await fetchEmployees();
			return true
		} catch (error) {
			return false
		}
	}

	async function employeeDelete(id) {
		try {
			await axios.delete('employees/' + id);
			await fetchEmployees();
			return true
		} catch (error) {
			return false
		}
	}

	async function SaveEmployee() {
		try {
			//employeeDelete.value.loading = true;
			const formData = new FormData();
			formData.append('_method', 'PUT');
			if (employeeDetail.value.photo != null) {
				formData.append('photo', employeeDetail.value.photo);
			}
			for (const [key, value] of Object.entries(employeeDetail.value)) {
				if (key !== "photo" && key !== "photo_url") {
					formData.append(key, value);
				}
			}
			const response = await axios.post('employees/' + employeeDetail.value.id, formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			});
			fetchEmployees();
			if(response.status === 200) {
				socket.emit('newEmployee');
				fetchEmployees();
				//updateEmployees(1);
				//document.getElementById("closeModalEdit").
				click();
			}
			//employeeDelete.value.loading = false;
			return true;
		} catch (error) {
			//employeeDelete.value.loading = false;
			return false;
		}
	}

	fetchEmployees();
</script>
