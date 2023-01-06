<template>
	<TopBar />
	<div class="page-content mb-5" :class="(pageName !== 'RestaurantBoard' && pageName !== 'PublicBoard') && 'container'">
		<router-view />
	</div>
	<footer class="footer bg-darker mt-auto">
		<div class="container pt-2">
			<div class="d-md-flex justify-content-between pt-4 pb-1">
				<div class="pb-4 fs-xs text-light opacity-50 text-center text-md-start">© All rights reserved. Made by <a class="text-light" href="#" target="_blank" rel="noopener">Group 47</a></div>
				<div class="widget widget-links widget-light pb-4">
					<ul class="widget-list d-flex flex-wrap justify-content-center justify-content-md-start">
						<li class="widget-list-item ms-4">
							<router-link class="widget-list-link fs-ms" :to="{ name: 'Login' }">Login</router-link>
						</li>
						<li class="widget-list-item ms-4">
							<router-link class="widget-list-link fs-ms" :to="{ name: 'Menus' }">Menu</router-link>
						</li>
						<li class="widget-list-item ms-4">
							<router-link class="widget-list-link fs-ms" :to="{ name: 'PublicBoard' }">Board</router-link>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
</template>

<script setup>
	import {computed} from "vue";
	import {RouterView, useRoute} from "vue-router"
	import TopBar from "./components/navigation/TopBar.vue";
	import {useMenuStore} from "@/stores/menu";

	const route = useRoute();
	const pageName = computed(() => route.name);

	const menuStore = useMenuStore();
	menuStore.fetchProducts();
	menuStore.fetchProductsTrending();
</script>