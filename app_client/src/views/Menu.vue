<script setup>
	import ProductItem from "@/components/products/ProductItem.vue";
	import {useMenuStore} from "@/stores/menu";
	import {ref} from "vue";

	const menuStore = useMenuStore();

	const foodTypeActive = ref('hot dish');

	function changeTab(type) {
		foodTypeActive.value = type;
	}
</script>

<template>
	<section id="store_menu" class="row pt-3 pb-5">
		<div class="sticky-header">
			<h4 class="text-uppercase text-bold">Menu</h4>
			<ul class="nav nav-pills tabs-filter gap-4" role="tablist">
				<li class="nav-item" role="presentation" v-for="(foodType, index) of menuStore.productTypes" :key="'tabs_' + index">
					<button class="nav-link btn rounded-pill d-flex gap-2 align-items-center"
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
					</button>
				</li>
			</ul>
			<div class="width-150"></div>
		</div>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="hot_dish-tab-pane" role="tabpanel" aria-labelledby="hot_dish-tab" tabindex="0">
				<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 gap-4 pt-3">
					<ProductItem v-for="food of menuStore.getProductsByFilter('hot dish')" v-bind="food"/>
				</div>
			</div>
			<div class="tab-pane fade" id="cold_dish-tab-pane" role="tabpanel" aria-labelledby="cold_dish-tab" tabindex="0">
				<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 gap-4 pt-3">
					<ProductItem v-for="food of menuStore.getProductsByFilter('cold dish')" v-bind="food"/>
				</div>
			</div>
			<div class="tab-pane fade" id="drink-tab-pane" role="tabpanel" aria-labelledby="drink-tab" tabindex="0">
				<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 gap-4 pt-3">
					<ProductItem v-for="food of menuStore.getProductsByFilter('drink')" v-bind="food"/>
				</div>
			</div>
			<div class="tab-pane fade" id="dessert-tab-pane" role="tabpanel" aria-labelledby="dessert-tab" tabindex="0">
				<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 gap-4 pt-3">
					<ProductItem v-for="food of menuStore.getProductsByFilter('dessert')" v-bind="food"/>
				</div>
			</div>
		</div>
	</section>
</template>

<style >

</style>