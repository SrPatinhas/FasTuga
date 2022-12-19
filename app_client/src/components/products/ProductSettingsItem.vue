<script setup>
	import {useProductsStore} from "@/stores/products.js";
	import Pagination from "@/components/navigation/Pagination.vue";

	const productStore = useProductsStore();
	productStore.fetchProducts();

	function updateProducts(newPage){
		orderStore.fetchOrders(newPage);
	}
</script>

<template>
		<div class="d-block d-sm-flex align-items-center py-4 border-bottom" v-for="(product,index) of productStore.products.data" :key="index">
			<div class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto" style="width: 12.5rem;">
				<img :src="product.photo_url" class="card-img-top" :alt="name">
			</div>                  
			<div class="text-center text-sm-start">
                    <h3 class="h6 product-title mb-2">{{ product.name }}</h3>
                    <div class="d-inline-block text-accent">{{ product.description }}</div>
                    <div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">Price: <span class="fw-medium">{{ product.price }}</span></div>
                    <div class="d-flex justify-content-center justify-content-sm-start pt-3">
                      <button class="btn bg-faded-info btn-icon me-2" type="button" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit"><i class="bi bi-pencil-square"></i></button>
                      <button class="btn bg-faded-danger btn-icon" type="button" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete"><i class="bi bi-trash"></i></button>
                    </div>
                  </div>
                </div>
	<div v-if="productStore.products.meta !== undefined">
		<Pagination @page-change="updateProducts"  :pagination="productStore.products.meta"/>
	</div>
</template>