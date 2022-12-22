<script setup>
import {ref, inject, computed, reactive} from 'vue'
	import {useRouter} from 'vue-router'
	import {useUserStore} from "@/stores/user";
	import PhotoUploader from "@/components/global/photoUploader.vue";
	import validations from "@/utils/validations";

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

	async function newEmployee () {
		try {
			const formData = new FormData();
			if(employee.photo != null) {
				formData.append('photo', employee.photo);
			}
			for (const [key, value] of Object.entries(employee)) {
				if(key !== "loading" && key !== "photo"){
						formData.append(key, value);
				}
			}
			const response = await axios.post('employees', formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			});
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
              <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
		<router-link class="btn " :to="{ name: 'EmployeesAccount' }">
			<i class="bi bi-arrow-left"></i>
		</router-link>
                <h2 class="h3 py-2 text-center text-sm-start">New Employee</h2>

						<form class="row g-3" @submit.prevent="">
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
											<input class="password-toggle-check" tabindex="-1" type="checkbox" v-model="employee.showPasswordConfirmation"><span class="password-toggle-indicator"></span>
										</label>
									</div>
							<div class="col-12 col-md-6">
								<label for="inputState" class="form-label">Employee Type</label>
								<select id="inputState" class="form-select form-control" required v-model="employee.type">
									<option value="ED">Delivery</option>
									<option value="EC">Chef</option>
									<option value="EM">Manager</option>
								</select>
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


<style scoped>
/**
 * * Page background
 * */
.register {
	display: flex;
	justify-content: center;
	align-items: center;
	width: 100%;

	height: 100%;
	padding-top: 0;
	padding-bottom: 0;
	margin-top: 5%;
}
.user_options-container {
	position: relative;
	display: flex;
	justify-content: space-evenly;
	align-items: center;
}
.user_options-text {
	width: 30%;
	max-width: 500px;
}

/**
 * * Registered and Unregistered user box and text
 * */
.user_options-registered,
.user_options-unregistered {
	width: 100%;
	padding: 75px 45px;
	color: var(--bs-black);
	font-weight: 300;
}

/**
 * * Login and signup forms
 * */
.user_options-forms {
	width: 70%;
	min-width: 350px;
	min-height: 380px;
	height: 100%;
	background-color: #fff;
	border-radius: 3px;
	box-shadow: 2px 0 15px rgba(0, 0, 0, 0.25);
	padding: 30px 40px;
	transition: transform 0.4s ease-in-out;
}
.user_options-forms .forms_title {
	margin-bottom: 45px;
	font-size: 1.5rem;
	font-weight: 500;
	line-height: 1em;
	text-transform: uppercase;
	color: #e8716d;
	letter-spacing: 0.1rem;
}
.user_options-forms .forms_field:not(:last-of-type) {
	margin-bottom: 20px;
}
.user_options-forms .forms_field-input {
	width: 100%;
	border-bottom: 1px solid #ccc;
	padding: 6px 20px 6px 6px;
	font-size: 1rem;
	font-weight: 300;
	color: gray;
	letter-spacing: 0.1rem;
	transition: border-color 0.2s ease-in-out;
}
.user_options-forms .forms_field-input:focus {
	border-color: gray;
}
.user_options-forms .forms_buttons {
	display: flex;
	justify-content: end;
	align-items: center;
	margin-top: 35px;
}
/**
 * * Responsive 990px
 * */
@media screen and (max-width: 990px) {
	.user_options-forms {
		min-height: 350px;
	}
	.user_options-forms .forms_buttons {
		flex-direction: column;
	}
	.user_options-forms .user_forms-login .forms_buttons-action {
		margin-top: 30px;
	}
	.user_options-forms .user_forms-signup,
	.user_options-forms .user_forms-login {
		top: 40px;
	}
	.user_options-registered,
	.user_options-unregistered {
		padding: 50px 45px;
	}
}

</style>