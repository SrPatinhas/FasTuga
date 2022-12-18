<template>
            <!-- Sidebar-->
            <aside class="col-lg-4 pe-xl-5">
              <!-- Account menu toggler (hidden on screens larger 992px)-->
              <div class="d-block d-lg-none p-4"><a class="btn btn-outline-accent d-block" href="#account-menu" data-bs-toggle="collapse"><i class="ci-menu me-2"></i>Account menu</a></div>
              <!-- Actual menu-->
              <div class="h-100 border-end mb-2">
                <div class="d-lg-block collapse" id="account-menu">
                  <div class="nav-item" v-if="userStore.user?.type == 'C'">
                  <div class="bg-secondary p-4">
                    <h3 class="fs-sm mb-0 text-muted">Account</h3>
                  </div>
                  <ul class="list-unstyled mb-0">
                    <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 active" href=""><i class="ci-settings opacity-60 me-2"></i>
                      <router-link :class="{ active: $route.name === 'Account' }" :to="{ name: 'Account' }">
                        Personal Data
                      </router-link></a></li>
                  </ul>
                  <div class="bg-secondary p-4">
                    <h3 class="fs-sm mb-0 text-muted">Orders</h3>
                  </div>
                  <ul class="list-unstyled mb-0">
                    <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href=""><i class="ci-dollar opacity-60 me-2"></i>
                      <router-link :class="{ active: $route.name === 'Purchases' }" :to="{ name: 'Purchases' }">
                        Purchase history
                      </router-link>
                  </a></li>  
                  </ul>
                  </div>
				  <div class="nav-item" v-else>
					<div class="bg-secondary p-4">
                    <h3 class="fs-sm mb-0 text-muted">
                      Management
                    </h3>
                  </div>
				          <ul class="list-unstyled mb-0">
                    <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href=""><i class="ci-dollar opacity-60 me-2"></i>
                      <router-link :class="{ active: $route.name === 'DashboardManager' }" :to="{ name: 'DashboardManager' }">
                        Dashboard Manager
                  </router-link>
                  <span class="fs-sm text-muted ms-auto"></span></a></li>
                  </ul>
                  <ul class="list-unstyled mb-0">
                    <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href=""><i class="ci-dollar opacity-60 me-2"></i>
                      <router-link :class="{ active: $route.name === 'UsersAccount' }" :to="{ name: 'UsersAccount' }">
                        Users account
                  </router-link>
                  <span class="fs-sm text-muted ms-auto"></span></a></li>
                  </ul>
				  <ul class="list-unstyled mb-0">
                    <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href=""><i class="ci-dollar opacity-60 me-2"></i>
                      <router-link :class="{ active: $route.name === 'Products' }" :to="{ name: 'Products' }">
                        Products
                  </router-link><span class="fs-sm text-muted ms-auto"></span></a></li>
                  </ul>
				  <ul class="list-unstyled mb-0">
                    <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href=""><i class="ci-dollar opacity-60 me-2"></i>
                      <router-link :class="{ active: $route.name === 'Orders' }" :to="{ name: 'Orders' }">
                        Cancelling order
                  </router-link><span class="fs-sm text-muted ms-auto"></span></a></li>
                  </ul>
				</div>
                  <div class="bg-secondary p-4">
                    <h3 class="fs-sm mb-0 text-muted">Security</h3>
                  </div>
                  <ul class="list-unstyled mb-0">
                    <li class="mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="dashboard-sales.html"><i class="ci-dollar opacity-60 me-2"></i>
                  <router-link :class="{ active: $route.name === 'ChangePassword' }" :to="{ name: 'ChangePassword' }">
                    Change password
                  </router-link>
                  <span class="fs-sm text-muted ms-auto"></span></a></li>
                      <li class="mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="" @click.prevent="logout"><i class="ci-sign-out opacity-60 me-2" ></i>Sign out</a></li>
                  </ul>
                </div>
              </div>
            </aside>
</template>


<script setup>
import {useRouter, RouterLink} from "vue-router"
	import {inject} from "vue"
	import {useUserStore} from "@/stores/user";

	const router = useRouter()
	const toast = inject("toast")
	const userStore = useUserStore()

  const logout = async () => {
      if (await userStore.logout()) {
        toast.success('User has logged out of the application.')
        router.push({name: 'home'})
      } else {
        toast.error('There was a problem logging out of the application!')
      }
  }
</script>