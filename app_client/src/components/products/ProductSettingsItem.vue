<template>
	<div v-if="productStore.products?.data || productStore.products?.data?.length === 0">
		<div class="p-5 bg-faded-warning rounded-3">
			<div class="">
				<h1 class="fw-bold">No Products to show <i class="bi bi-emoji-frown fs-2 text-danger"></i></h1>
				<p class="col-md-8 fs-5">Create your first product</p>
				<router-link class="btn btn-primary btn-lg" :to="{ name: 'Menus' }">Menu</router-link>
			</div>
		</div>
	</div>
	<div v-else>
		<div class="d-block d-sm-flex align-items-center py-4 border-bottom" v-for="(product, index) of productStore.products.data" :key="index">
			<div class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto" style="width: 12.5rem;">
				<img :src="product.photo_url" class="card-img-top" :alt="name">
			</div>
			<div class="text-center text-sm-start">
				<h3 class="h6 product-title mb-2">{{ product.name }}</h3>
				<div class="d-inline-block text-accent">{{ product.description }}</div>
				<div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">
					Price:
					<span class="fw-medium">{{ product.price }}</span>
				</div>
				<div class="d-flex justify-content-center justify-content-sm-start pt-3">
					<button class="btn bg-faded-info btn-icon me-2" type="button" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit">
						<i class="bi bi-pencil-square"></i>
					</button>
					<button class="btn bg-faded-danger btn-icon" type="button" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
						<i class="bi bi-trash"></i>
					</button>
				</div>
			</div>
		</div>
		<div v-if="productStore.products?.meta !== undefined">
			<Pagination @page-change="updateProducts" :pagination="productStore.products.meta"/>
		</div>
	</div>
	<!-- TODO Add modal to create/Edit new products -->
</template>

<script setup>
	import {useProductsStore} from "@/stores/products.js";
	import Pagination from "@/components/navigation/Pagination.vue";

	const productStore = useProductsStore();
	productStore.fetchProducts();

	function updateProducts(newPage) {
		productStore.fetchProducts(newPage);
	}
</script>