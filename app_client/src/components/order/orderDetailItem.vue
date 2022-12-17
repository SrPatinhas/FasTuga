<template>
	<!-- Item-->
	<div class="d-sm-flex justify-content-between my-4 pb-3 pb-sm-2 border-bottom">
		<div class="d-sm-flex text-center text-sm-start flex-4">
			<div class="flex-1 text-center">
				<img :src="logoUrlMini" alt="Product" class="w-75">
			</div>
			<div class="ps-sm-4 pt-2 flex-3">
				<h3 class="product-title fs-base mb-2"><a href="shop-single-v1.html">{{ name }}</a></h3>
				<div class="fs-lg text-accent pt-2"><span class="fs-5">{{ (price).toFixed(2) }}</span>€</div>
			</div>
		</div>
		<div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center flex-1">
			<div class="text-muted mb-2">Quantity:</div>{{ count }}
		</div>
		<div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center flex-1">
			<div class="text-muted mb-2">Subtotal</div><span class="fs-5">{{ (price * count).toFixed(2) }}</span>€
		</div>
	</div>
</template>

<script setup>
	import logoUrlMini from '@/assets/logo.png';

	const item = defineProps({
		id: String,
		name: String,
		image: String,
		price: Number,
		count: Number,
		type: String,
		description: String
	});
</script>