<script setup>
  import {ref, computed, inject} from 'vue';
	import avatarNoneUrl from '@/assets/avatar-none.png';
	import Pagination from "@/components/navigation/Pagination.vue";
	import { RouterLink } from "vue-router"

  const axios = inject('axios');
  const employee = ref([]);
	const employees = ref([]);

  const userId = computed(() => {
		return user.value?.id ?? -1
	});

	function updateEmployees(newPage) {
		fetchEmployees(newPage);
	}

  async function fetchEmployees(page = 1) {
		try {
			const response = await axios.get('/employees?page=' + page);
			employees.value = response.data;
			return employees.value;
		} catch (error){
			employees.value = {};
			throw error;
		}
	}

  async function fetchEmployee(id) {
		try {
			const response = await axios.get('/employees/' + id);
			employee.value = response.data;
			return employee.value;
		} catch (error){
			throw error;
		}
	}


  const emit = defineEmits(["save", "cancel"]);

  const editClick = (user) => {
  emit("edit", user)
}

  const save = () => {
  emit("save", editingUser.value);
}

const cancel = () => {
  emit("cancel", editingUser.value);
}


  fetchEmployees()

</script>

<template>

		<router-link class="nav-link-style d-flex align-items-center px-4 py-3" :class="{ active: $route.name === 'CreateEmployee' }" :to="{ name: 'CreateEmployee' }">
			<button type="button" class="btn btn-primary">Add Employee</button>
		</router-link>
	<div class="d-block d-sm-flex align-items-center py-4 border-bottom" v-for="(employee, index) of employees.data" :key="index">
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
					<button class="btn bg-faded-danger btn-icon" type="button" data-bs-toggle="modal" data-bs-target="#open-ticket" @click="fetchEmployee(employee.id)" > 
						<i class="bi bi-pencil"></i>
					</button>
					<button class="btn bg-faded-danger btn-icon" type="button" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
						<i class="bi bi-trash"></i>
					</button>
				</div>
			</div>
		</div>

		<div v-if="employees?.meta !== undefined">
			<Pagination @page-change="updateEmployees" :pagination="employees.meta"/>
		</div>

		
    <div class="modal fade" id="open-ticket" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit user - {{ employee.name }}</h5>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row gx-4 gy-3">
                <div class="col-12">
                  <label class="form-label" for="ticket-subject">Name</label>
                  <input class="form-control" type="text" id="ticket-subject" 
                  required v-model="employee.name">
                  <label class="form-label" for="ticket-subject">Email</label>
                  <input class="form-control" type="text" id="ticket-subject"
                  required v-model="employee.email">
                  <div class="invalid-feedback">Please fill in the name!</div>
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="ticket-type">Type</label>
                  <select class="form-select" id="ticket-type" required="">
                  <option selected value="employee.type"></option>
									<option value="Delivery">Delivery</option>
                  <option value="Chef">Chef</option>
									<option value="Manager">Manager</option>
                  </select>
                  <div class="invalid-feedback">Please choose ticket type!</div>
                </div>
                <div class="col-12">
                  <input class="form-control" type="file" id="file-input">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
</template>
