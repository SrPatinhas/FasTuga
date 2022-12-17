<script setup>
import {ref, inject} from 'vue'
import {useRouter} from 'vue-router'
import {useUserStore} from "@/stores/user";

const router = useRouter()
const axios = inject('axios')
const toast = inject('toast')
const userStore = useUserStore()

const credentials = ref({
	username: '',
	password: '',
	loading: false,
	showPassword: false
})

//const userStore = useUserStore()
const emit = defineEmits(['login']);

const login = async () => {
	credentials.value.loading = true;
	if (await userStore.login(credentials.value)) {
		credentials.value.loading = false;
		toast.success('User ' + userStore.user.name + ' has entered the application.')
		emit('login');
		//router.back()
		console.log('login');
		router.push({name: 'Menus'});
	} else {
		credentials.value.password = ''
		toast.error('User credentials are invalid!')
	}
}
const loginGuest = () => {

}
</script>

<template>
	<section class="user">
		<div class="user_options-container">
			<div>
				<div class="user_options-forms" id="user_options-forms">
					<div class="user_forms-login">
						<h2 class="forms_title">Login</h2>
						<form class="forms_form" @submit.prevent="login">
							<fieldset class="forms_fieldset">
								<div class="input-group mb-3">
									<i class="bi-at position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
									<input class="form-control rounded-start" type="email" placeholder="Email" required v-model="credentials.username" autofocus>
								</div>
								<div class="input-group mb-3">
									<i class="bi-shield-lock position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
									<div class="password-toggle w-100">
										<input class="form-control" :type="(credentials.showPassword ? 'text' : 'password')" placeholder="Password" v-model="credentials.password">
										<label class="password-toggle-btn" aria-label="Show/hide password">
											<input class="password-toggle-check" type="checkbox" v-model="credentials.showPassword"><span class="password-toggle-indicator"></span>
										</label>
									</div>
								</div>
							</fieldset>
							<div class="forms_buttons">
								<button type="button" class="btn btn-link">Forgot password?</button>
								<button type="submit" class="btn btn-primary" @click="login" :disabled="credentials.loading">
									<span v-if="credentials.loading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
									Log In
								</button>
							</div>
						</form>
					</div>
				</div>
				<router-link class="btn btn-link mx-auto mt-3 d-block" :to="{ name: 'Registration' }">
					Or Register <i class="ml-2 bi-box-arrow-up-right text-muted"></i>
				</router-link>
			</div>
			<div class="user_options-text">
				<div class="user_options-unregistered">
					<img class="mb-4 d-block mx-auto" src="@/assets/logo_full.png" alt="fastuga">
					<h2>Don't have an account?</h2>
					<p>Don't worry, place your order as a guest.</p>
					<button class="btn btn-primary w-100" id="signup-button">Order as Guest</button>
				</div>
			</div>
		</div>
	</section>
</template>

<style scoped>
/**
 * * Page background
 * */
.user {
	display: flex;
	justify-content: center;
	align-items: center;
	width: 100%;

	height: 100%;
	padding-top: 0;
	padding-bottom: 0;
	margin-top: 10%;
}
.user_options-container {
	position: relative;
	width: 80%;
	display: flex;
	justify-content: space-evenly;
	align-items: center;
}
.user_options-text {
	width: 50%;
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
	width: 35%;
	min-width: 350px;
	max-width: 450px;
	min-height: 380px;
	height: 100%;
	background-color: #fff;
	border-radius: 3px;
	box-shadow: 2px 0 15px rgba(0, 0, 0, 0.25);
	overflow: hidden;
	transition: transform 0.4s ease-in-out;
}
.user_options-forms .user_forms-login {
	transition: opacity 0.4s ease-in-out, visibility 0.4s ease-in-out;
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
	justify-content: space-between;
	align-items: center;
	margin-top: 35px;
}
.user_options-forms .forms_buttons-forgot {
	letter-spacing: 0.1rem;
	color: #ccc;
	text-decoration: underline;
	transition: color 0.2s ease-in-out;
}
.user_options-forms .forms_buttons-forgot:hover {
	color: #b3b3b3;
}
.user_options-forms .forms_buttons-action {
	background-color: #e8716d;
	border-radius: 3px;
	padding: 10px 35px;
	font-size: 1rem;
	font-weight: 300;
	color: #fff;
	text-transform: uppercase;
	letter-spacing: 0.1rem;
	transition: background-color 0.2s ease-in-out;
}
.user_options-forms .forms_buttons-action:hover {
	background-color: #e14641;
}
.user_options-forms .user_forms-signup,
.user_options-forms .user_forms-login {
	position: absolute;
	top: 70px;
	left: 40px;
	width: calc(100% - 80px);
	opacity: 0;
	visibility: hidden;
	transition: opacity 0.4s ease-in-out, visibility 0.4s ease-in-out, transform 0.5s ease-in-out;
}
.user_options-forms .user_forms-signup {
	transform: translate3d(120px, 0, 0);
}
.user_options-forms .user_forms-signup .forms_buttons {
	justify-content: flex-end;
}
.user_options-forms .user_forms-login {
	transform: translate3d(0, 0, 0);
	opacity: 1;
	visibility: visible;
}

/**
 * * Triggers
 * */
.user_options-forms.bounceLeft {
	-webkit-animation: bounceLeft 1s forwards;
	animation: bounceLeft 1s forwards;
}
.user_options-forms.bounceLeft .user_forms-signup {
	-webkit-animation: showSignUp 1s forwards;
	animation: showSignUp 1s forwards;
}
.user_options-forms.bounceLeft .user_forms-login {
	opacity: 0;
	visibility: hidden;
	transform: translate3d(-120px, 0, 0);
}
.user_options-forms.bounceRight {
	-webkit-animation: bounceRight 1s forwards;
	animation: bounceRight 1s forwards;
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