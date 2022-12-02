<script setup>
import {ref, inject} from 'vue'
import {useRouter} from 'vue-router'
import {useUserStore} from '../../stores/user.js'

const router = useRouter()
const axios = inject('axios')
const toast = inject('toast')
const userStore = useUserStore()

const credentials = ref({
	username: '',
	password: ''
})

//const userStore = useUserStore()
const emit = defineEmits(['login'])

const login = async () => {
	if (await userStore.login(credentials.value)) {
		toast.success('User ' + userStore.user.name + ' has entered the application.')
		emit('login')
		//router.back()
		console.log('login');
		router.push({name: 'Menus'});
	} else {
		credentials.value.password = ''
		toast.error('User credentials are invalid!')
	}
}
</script>

<template>
	<div class="signin-page">
		<main class="form-signin w-100 m-auto needs-validation" novalidate @submit.prevent="login">
			<form>
				<img class="mb-4" src="@/assets/logo_full.png" alt="fastuga">
				<h1 class="h3 mb-3 fw-normal">Please sign in</h1>

				<div class="form-floating">
					<input type="email" class="form-control" id="inputUsername" required v-model="credentials.username" placeholder="name@example.com">
					<label for="inputUsername">Email address</label>
				</div>
				<div class="form-floating">
					<input type="password" class="form-control" id="inputPassword" placeholder="Password" required v-model="credentials.password">
					<label for="inputPassword">Password</label>
				</div>

				<div class="checkbox mb-3">
					<label>
						<input type="checkbox" value="remember-me"> Remember me
					</label>
				</div>
				<button class="w-100 btn btn-lg btn-primary" type="button" @click="login">Sign in</button>
				<p class="mt-5 mb-3 text-muted">© 2022–2023</p>
			</form>
		</main>
	</div>
</template>

<style>
html,
body {
	height: 100%;
}

.signin-page {
	height: 100%;
	display: flex;
	align-items: center;
	padding-top: 40px;
	padding-bottom: 40px;
	justify-content: center;
}

.form-signin {
	max-width: 330px;
	padding: 15px;
	text-align: center;
}

.form-signin .form-floating:focus-within {
	z-index: 2;
}

.form-signin input[type="email"] {
	margin-bottom: -1px;
	border-bottom-right-radius: 0;
	border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
	margin-bottom: 10px;
	border-top-left-radius: 0;
	border-top-right-radius: 0;
}
</style>