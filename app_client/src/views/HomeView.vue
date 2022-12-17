<script setup>
	import ProductItem from "@/components/products/ProductItem.vue";
	import ProductItemPlaceholder from "@/components/products/ProductItemPlaceholder.vue";
	import {useMenuStore} from "@/stores/menu";
	import {useUserStore} from "@/stores/user";
	import {useRouter} from "vue-router";

	const menuStore = useMenuStore();
	const userStore = useUserStore();
	const router = useRouter()

	menuStore.fetchProductsTrending();

	const guestUser = () => {
		userStore.loginAsGuest();
		router.push({name: 'Menus'});
	}
</script>

<template>
	<div class="home mb-5">
		<section class="pt-4">
			<h2 class="h3 mb-4 pt-2 text-center">How it works?</h2>
			<div class="row g-0 bg-light rounded-3">
				<div class="col-xl-4 col-lg-12 col-md-4 border-end">
					<div class="py-3">
						<div class="d-flex align-items-center mx-auto py-3 px-3" style="max-width: 362px;">
							<div class="display-3 fw-normal opacity-15 me-4">01</div>
							<div class="ps-2">
								<i class="bi-card-list d-block text-center" style="font-size: 5rem;"></i>
								<p class="mb-3 pt-1">You order your favorite food</p>
							</div>
						</div>
						<hr class="d-md-none d-lg-block d-xl-none">
					</div>
				</div>
				<div class="col-xl-4 col-lg-12 col-md-4 border-end">
					<div class="py-3">
						<div class="d-flex align-items-center mx-auto py-3 px-3" style="max-width: 362px;">
							<div class="display-3 fw-normal opacity-15 me-4">02</div>
							<div class="ps-2">
								<i class="bi-clock-history d-block text-center" style="font-size: 5rem;"></i>
								<p class="mb-3 pt-1">Your request will be prepared and ready</p>
							</div>
						</div>
						<hr class="d-md-none d-lg-block d-xl-none">
					</div>
				</div>
				<div class="col-xl-4 col-lg-12 col-md-4">
					<div class="py-3">
						<div class="d-flex align-items-center mx-auto py-3 px-3" style="max-width: 362px;">
							<div class="display-3 fw-normal opacity-15 me-4">03</div>
							<div class="ps-2">
								<i class="bi-cup-straw d-block text-center" style="font-size: 5rem;"></i>
								<p class="mb-3 pt-1">We send you a notification to get your food!</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="pt-4">
			<div class="row pt-4 mt-2 mt-lg-3 mb-md-2">
				<div class="col-lg-6 mb-grid-gutter">
					<div class="d-block d-sm-flex justify-content-around align-items-center bg-faded-info rounded-3">
						<div class="pt-5 py-sm-5 px-4 ps-md-5 pe-md-0 text-center text-sm-start">
							<h2>Login in your account</h2>
							<p class="text-muted pb-2">Earn points with each order you do.</p><a class="btn btn-primary" href="/login">Start earning</a>
						</div>
						<i class="bi-person-square d-block mx-auto mx-sm-0 text-center" style="font-size: 5rem;"></i>
					</div>
				</div>
				<div class="col-lg-6 mb-grid-gutter">
					<div class="d-block d-sm-flex justify-content-around align-items-center bg-faded-warning rounded-3">
						<div class="pt-5 py-sm-5 px-4 ps-md-5 pe-md-0 text-center text-sm-start">
							<h2>Order Anonymously</h2>
							<p class="text-muted pb-2">Grow your business by reaching new customers.</p>
							<a class="btn btn-primary" @click="guestUser">Start your order</a>
						</div>
						<i class="bi-cup-straw d-block text-center" style="font-size: 5rem;"></i>
					</div>
				</div>
			</div>
		</section>
		<section class="pt-4">
			<h2 class="text-center pt-4 pt-sm-3">Trending food in this restaurant</h2>
			<p class="text-muted text-center">Choose what you want and we make it for you</p>
			<div  v-if="menuStore.productsTrendingLoading">
				<div class="row row-cols-2 row-cols-md-4">
					<ProductItemPlaceholder v-for="index in 8" :key="index"/>
				</div>
			</div>
			<div v-else>
				<div class="row row-cols-2 row-cols-md-4">
					<ProductItem v-for="(food, index) of menuStore.productsTrending" :key="'trending_' + index" v-bind="food"/>
				</div>
				<div class="d-flex flex-row-reverse mt-3">
					<router-link class="btn btn-outline-secondary" :to="{ name: 'Menus' }">Show more items</router-link>
				</div>
			</div>
		</section>
	</div>
</template>
