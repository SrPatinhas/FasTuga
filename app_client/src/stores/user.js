import {ref, computed, inject} from 'vue';
import {defineStore} from 'pinia';

import {useOrdersStore} from "@/stores/order";
import avatarNoneUrl from '@/assets/avatar-none.png';
import {useRoute, useRouter} from "vue-router";

export const useUserStore = defineStore('user', () => {
	const socket = inject("socket");
	const axios = inject('axios');
	const toast = inject("toast");

	const orderStore = useOrdersStore();
	const route = useRoute();
	const router = useRouter()

	const user = ref();
	const customer = ref();
	const errors = ref();

	const userTypes = ref([
        {type: 'C', icon: 'bi bi-people'},
        {type: 'ED', icon: 'bi bi-people-fill'},
		{type: 'EC', icon: 'bi bi-people-fill'},
		{type: 'EM', icon: 'bi bi-people-fill'}
	])

	const userIsGuest = ref( false);

	const userPhotoUrl = computed(() => {
		if (!user.value?.photo_url) {
			return avatarNoneUrl
		}
		return user.value.photo_url;
	})
	const userId = computed(() => {
		return user.value?.id ?? -1
	});
	const availablePoints = computed(() => {
		return customer.value?.points ?? 0;
	});

	/*
	 * Roles
	 */
	const isAuthenticated = computed(() => {
		return !!user.value?.id ?? false;
	});
	const isGuest = computed(() => {
		return userIsGuest.value || !isAuthenticated.value;
	});
	const isCustomer = computed(() => {
		return user.value?.type == 'C' ?? false;
	});
	const isChef = computed(() => {
		return user.value?.type == 'EC' ?? false;
	});
	const isDelivery = computed(() => {
		return user.value?.type == 'ED' ?? false;
	});
	const isEmployee = computed(() => {
		return isChef.value || isDelivery.value;
	});
	const isManager = computed(() => {
		return user.value?.type == 'EM' ?? false;
	});


	async function loadUser() {
		try {
			const response = await axios.get('users/me')
			if(response.data.data.customer !== undefined) {
				customer.value = response.data.data.customer
				delete response.data.data.customer;
			}
			user.value = response.data.data
		} catch (error) {
			clearUser()
			throw error
		}
	}

	function clearUser() {
		delete axios.defaults.headers.common.Authorization
		sessionStorage.removeItem('token');
		user.value = null
	}

	async function login(credentials) {
		try {
			const response = await axios.post('login', credentials);
			await defineUserSession(response.data.access_token);
			return true
		} catch (error) {
			clearUser()
			return false
		}
	}

	async function register(credentials) {
		try {
			const formData = new FormData();
			if(credentials.photo != null) {
				formData.append('photo', credentials.photo);
			}
			for (const [key, value] of Object.entries(credentials)) {
				if(key !== "loading" && key !== "showPassword" && key !== "showPasswordConfirmation" && key !== "photo"){
					if(key === "pay_type" || key === "pay_reference") {
						formData.append(key, value.toLowerCase());
					} else {
						formData.append(key, value);
					}
				}
			}
			const response = await axios.post('register', formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			});
			await defineUserSession(response.data.access_token);
			return true;
		} catch (error) {
			clearUser();
			return false;
		}
	}

	async function defineUserSession(access_token) {
		axios.defaults.headers.common.Authorization = "Bearer " + access_token;
		sessionStorage.setItem('token', access_token);
		userIsGuest.value = false;
		await loadUser();
		socket.emit('loggedIn', user.value);
	}

	function loginAsGuest() {
		userIsGuest.value = true;
	}

	async function logout() {
		try {
			await axios.post('logout');
			socket.emit('loggedOut', user.value)
			clearUser();
			orderStore.clearOrderInfo();
			return true
		} catch (error) {
			return false
		}
	}

	async function restoreToken() {
		console.log('restoreToken');
		let storedToken = sessionStorage.getItem('token');
		if (storedToken) {
			axios.defaults.headers.common.Authorization = "Bearer " + storedToken
			await loadUser();
			socket.emit('loggedIn', user.value)
			//await projectsStore.loadProjects()
			orderStore.restoreLocalStorage();
			console.log(route.name);
			if (route.name === "Login"){
				router.back();
			}
			userIsGuest.value = false;
			return true;
		}
		clearUser();
		//projectsStore.clearProjects()
		return false;
	}

	socket.on('updateUser', (updatedUser) => {
		console.log('Someone else has updated the user #' + updatedUser.id)
		if (user.value?.id == updatedUser.id) {
			user.value = updatedUser
			toast.info('Your user profile has been changed!')
		} else {
			toast.info(`User profile #${updatedUser.id} (${updatedUser.name}) has changed!`)
		}
	})

	async function changePassword (passwords) {
       errors.value = null
        if (passwords.password != passwords.password_confirmation) {
            return false
        }
        try {
            await axios.patch('users/' + userId.value + '/password', passwords)
            return true;
        } catch (error) {
            if (error.response.status == 422) {
                errors.value = error.response.data.errors
            }
            return false
        }
    }

	async function save () {
		errors.value = null
		axios.put('users/customers/' + userId.value, user.value)
        .then((response) => {
			user.value = response.data.data
			toast.success('User #' + userId.value + ' was updated successfully.')
        })
        .catch((error) => {
			if (error.response.status == 422) {
				toast.error('User #' + userId.value  + ' was not updated due to validation errors!')
				errors.value = error.response.data.errors
			} else {
				toast.error('User #' + userId.value  + ' was not updated due to unknown server error!')
			}
        })
	 }
 


	return {
		user, customer, userId, userPhotoUrl, userIsGuest, errors,
		availablePoints, userTypes, isGuest,
		login, register, loginAsGuest, logout, restoreToken, changePassword, save,
		isCustomer, isChef, isDelivery, isEmployee, isManager, isAuthenticated
	}
})
