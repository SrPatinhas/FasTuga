<script setup>
	import { ref, computed } from 'vue'
	import MenuItem from "../components/menu/menuItem.vue";

	const foodTypeList = ref(['hot dish', 'cold dish', 'drink', 'dessert']);
	const foodTypeActive = ref('hot dish');
	const foodList = ref([
		{
			id: 12,
			name: '7-Up',
			image: 'KPNzRRCrbwnrxbgk.jpg',
			price: 1.4,
			type: 'drink',
			description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
		},
		{
			id: 123,
			name: 'Água das Pedras',
			image: 'KPNzRRCrbwnrxbgk.jpg',
			price: 1.4,
			type: 'drink',
			description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
		},
		{
			id: 142,
			name: 'Água do Luso',
			image: 'KPNzRRCrbwnrxbgk.jpg',
			price: 1.4,
			type: 'drink',
			description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
		},
		{
			id: 121,
			name: 'Aletria',
			image: 'QSJ8nyCgMiw40EkV.jpg',
			price: 3.40,
			type: 'dessert',
			description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
		},
		{
			id: 152,
			name: 'Alheira',
			image: 'jBMVpJbZ8uJMRE8N.jpg',
			price: 9.90,
			type: 'hot dish',
			description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
		},
		{
			id: 125,
			name: 'Arroz de Marisco',
			image: 'RmoYdKAGJzm10l9J.jpg',
			price: 9.90,
			type: 'hot dish',
			description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
		},
		{
			id: 212,
			name: 'Salada decNoodles',
			image: 'ulSMYjBpImeqSSEE.jpg',
			price: 9.90,
			type: 'cold dish',
			description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
		},
		{
			id: 126,
			name: 'Salada Fria de Frango',
			image: 'Vt0rlSQBE3jfJniu.jpg',
			price: 4.00,
			type: 'cold dish',
			description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
		},
	]);

	function changeTab(type) {
		foodTypeActive.value = type;
	}
	const filterFood = computed( () => {
		return foodList.value.filter( item => item.type === foodTypeActive.value )
	});
</script>

<template>
	<section id="store_menu" class="pt-5 pb-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="text-uppercase text-bold">Menu</h1>
				</div>
			</div>
			<div class="row">
				<ul class="nav nav-tabs justify-content-center menu_tab">
					<li v-for="foodType of foodTypeList" class="nav-item">
						<a class="nav-link text-capitalize" :class="foodTypeActive === foodType && 'active'" aria-current="page" href="#" @click="changeTab(foodType)">{{ foodType }}</a>
					</li>
				</ul>
			</div>
			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 gap-4 pt-3">
				<div v-for="food of filterFood" class="col">
					<MenuItem v-bind="food"/>
				</div>
			</div>
		</div>
	</section>
</template>

<style >

</style>