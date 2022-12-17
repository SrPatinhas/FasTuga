<script setup>
import {ref, computed} from 'vue'
import DashboardItem from "@/components/dashboard/DashboardItem.vue";

import {useOrdersKitchenStore} from "@/stores/ordersKitchen";

const orderKitchenStore = useOrdersKitchenStore();

const orderKitchenPlaceList = ref(['All', 'Kitchen', 'Delivered', 'Waiting']);
const orderKitchenPlaceActive = ref('All');

const orderKitchenStatusList = ref(['Preparing', 'Ready', 'Delivered', 'Cancelled']);
const orderKitchenTypeActive = ref('Preparing');
const orderKitchenList = ref([
	{
		id: 12,
		date: '2022-12-08 20:00',
		employeeName: 'Jéjé',
		method: 'Card',
		place: 'Kitchen',
		type: 'Preparing',
		status: 'waiting',
		price: 1.4,
		paid: 2,
		clientName: "Alice",
		numberOfPoints: 10,
		items: [
			{
				"id": 152,
				"name": "Alheira",
				"image": "jBMVpJbZ8uJMRE8N.jpg",
				"price": 9.9,
				"type": "hot dish",
				"description": "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King.",
				"count": 3
			}
		]
	},
	{
		id: 13,
		date: '2022-12-08 20:00',
		employeeName: 'Jéjé',
		method: 'Card',
		place: 'Kitchen',
		type: 'Preparing',
		status: 'waiting',
		price: 1.4,
		paid: 2,
		clientName: "Alice",
		numberOfPoints: 10,
		items: [
			{
				"id": 153,
				"name": "Alheira 2",
				"image": "jBMVpJbZ8uJMRE8N.jpg",
				"price": 19.9,
				"type": "hot dish",
				"description": "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King.",
				"count": 3
			},
			{
				"id": 152,
				"name": "Alheira",
				"image": "jBMVpJbZ8uJMRE8N.jpg",
				"price": 9.9,
				"type": "hot dish",
				"description": "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King.",
				"count": 3
			}
		]
	},
	{
		id: 14,
		date: '2022-12-08 20:00',
		employeeName: 'Jéjé',
		method: 'Card',
		place: 'Delivered',
		type: 'Preparing',
		status: 'waiting',
		price: 1.4,
		paid: 2,
		clientName: "Alice",
		numberOfPoints: 10,
		items: [
			{
				"id": 153,
				"name": "Alheira 2",
				"image": "jBMVpJbZ8uJMRE8N.jpg",
				"price": 19.9,
				"type": "hot dish",
				"description": "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King.",
				"count": 3
			},
			{
				"id": 152,
				"name": "Alheira",
				"image": "jBMVpJbZ8uJMRE8N.jpg",
				"price": 9.9,
				"type": "hot dish",
				"description": "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King.",
				"count": 3
			}
		]
	},
	{
		id: 15,
		date: '2022-12-08 20:00',
		employeeName: 'Jéjé',
		method: 'Card',
		place: 'Delivered',
		type: 'Preparing',
		price: 1.4,
		paid: 2,
		clientName: "Alice",
		numberOfPoints: 10,
		items: [
			{
				"id": 153,
				"name": "Alheira 2",
				"image": "jBMVpJbZ8uJMRE8N.jpg",
				"price": 19.9,
				"type": "hot dish",
				"description": "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King.",
				"count": 3
			},
			{
				"id": 152,
				"name": "Alheira",
				"image": "jBMVpJbZ8uJMRE8N.jpg",
				"price": 9.9,
				"type": "hot dish",
				"description": "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King.",
				"count": 3
			}
		]
	},
	{
		id: 16,
		date: '2022-12-08 20:00',
		employeeName: 'Jéjé',
		method: 'Card',
		place: 'Delivered',
		type: 'Preparing',
		price: 1.4,
		paid: 2,
		clientName: "Alice",
		numberOfPoints: 10,
		items: [
			{
				"id": 153,
				"name": "Alheira 2",
				"image": "jBMVpJbZ8uJMRE8N.jpg",
				"price": 19.9,
				"type": "hot dish",
				"description": "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King.",
				"count": 3
			},
			{
				"id": 152,
				"name": "Alheira",
				"image": "jBMVpJbZ8uJMRE8N.jpg",
				"price": 9.9,
				"type": "hot dish",
				"description": "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King.",
				"count": 3
			}
		]
	},
	{
		id: 17,
		date: '2022-12-08 20:00',
		employeeName: 'Jéjé',
		method: 'Card',
		place: 'Waiting',
		type: 'Preparing',
		price: 1.4,
		paid: 2,
		clientName: "Alice",
		numberOfPoints: 10,
		items: [
			{
				"id": 153,
				"name": "Alheira 2",
				"image": "jBMVpJbZ8uJMRE8N.jpg",
				"price": 19.9,
				"type": "cold dish",
				"description": "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King.",
				"count": 3
			},
			{
				"id": 152,
				"name": "Alheira",
				"image": "jBMVpJbZ8uJMRE8N.jpg",
				"price": 9.9,
				"type": "hot dish",
				"description": "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King.",
				"count": 3
			}
		]
	}
]);

function changeTab(type) {
	orderKitchenTypeActive.value = type;
}

const filterOrderKitchen = computed(() => {
	return orderKitchenList.value.filter(item => item.type === orderKitchenTypeActive.value)
});

</script>

<template>
	<section>
		<div class="sticky-header">
			<h4 class="text-uppercase text-bold">Dashboard</h4>
			<ul class="nav nav-pills tabs-filter gap-4">
				<li class="nav-item" role="presentation" v-for="(orderKitchenstatus, index) of orderKitchenStatusList"
					:key="'tabs_' + index">
					<button class="nav-link btn rounded-pill d-flex gap-2 align-items-center"
							:class="(orderKitchenTypeActive === orderKitchenstatus ? 'btn-secondary active' : 'btn-outline-secondary')"
							:id="'pills-' + orderKitchenstatus + '-tab'" type="button"
							@click="changeTab(orderKitchenstatus)">
						{{ orderKitchenstatus }}<span class="badge "
													  :class="orderKitchenTypeActive === orderKitchenstatus ? 'bg-white text-primary' : 'bg-primary'">{{ filterOrderKitchen.length }}</span>
					</button>
				</li>
			</ul>
			<div class="width-150"></div>
		</div>

		<div class="m-0 mt-5 row row-cols-3">
			<div class="column px-2 row row-cols-2">
				<DashboardItem v-for="item of filterOrderKitchen" v-bind="item"/>
			</div>
			<div class="column px-2">
			</div>
			<div class="column px-2">
			</div>
		</div>
	</section>
</template>

<style scoped>
</style>
  
  