<template>

	<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
		<div class="position-sticky pt-3">
			<ul class="nav flex-column" v-if="userStore.user">
				<li class="nav-item">
					<router-link class="nav-link" :class="{ active: $route.name === 'Dashboard' }" :to="{ name: 'Dashboard' }" @click="clickMenuOption">
						<i class="bi bi-house"></i>
						Dashboard
					</router-link>
				</li>
				<li class="nav-item">
					<router-link class="nav-link" :class="{ active: $route.name === 'CurrentOrders' }" :to="{ name: 'CurrentOrders' }" @click="clickMenuOption">
						<i class="bi bi-list-stars"></i>
						Current Orders
					</router-link>
				</li>
				<li class="nav-item d-flex justify-content-between align-items-center pe-3">
					<router-link class="nav-link w-100 me-3" :class="{ active: $route.name === 'Orders' }" :to="{ name: 'Orders' }" @click="clickMenuOption">
						<i class="bi bi-list-check"></i>
						Orders
					</router-link>
					<router-link class="link-secondary" :to="{ name: 'NewOrder' }" aria-label="Add a new Order" @click="clickMenuOption">
						<i class="bi bi-xs bi-plus-circle"></i>
					</router-link>
				</li>
				<li class="nav-item d-flex justify-content-between align-items-center pe-3">
					<router-link class="nav-link w-100 me-3" :class="{ active: $route.name === 'PublicBoards' }" :to="{ name: 'PublicBoards' }" @click="clickMenuOption">
						<i class="bi bi-list-check"></i>
						Public Board
					</router-link>
					<router-link class="link-secondary" :to="{ name: 'NewPublicBoards' }" aria-label="Add a new PublicBoards" @click="clickMenuOption">
						<i class="bi bi-xs bi-plus-circle"></i>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link class="nav-link" :class="{ active: $route.name === 'kitchens' }" :to="{ name: 'kitchens' }" @click="clickMenuOption">
						<i class="bi bi-files"></i>
						kitchens
					</router-link>
				</li>
				<li class="nav-item">
					<router-link class="nav-link" :class="{ active: $route.name === 'Users' }" :to="{ name: 'Users' }" @click="clickMenuOption">
						<i class="bi bi-people"></i>
						Team Members
					</router-link>
				</li>
				<li class="nav-item" v-show="userStore.user?.type == 'A'">
					<router-link class="nav-link" :class="{ active: $route.name === 'Reports' }"
								 :to="{ name: 'Reports' }" @click="clickMenuOption">
						<i class="bi bi-bar-chart-line"></i>
						Reports
					</router-link>
				</li>
			</ul>

			<!--<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted"
				v-if="userStore.user">
			  <span>My Projects</span>
			  <router-link
				class="link-secondary"
				:to="{ name: 'NewProject' }"
				aria-label="Add a new project"
				@click="clickMenuOption"
			  >
				<i class="bi bi-xs bi-plus-circle"></i>
			  </router-link>
			</h6> -->
			<!--<ul class="nav flex-column mb-2">
			  <li class="nav-item" v-for="prj in projectsStore.myInprogressProjects" :key="prj.id">
				<router-link
				  class="nav-link w-100 me-3"
				  :class="{
					active: $route.name == 'ProjectTasks' && $route.params.id == prj.id,
				  }"
				  :to="{ name: 'ProjectTasks', params: { id: prj.id } }"
				  @click="clickMenuOption"
				>
				  <i class="bi bi-file-ruled"></i>
				  {{ prj.name }}
				</router-link>
			  </li>
			</ul>-->

			<div class="d-block d-md-none">
				<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
					<span>User</span>
				</h6>
				<ul class="nav flex-column mb-2">
					<li class="nav-item" v-show="!userStore.user">
						<a class="nav-link" href="#">
							<i class="bi bi-person-check-fill"></i>
							Register
						</a>
					</li>
					<li class="nav-item" v-show="!userStore.user">
						<router-link class="nav-link" :class="{ active: $route.name === 'Registration' }"
									 :to="{ name: 'Registration' }" @click="clickMenuOption">
							<i class="bi bi-box-arrow-in-right"></i>
							Login
						</router-link>
					</li>
					<li class="nav-item dropdown" v-show="userStore.user">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img :src="userStore.userPhotoUrl" class="rounded-circle z-depth-0 avatar-img" alt="avatar image"/>
							<span class="avatar-text">User Name</span>
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
							<li>
								<router-link class="dropdown-item" :class="{ active: $route.name == 'User' && $route.params.id == userStore.userId }" :to="{ name: 'User', params: { id: userStore.userId } }" @click="clickMenuOption">
									<i class="bi bi-person-square"></i>Profile
								</router-link>
							</li>
							<li>
								<router-link class="dropdown-item" :class="{ active: $route.name === 'ChangePassword' }" :to="{ name: 'ChangePassword' }" @click="clickMenuOption">
									<i class="bi bi-key-fill"></i>
									Change password
								</router-link>
							</li>
							<li>
								<hr class="dropdown-divider"/>
							</li>
							<li>
								<a class="dropdown-item" @click.prevent="logout">
									<i class="bi bi-arrow-right"></i>Logout
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</template>

<script>
export default {
	name: "Sidebar"
}
</script>

<style scoped>

</style>