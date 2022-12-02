<script setup>
import {useRouter, RouterView} from "vue-router"
import {inject} from "vue"
import {useUserStore} from "./stores/user.js"
import {useProjectsStore} from "./stores/projects.js"

import TopBar from "./components/navigation/TopBar.vue";

const router = useRouter()
const axios = inject("axios")
const toast = inject("toast")
const userStore = useUserStore()
const projectsStore = useProjectsStore()

</script>

<template>
	<TopBar />
	<div class="container mt-5 pt-5">
		<div class="row">
			<router-view />
		</div>
	</div>
</template>

<style>
@import "./assets/dashboard.css";
body {
	background: #fdfdfd;
}
.avatar-img {
	margin: -1.2rem 0.8rem -2rem 0.8rem;
	width: 3.3rem;
	height: 3.3rem;
}

.avatar-text {
	line-height: 2.2rem;
	margin: 1rem 0.5rem -2rem 0;
	padding-top: 1rem;
}

.dropdown-item {
	font-size: 0.875rem;
}

.btn:focus {
	outline: none;
	box-shadow: none;
}

#sidebarMenu {
	overflow-y: auto;
}
nav.navbar {
	background-color: #ffe9c4;
}
nav.navbar img {
	object-fit: contain;
}
nav.navbar img.avatar-img {
	object-fit: contain;
	margin: 0 10px 0;
}
</style>
