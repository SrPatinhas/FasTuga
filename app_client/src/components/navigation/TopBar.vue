<template>
	<nav class="navbar navbar-expand-lg fixed-top flex-md-nowrap">
		<div class="container">
			<router-link class="text-dark text-decoration-none col-md-3 col-lg-2 d-flex align-items-center gap-2" :to="{ name: 'home' }">
				<img src="@/assets/logo.png" alt="" width="38" height="38" class="d-inline-block align-text-top"/>
				FasTuga
			</router-link>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<router-link class="nav-link" :class="{ active: $route.name === 'Menus' }"  :to="{ name: 'Menus' }">Menu</router-link>
					</li>
					<li class="nav-item">
						<router-link class="nav-link" :class="{ active: $route.name === 'PublicBoard' }" :to="{ name: 'PublicBoard' }">Public Board</router-link>
					</li>
					<li class="nav-item" v-show="userStore.user">
						<router-link class="nav-link" :to="{ name: 'RestaurantBoard' }">Restaurant Board</router-link>
					</li>
				</ul>

				<ul class="navbar-nav">
					<li class="nav-item" v-show="!userStore.user">
						<router-link class="nav-link" :class="{ active: $route.name === 'Registration' }" :to="{ name: 'Registration' }">
							Register
						</router-link>
					</li>
					<li class="nav-item" v-show="!userStore.user">
						<router-link class="nav-link" :class="{ active: $route.name === 'Login' }" :to="{ name: 'Login' }">
							Login
						</router-link>
					</li>
					<li class="nav-item">
						<router-link class="nav-link position-relative gap-1" :class="{ active: $route.name === 'Bag' }" :to="{ name: 'Bag' }">
							<i class="fs-5 bi bi bi-bag"></i>
							<span class="badge">
								{{ orderStore.totalItems }}
								<span class="visually-hidden">items on cart</span>
							</span>
							{{ orderStore.totalOrderCost }}
						</router-link>
					</li>
					<li class="dropdown" v-show="userStore.user">
						<a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
							<img :src="userStore.userPhotoUrl" class="rounded-circle z-depth-0 avatar-img" width="32" height="32" alt="avatar image"/>
							<span class="avatar-text">{{ userStore.user?.name ?? "Anonymous" }}</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" style="width: 200px;">
							<li><h6 class="dropdown-header">Account</h6></li>
							<li>
								<a class="dropdown-item d-flex align-items-center bi-gear" >
									<router-link class="nav-link" :class="{ active: $route.name === 'SettingsAccount' }" :to="{ name: 'SettingsAccount' }">
							Settings
						</router-link>
								</a>
							</li>
							<li>
								<a class="dropdown-item d-flex align-items-center" href="dashboard-purchases.html">
									<i class="bi-basket opacity-50 me-2"></i>Purchases
								</a>
							</li>
							<li>
								<div class="dropdown-item d-flex align-items-center">
									<i class="bi-coin opacity-50 me-2"></i>Points<span class="ms-auto opacity-50">4</span>
								</div>
							</li>

							<li>
								<router-link class="dropdown-item" :class="{ active: $route.name === 'ChangePassword' }" :to="{ name: 'ChangePassword' }">
									<i class="bi-key-fill"></i>
									Change password
								</router-link>
							</li>

							<li><hr class="dropdown-divider"></li>
							<li><h6 class="dropdown-header">Restaurant Board</h6></li>
							<li>
								<a class="dropdown-item d-flex align-items-center" href="dashboard-sales.html">
									<i class="bi-currency-dollar opacity-50 me-2"></i>Reveneu<span class="ms-auto opacity-50">$1,375.00</span>
								</a>
							</li>
							<li>
								<a class="dropdown-item d-flex align-items-center" href="dashboard-products.html">
									<i class="bi-receipt-cutoff opacity-50 me-2"></i>Orders<span class="ms-auto opacity-50">5</span>
								</a>
							</li>
							<li>
								<a class="dropdown-item d-flex align-items-center" href="dashboard-add-new-product.html">
									<i class="bi-cloud-upload opacity-50 me-2"></i>Add New Product
								</a>
							</li>
							<li>
								<a class="dropdown-item d-flex align-items-center" href="dashboard-payouts.html">
									<i class="bi-currency-exchange opacity-50 me-2"></i>Payouts
								</a>
							</li>

							<li><hr class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item d-flex align-items-center" @click.prevent="logout">
									<i class="bi-box-arrow-right opacity-50 me-2"></i>Sign Out
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</template>

<script setup>
	import {useRouter, RouterLink} from "vue-router"
	import {inject} from "vue"
	import {useUserStore} from "@/stores/user";
	import {useOrdersStore} from "@/stores/order";

	const router = useRouter()
	const axios = inject("axios")
	const toast = inject("toast")
	const userStore = useUserStore()
	const orderStore = useOrdersStore();

	const logout = async () => {
		if (await userStore.logout()) {
			toast.success('User has logged out of the application.')
			router.push({name: 'home'})
		} else {
			toast.error('There was a problem logging out of the application!')
		}
	}
</script>