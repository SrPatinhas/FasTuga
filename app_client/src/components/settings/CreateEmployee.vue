<script setup>
	import {inject, reactive} from 'vue'
	import {useRouter} from 'vue-router'
	import {useUserStore} from "@/stores/user";
	import PhotoUploader from "@/components/global/photoUploader.vue";

	const router = useRouter()
	const axios = inject('axios')
	const toast = inject('toast')
	const userStore = useUserStore();

	const employee = reactive({
		name: '',
		email: '',
		password: '',
		password_confirmation: '',
		photo: null,
		type: '',
		blocked: '',
		loading: false
	})

	const emit = defineEmits(['register']);

	async function newEmployee() {
		try {
			const formData = new FormData();
			if (employee.photo != null) {
				formData.append('photo', employee.photo);
			}
			for (const [key, value] of Object.entries(employee)) {
				if (key !== "loading" && key !== "photo") {
					formData.append(key, value);
				}
			}
			await axios.post('employees', formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			});
			router.push({name: 'EmployeesAccount'});
			return true
		} catch (error) {
			return false
		}
	}

	const changeUploadImage = (image) => {
		employee.photo = image;
	}
</script>

<template>
	<section class="col-lg-8 pt-lg-4 pb-4 mb-3">
		<div class="align-items-center d-flex pb-3">
			<router-link class="btn btn-secondary mr-2" :to="{ name: 'EmployeesAccount' }">
				<i class="bi-arrow-left m-0"></i>
			</router-link>
			<h2 class="h3 text-center text-sm-start m-0">New Employee</h2>
		</div>
		<div class="pt-2 px-4 ps-lg-0 pe-xl-5">
			<form class="row g-3" @submit.prevent="">

				<div class="col-12 col-md-6">
					<label for="inputState" class="form-label">Employee Type</label>
					<select id="inputState" class="form-select form-control" required v-model="employee.type">
						<option value="ED">Delivery</option>
						<option value="EC">Chef</option>
						<option value="EM">Manager</option>
					</select>
				</div>
				<div class="col-12 col-md-6"></div>

				<div class="col-12 col-md-6">
					<label for="inputName" class="form-label">Name</label>
					<input class="form-control" id="inputName" type="text" placeholder="Name" required v-model="employee.name">
				</div>
				<div class="col-12 col-md-6">
					<label for="inputEmail4" class="form-label">Email</label>
					<div class="input-group mb-3">
						<i class="bi-at position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
						<input class="form-control" type="email" placeholder="Email" required v-model="employee.email">
					</div>
				</div>

				<div class="col-12 col-md-6">
					<label for="inputPassword" class="form-label">Password</label>
					<div class="input-group mb-3">
						<i class="bi-shield-lock position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
						<div class="password-toggle w-100">
							<input class="form-control" id="inputPassword" :type="(employee.showPassword ? 'text' : 'password')" placeholder="Password" v-model="employee.password">
							<label class="password-toggle-btn" aria-label="Show/hide password">
								<input class="password-toggle-check" tabindex="-1" type="checkbox" v-model="employee.showPassword"><span class="password-toggle-indicator"></span>
							</label>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<label for="inputPassword" class="form-label">Password Confirmation</label>
					<input class="form-control" id="inputPasswordConfirm" :type="(employee.showPasswordConfirmation ? 'text' : 'password')" placeholder="Password Confirmation" v-model="employee.password_confirmation">
					<label class="password-toggle-btn" aria-label="Show/hide password">
						<input class="password-toggle-check" tabindex="-1" type="checkbox" v-model="employee.showPasswordConfirmation">
						<span class="password-toggle-indicator"></span>
					</label>
				</div>

				<div class="col-12">
					<PhotoUploader @image-change="changeUploadImage"/>
				</div>

				<div class="forms_buttons">
					<button type="submit" class="btn btn-primary" @click="newEmployee">
						<span role="status" aria-hidden="true"></span>
						Add
					</button>
				</div>
			</form>
		</div>
	</section>
</template>

