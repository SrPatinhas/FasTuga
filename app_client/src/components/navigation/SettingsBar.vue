<template>
	<!-- Sidebar-->
	<aside class="col-lg-4 pe-xl-5">
		<!-- Account menu toggler (hidden on screens larger 992px)-->
		<div class="d-block d-lg-none p-4">
			<a class="btn btn-outline-accent d-block" href="#account-menu" data-bs-toggle="collapse">
				<i class="ci-menu me-2"></i>Account menu
			</a>
		</div>
		<!-- Actual menu-->
		<div class="h-100 border-end mb-2">
			<div class="d-lg-block collapse" id="account-menu">
				<div class="nav-item">
					<div class="bg-secondary p-4">
						<h3 class="fs-sm mb-0 text-muted">Account</h3>
					</div>
					<ul class="list-unstyled mb-0">
						<li class="border-bottom mb-0">
							<router-link class="nav-link-style d-flex align-items-center px-4 py-3" :class="{ active: $route.name === 'Account' }" :to="{ name: 'Account' }">
								<i class="bi-gear opacity-60 me-2"></i>Settings
							</router-link>
						</li>
						<li class="border-bottom mb-0" v-if="userStore.isCustomer">
							<router-link class="nav-link-style d-flex align-items-center px-4 py-3" :class="{ active: $route.name === 'Purchases' }" :to="{ name: 'Purchases' }">
								<i class="bi-currency-dollar opacity-60 me-2"></i>Purchases
							</router-link>
						</li>
					</ul>
				</div>
				<div class="nav-item" v-if="userStore.isManager">
					<div class="bg-secondary p-4">
						<h3 class="fs-sm mb-0 text-muted">
							Management
						</h3>
					</div>
					<ul class="list-unstyled mb-0">
						<li class="border-bottom mb-0">
							<router-link class="nav-link-style d-flex align-items-center px-4 py-3" :class="{ active: $route.name === 'DashboardManager' }" :to="{ name: 'DashboardManager' }">
								<i class="bi-currency-dollar opacity-60 me-2"></i> Dashboard <span class="fs-sm text-muted ms-auto">{{ stats.dashboard.toFixed(2) }}€</span>
							</router-link>
						</li>
						<li class="border-bottom mb-0">
							<router-link class="nav-link-style d-flex align-items-center px-4 py-3" :class="{ active: $route.name === 'ClientsAccount' }" :to="{ name: 'ClientsAccount' }">
								<i class="bi-people opacity-60 me-2"></i> Clients List <span class="fs-sm text-muted ms-auto">{{ stats.clients }}</span>
							</router-link>
						</li>
						<li class="border-bottom mb-0">
							<router-link class="nav-link-style d-flex align-items-center px-4 py-3" :class="{ active: $route.name === 'EmployeesAccount' }" :to="{ name: 'EmployeesAccount' }">
								<i class="bi-people opacity-60 me-2"></i> Employees List <span class="fs-sm text-muted ms-auto">{{ stats.employees }}</span>
							</router-link>
						</li>
						<li class="border-bottom mb-0">
							<router-link class="nav-link-style d-flex align-items-center px-4 py-3" :class="{ active: $route.name === 'Products' }" :to="{ name: 'Products' }">
								<i class="bi-box opacity-60 me-2"></i> Products <span class="fs-sm text-muted ms-auto">{{ stats.products }}</span>
							</router-link>
						</li>
						<li class="border-bottom mb-0">
							<router-link class="nav-link-style d-flex align-items-center px-4 py-3" :class="{ active: $route.name === 'Orders' }" :to="{ name: 'Orders' }">
								<i class="bi-receipt-cutoff opacity-60 me-2"></i> Orders <span class="fs-sm text-muted ms-auto">{{ stats.orders }}</span>
							</router-link>
						</li>
					</ul>
				</div>
				<div class="bg-secondary p-4">
					<h3 class="fs-sm mb-0 text-muted">Security</h3>
				</div>
				<ul class="list-unstyled mb-0">
					<li class="border-bottom mb-0">
						<router-link class="nav-link-style d-flex align-items-center px-4 py-3" :class="{ active: $route.name === 'ChangePassword' }" :to="{ name: 'ChangePassword' }">
							<i class="bi-shield-lock-fill opacity-60 me-2"></i> Change password
						</router-link>
					</li>
					<li class="border-bottom mb-0">
						<a class="nav-link-style d-flex align-items-center px-4 py-3" href="#" @click.prevent="logout">
							<i class="bi-box-arrow-in-left opacity-60 me-2"></i>Sign out
						</a>
					</li>
				</ul>
			</div>
		</div>
	</aside>
</template>


<script setup>
	import {useRouter, RouterLink} from "vue-router";
	import {ref, inject} from "vue";
	const axios = inject('axios');
	import {useUserStore} from "@/stores/user";

	const router = useRouter()
	const toast = inject("toast")
	const userStore = useUserStore();

	const stats = ref({
		dashboard: 0,
		clients: 0,
		employees: 0,
		products: 0,
		orders: 0,
	});

	async function fetchStats() {
		try {
			const response = await axios.get('/employees/sidebar');
			stats.value = response.data;
			return true;
		} catch (error) {
			throw error;
		}
	}
	if(userStore.isManager) {
		fetchStats();
	}

	const logout = async () => {
		if (await userStore.logout()) {
			toast.success('User has logged out of the application.')
			router.push({name: 'home'})
		} else {
			toast.error('There was a problem logging out of the application!')
		}
	}
</script>