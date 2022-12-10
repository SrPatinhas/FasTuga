<template>
	<TopBar />
	<div class="page-content" :class="pageName !== 'Dashboard' && 'container'">
		<router-view />
	</div>
</template>

<script setup>
	import {computed} from "vue";
	import {RouterView, useRoute} from "vue-router"
	import TopBar from "./components/navigation/TopBar.vue";

	const route = useRoute();
	const pageName = computed(() => route.name);
</script>