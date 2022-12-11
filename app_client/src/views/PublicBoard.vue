<script setup>
import {ref, computed} from 'vue'
import PublicBoardItem from "@/components/publicBoard/PublicBoardItem.vue";

import {useOrdersStore} from "@/stores/order";

const orderStore = useOrdersStore();

const orderStatusList = ref(['Preparing', 'Ready', 'Delivered']);
const orderTypeActive = ref('Preparing');

const orderList = ref([
	{
		id: 1,
		date: '20:00',
		status: 'Preparing'
	},
	{
		id: 2,
		date: '20:02',
		status: 'Preparing'
	},
	{
		id: 3,
		date: '20:15',
		status: 'Ready'
	},
	{
		id: 4,
		date: '21:00',
		status: 'Delivered'
	},
	])

	
const filterOrder = computed(() => {
	return orderList.value.filter(item => item.type === orderTypeActive.value)
});

</script>

<template>
	<section>
		<div class="align-items-center d-flex justify-content-between">
			<h4 class="text-uppercase text-bold">Public Board</h4>
			<ul class="nav nav-pills tabs-filter gap-4">
				<li class="nav-item" role="presentation" v-for="(orderStatus, index) of orderStatusList"
					:key="'tabs_' + index">
				</li>
			</ul>
			<div class="width-150"></div>
		</div>

		<div class="row row-cols-3 mt-3 m-0">
			<div class="column px-2 row row-cols-2">
				<PublicBoardItem v-for="item of filterOrder" v-bind="item"/>
			</div>
			<div class="column px-2">
			</div>
			<div class="column px-2">
			</div>
		</div>
	</section>
</template>

<style scoped>* {
  box-sizing: border-box;
}

.row {
  margin-left:-5px;
  margin-right:-5px;
}
  
.column {
  float: left;
  width: 32%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 16px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

body{
	background: gray;
}
</style>
  