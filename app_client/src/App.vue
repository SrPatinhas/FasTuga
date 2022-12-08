<template>
	<TopBar />
	<div class="container mt-5 py-5">
		<router-view />
	</div>
</template>

<script setup>
	import {RouterView} from "vue-router"
	import TopBar from "./components/navigation/TopBar.vue";
</script>