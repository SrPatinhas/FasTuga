<template>

	<li class="nav-item" role="presentation" v-for="(userType, index) of userStore.productTypes" :key="'tabs_' + index">
		<!--<button class="nav-link btn rounded-pill d-flex gap-2 align-items-center"
				:class="(foodTypeActive === foodType.type ? 'btn-secondary active' : 'btn-outline-secondary')"
				:id="'pills-' + foodType.type.replace(' ', '_') + '-tab'" type="button"
				data-bs-toggle="tab" :data-bs-target="'#' + foodType.type.replace(' ', '_') + '-tab-pane'"
				role="tab" :aria-controls="foodType.type.replace(' ', '_') + '-tab-pane'" :aria-selected="foodTypeActive === foodType.type"
				@click="changeTab(foodType.type)">
			<i :class="'bi ' + foodType.icon"></i>
			{{ foodType.type }}
			<span class="badge" :class="foodTypeActive === foodType.type ? 'bg-white text-primary' : 'bg-primary'">
				{{ menuStore.getProductsByFilterTotal(foodType.type) }}
			</span>
		</button>-->
	</li>


	<!--
		<div  v-for="(users,index) of useUserStore.users.data" :key="index" class="d-block d-sm-flex align-items-center py-4 border-bottom">
			<a class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto" href="" style="width: 12.5rem;">
				<img class="rounded-3" src="img/marketplace/products/th08.jpg" alt="Product">
			</a>
		  <div class="text-center text-sm-start">
			<h3 class="h6 product-title mb-2">{{ userStore.users.name }}</h3>
			<div class="d-inline-block text-accent">{{ userStore.users.email }}</div>
			<div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">Type: <span class="fw-medium">{{ userStore.user.type }}</span></div>
			<div class="d-flex justify-content-center justify-content-sm-start pt-3">
			  <button class="btn bg-faded-info btn-icon me-2" type="button" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit"><i class="bi bi-pencil-square"></i></button>
			  <button class="btn bg-faded-danger btn-icon" type="button" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete"><i class="bi bi-trash"></i></button>
			</div>
		  </div>
		</div>
	-->
</template>

<script setup>
	import {ref} from "vue";
	import {useUserStore} from "@/stores/user.js";

	const userStore = useUserStore();
	const userTypeActive = ref('customer');

	function changeTab(type) {
		userTypeActive.value = type;
		setTimeout(function () {
			window.scrollTo(0, 0);
		}, 100);
	}
</script>