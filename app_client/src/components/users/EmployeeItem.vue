<script setup>
  import {ref, computed, inject} from 'vue';
	import avatarNoneUrl from '@/assets/avatar-none.png';
	import Pagination from "@/components/navigation/Pagination.vue";
	import { RouterLink } from "vue-router"

  const axios = inject('axios');
  const employee = ref([]);
	const employees = ref([]);


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
					<button class="btn bg-faded-info btn-icon me-2" data-toggle="modal" data-target="#open-ticket" type="button" aria-label="Edit" data-bs-original-title="Edit">
						<i class="bi bi-pencil-square"></i>
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

		
		<form class="needs-validation modal fade show"  id="open-ticket" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Submit new ticket</h5>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p class="text-muted fs-sm">We normally respond tickets within 2 business days.</p>
              <div class="row gx-4 gy-3">
                <div class="col-12">
                  <label class="form-label" for="ticket-subject">Subject</label>
                  <input class="form-control" type="text" id="ticket-subject" required="">
                  <div class="invalid-feedback">Please fill in the subject line!</div>
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="ticket-type">Type</label>
                  <select class="form-select" id="ticket-type" required="">
                    <option value="">Choose type</option>
                    <option value="Website problem">Website problem</option>
                    <option value="Partner request">Partner request</option>
                    <option value="Complaint">Complaint</option>
                    <option value="Info inquiry">Info inquiry</option>
                  </select>
                  <div class="invalid-feedback">Please choose ticket type!</div>
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="ticket-priority">Priority</label>
                  <select class="form-select" id="ticket-priority" required="">
                    <option value="">How urgent is your issue?</option>
                    <option value="Urgent">Urgent</option>
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                  </select>
                  <div class="invalid-feedback">Please choose how urgent your ticket is!</div>
                </div>
                <div class="col-12">
                  <label class="form-label" for="ticket-description">Describe your issue</label>
                  <textarea class="form-control" id="ticket-description" rows="8" required=""></textarea>
                  <div class="invalid-feedback">Please provide ticket description!</div>
                </div>
                <div class="col-12">
                  <input class="form-control" type="file" id="file-input">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
              <button class="btn btn-primary" type="submit">Submit Ticket</button>
            </div>
          </div>
        </div>
      </form>
</template>
