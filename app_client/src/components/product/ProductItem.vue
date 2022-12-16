<template>
	<div class="d-block d-sm-flex align-items-center py-4 border-bottom"><a class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto" href="marketplace-single.html" style="width: 12.5rem;"><img class="rounded-3" src="img/marketplace/products/th08.jpg" alt="Product"></a>
                  <div class="text-center text-sm-start">
                    <h3 class="h6 product-title mb-2"><a href="marketplace-single.html">{{ name }} </a></h3>
                    <div class="d-inline-block text-accent">{{ description }}</div>
                    <div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">Price: <span class="fw-medium">{{ price.toFixed(2) }}</span></div>
                    <div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">Type: <span class="fw-medium">{{ type }}</span></div>
                    <div class="d-flex justify-content-center justify-content-sm-start pt-3">
                      <button class="btn bg-faded-accent btn-icon me-2" type="button" data-bs-toggle="tooltip" aria-label="Download" data-bs-original-title="Download"><i class="ci-download text-accent"></i></button>
                      <button class="btn bg-faded-info btn-icon me-2" type="button" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit"><i class="ci-edit text-info"></i></button>
                      <button class="btn bg-faded-danger btn-icon" type="button" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete"><i class="ci-trash text-danger"></i></button>
                    </div>
                  </div>
                </div>
</template>

<script setup>
	import {useProductsStore} from "../../stores/product.js";
	const productStore = useProductsStore();

	const prod = defineProps({
		id: String,
		name: String,
		image: String,
		price: Number,
		type: String,
		description: String
	});
</script>