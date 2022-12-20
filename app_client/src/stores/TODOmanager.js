import {ref, computed, inject} from 'vue';
import {defineStore} from 'pinia';

import {useOrdersStore} from "@/stores/order";
import avatarNoneUrl from '@/assets/avatar-none.png';

export const useUserStore = defineStore('user', () => {
	const socket = inject("socket");
	const axios = inject('axios');
	const toast = inject("toast");
	const serverBaseUrl = inject('serverBaseUrl');

	const orderStore = useOrdersStore();

	const user = ref();
	const users = ref();
	const customer = ref();
	const customers = ref();
	const employees = ref();

	const productTypes = ref([
        {type: 'customer', icon: 'bi bi-people'},
        {type: 'employee', icon: 'bi bi-people-fill'},
	])

	const userIsGuest = ref( false);

	const userPhotoUrl = computed(() => {
		if (!user.value?.photo_url) {
			return avatarNoneUrl
		}
		//return serverBaseUrl + '/storage/fotos/' + user.value.photo_url
		return user.value.photo_url;
	})

	const userId = computed(() => {
		return user.value?.id ?? -1
	});
	const availablePoints = computed(() => {
		return user.value?.points ?? 50;
	});

	const isAuthenticated = computed(() => {
		return !!user.value?.id ?? false;
	});
	/*
	 * Roles
	 */
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
		return isCustomer || isDelivery;
	});
	const isManager = computed(() => {
		return user.value?.type == 'EM' ?? false;
	});








	async function loadUsers() {
		try {
			const response = await axios.get('users')
			users.value = response.data.data
		} catch (error) {
			clearUser()
			throw error
		}
	}


	async function loadUser() {
		try {
			const response = await axios.get('users/me')
			user.value = response.data.data
		} catch (error) {
			clearUser()
			throw error
		}
	}

	async function loadCustomer() {
		try {
			const response = await axios.get('customers/me')
			customer.value = response.data.data
		} catch (error) {
			clearUser()
			throw error
		}
	}

	async function fetchCustomers(page = 1) {
		try {
			const response = await axios.get('/customers?page=' + page);
			customers.value = response.data;
			return customers.value;
		} catch (error){
			customers.value = {};
			throw error;
		}
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


	function clearUser() {
		delete axios.defaults.headers.common.Authorization
		sessionStorage.removeItem('token');
		user.value = null
	}

	async function login(credentials) {
		try {
			const response = await axios.post('login', credentials)
			axios.defaults.headers.common.Authorization = "Bearer " + response.data.access_token
			sessionStorage.setItem('token', response.data.access_token)
			await loadUser();
			socket.emit('loggedIn', user.value);
			//await projectsStore.loadProjects()
			userIsGuest.value = false;
			return true
		} catch (error) {
			clearUser()
			//projectsStore.clearProjects()
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
			axios.defaults.headers.common.Authorization = "Bearer " + response.data.access_token
			sessionStorage.setItem('token', response.data.access_token);
			await loadUser();
			socket.emit('loggedIn', user.value);
			//await projectsStore.loadProjects()
			userIsGuest.value = false;
			return true
		} catch (error) {
			clearUser()
			//projectsStore.clearProjects()
			return false
		}
	}


	function loginAsGuest() {
		userIsGuest.value = true;
	}

	async function logout() {
		try {
			await axios.post('logout')
			socket.emit('loggedOut', user.value)
			clearUser();
			orderStore.clearOrderInfo();
			//projectsStore.clearProjects()
			return true
		} catch (error) {
			return false
		}
	}

	async function restoreToken() {
		let storedToken = sessionStorage.getItem('token')
		if (storedToken) {
			axios.defaults.headers.common.Authorization = "Bearer " + storedToken
			await loadUser();
			socket.emit('loggedIn', user.value)
			//await projectsStore.loadProjects()
			orderStore.restoreLocalStorage();
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
            await axios.patch('users/' +userId.value + '/password', passwords)
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
		user, users, customer, customers, employees, userId, userPhotoUrl, userIsGuest,
		availablePoints, productTypes,
		login, register,loginAsGuest, logout, restoreToken, changePassword,
		loadUsers, loadCustomer, save,
		isCustomer, isChef, isDelivery, isEmployee, isManager, isAuthenticated,
		fetchCustomers, fetchEmployees,
	}
})
