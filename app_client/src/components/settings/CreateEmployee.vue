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

	const credentials = reactive({
		name: '',
		email: '',
		password: '',
		password_confirmation: '',
		photo: null,
		type: '',
		showPassword: false,
		showPasswordConfirmation: false,
		loading: false
	})

	const emit = defineEmits(['register']);

	const btnDisabled = ref(true);

	const register = async () => {
		if(isFormValid.value) {
			if (await newEmployee(credentials)) {
				toast.success('User ' + userStore.user.name + ' was created successfully.')
				emit('register');
				//router.back()
				console.log('register');
				router.push({name: 'EmployeesAccount'});
			} else {
				toast.error('Unable to create employee');
			} 
		}
	}

	async function newEmployee (credentials) {
		try {
			const formData = new FormData();
			if(credentials.photo != null) {
				formData.append('photo', credentials.photo);
			}
			for (const [key, value] of Object.entries(credentials)) {
				if(key !== "loading" && key !== "showPassword" && key !== "showPasswordConfirmation" && key !== "photo"){
					if(key === "type") {
						formData.append(key, value.toLowerCase());
					} else {
						formData.append(key, value);
					}
				}
			}
			const response = await axios.post('employee', formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			});
			return true
		} catch (error) {
			clearUser()
			return false
		}
	}

	const validatePassword = computed(() => {
		let isValid = false;
		isValid = credentials.password !== '';
		isValid = isValid && credentials.password.length >= 4;
		return isValid;
	});
	const validatePasswordConfirmation = computed(() => {
	  	let isValid = false;
		isValid = credentials.password_confirmation !== '';
		isValid = isValid && credentials.password_confirmation === credentials.password;
		return isValid;
	});
	const validateEmail = computed(() => {
		return validations.isValidEmail(credentials.email);
	});
	const validPasswords = computed(() => {
		return validatePasswords();
	});


	function validatePasswords() {
		let isValid = false;
		isValid = credentials.password !== '';
		isValid = isValid && credentials.password.length >= 4;
		isValid = isValid && credentials.password_confirmation !== '';
		isValid = isValid && credentials.password_confirmation === credentials.password;
		return isValid;
	}
	const changeUploadImage = (image) => {
		credentials.photo = image;
	}

	const isFormValid = computed(() => {
		return validateEmail.value && validPasswords.value;
	});
</script>

<template>
	  <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
              <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
                <h2 class="h3 py-2 text-center text-sm-start">New Employee</h2>

						<form class="row g-3" @submit.prevent="">
							<div class="col-12 col-md-6">
								<label for="inputName" class="form-label">Name<span class="text-danger">*</span></label>
								<input class="form-control" id="inputName" type="text" placeholder="Name" required v-model="credentials.name">
							</div>
							<div class="col-12 col-md-6">
								<label for="inputEmail4" class="form-label">Email<span class="text-danger">*</span></label>
								<div class="input-group mb-3">
									<i class="bi-at position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
									<input class="form-control" :class="validateEmail ? 'is-valid' : (credentials.email ? 'is-invalid' : '')" type="email" placeholder="Email" required v-model="credentials.email">
								</div>
								<div class="invalid-feedback" :class="!validateEmail && credentials.email && 'd-block'">
									Your email is invalid
								</div>
							</div>

							<div class="col-12 col-md-6">
								<label for="inputPassword" class="form-label">Password<span class="text-danger">*</span></label>
								<div class="input-group mb-3">
									<i class="bi-shield-lock position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
									<div class="password-toggle w-100">
										<input class="form-control" :class="validatePassword ? 'is-valid' : (credentials.password ? 'is-invalid' : '')" id="inputPassword" :type="(credentials.showPassword ? 'text' : 'password')" placeholder="Password" v-model="credentials.password">
										<label class="password-toggle-btn" aria-label="Show/hide password">
											<input class="password-toggle-check" tabindex="-1" type="checkbox" v-model="credentials.showPassword"><span class="password-toggle-indicator"></span>
										</label>
									</div>
								</div>
								<div class="invalid-feedback" :class="!validatePassword && credentials.password && 'd-block'">
									Your passwords need to have at least 4 characters
								</div>
							</div>
							<div class="col-12 col-md-6">
								<label for="inputPasswordConfirm" class="form-label">Password Confirmation<span class="text-danger">*</span></label>
								<div class="input-group mb-3 has-validation">
									<i class="bi-shield-lock position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
									<div class="password-toggle w-100">
										<input class="form-control" :class="validatePasswordConfirmation ? 'is-valid' : (credentials.password_confirmation ? 'is-invalid' : '')" id="inputPasswordConfirm" :type="(credentials.showPasswordConfirmation ? 'text' : 'password')" placeholder="Password Confirmation" v-model="credentials.password_confirmation">
										<label class="password-toggle-btn" aria-label="Show/hide password">
											<input class="password-toggle-check" tabindex="-1" type="checkbox" v-model="credentials.showPasswordConfirmation"><span class="password-toggle-indicator"></span>
										</label>
									</div>
								</div>
								<div class="invalid-feedback" :class="!validatePasswordConfirmation && credentials.password_confirmation && 'd-block'">
									Your passwords need to be the same
								</div>
							</div>

							<div class="col-12">
								<PhotoUploader @image-change="changeUploadImage"/>
							</div>
							<div class="col-12 col-md-6">
								<label for="inputState" class="form-label">Employee Type<span class="text-danger">*</span></label>
								<select id="inputState" class="form-select form-control" required v-model="credentials.type">
									<option selected value="" disabled>Delivery</option>
									<option value="Chef">Chef</option>
									<option value="Manager">Manager</option>
								</select>
							</div>
							

							<div class="forms_buttons">
								<button type="submit" class="btn btn-primary" @click="register" :disabled="!isFormValid">
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