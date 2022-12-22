<template>
	<!-- Item-->
	<div class="d-sm-flex justify-content-between my-4 pb-3 pb-sm-2 border-bottom">
		<div class="d-sm-flex text-center text-sm-start flex-4">
			<div class="flex-1 text-center">
				<img :src="product?.photo_url || logoUrlMini" alt="Product" class="w-75">
			</div>
			<div class="ps-sm-4 pt-2 flex-3">
				<h3 class="product-title fs-base mb-2">{{ product?.name }}</h3>
				<div class="fs-sm">
					{{ notes }}
				</div>
				<div class="fs-sm text-accent pt-2">
					<span class="fs-5">{{ price.toFixed(2) }}</span>€
				</div>
			</div>
		</div>
		<div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center flex-1">
			<div class="text-muted mb-2">Quantity:</div>{{ quantity }}
		</div>
		<div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center flex-1">
			<div class="text-muted mb-2">Subtotal</div><span class="fs-5">{{ (price * quantity).toFixed(2) }}</span>€
		</div>
	</div>
</template>

<script setup>
	import logoUrlMini from '@/assets/logo.png';

	const item = defineProps({
		product: Object,
		notes: String,
		order_local_number: Number,
		price: Number,
		quantity: Number,
		status: String,
		prepared_by: String
	});
	console.log(item);
</script>