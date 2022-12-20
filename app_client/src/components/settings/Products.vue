<template>
	<!-- Content-->
	<section class="col-lg-8 pt-lg-4 pb-4 mb-3">
		<div class="pt-2 px-4 ps-lg-0 pe-xl-5">
			<h2 class="h3 py-2 text-center text-sm-start">Products</h2>
			<!-- Tabs-->
			<ProductList />
		</div>
	</section>
</template>

<script setup>
	import ProductList from "@/components/products/ProductSettingsItem.vue"
</script>