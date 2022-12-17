<template>
	<div class="col">
		<div class="card card-item h-100 shadow-sm">
			<img :src="photo_url" class="card-img-top" :alt="name">
			<div class="card-body">
				<h5 class="card-title">{{ name }} </h5>
				<p class="card-text text-muted">{{ description }}</p>
				<div class="d-flex justify-content-between align-items-center">
					<span class="fs-2 text-bold text-primary">{{ price.toFixed(2) }}<span class="fs-5">€</span></span>
					<div class="btn btn-icon" @click="addToCart">
						<i class="bi-bag"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
	import {useOrdersStore} from "@/stores/order";
	const orderStore = useOrdersStore();

	const prod = defineProps({
		id: Number,
		name: String,
		photo_url: String,
		price: Number,
		type: String,
		description: String
	});
	// 'http://server_api.test/products/'  + image
	function addToCart(){
		const item = {
			id: prod.id,
			name: prod.name,
			photo_url: prod.photo_url,
			price: prod.price,
			type: prod.type,
			description: prod.description,
			count: 1
		}
		orderStore.addItemToOrder(item);
	}
</script>