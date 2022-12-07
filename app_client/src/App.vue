<script setup>
	import {RouterView} from "vue-router"

	import TopBar from "./components/navigation/TopBar.vue";
</script>

<template>
	<TopBar />
	<div class="container mt-5 pt-5">
		<router-view />
	</div>
</template>