<script setup>
	import {ref, computed} from 'vue'
	import PublicBoardItem from "@/components/publicboard/PublicBoardItem.vue";

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
			id: 78,
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
			status: 'Ready'
		}
	]);

	const filterOrder_Preparing = computed(() => {
		return orderList.value.filter(item => item.status === 'Preparing')
	});
	const filterOrder_Ready = computed(() => {
		return orderList.value.filter(item => item.status === 'Ready');
	});
</script>

<template>
	<section>
		<h4 class="text-uppercase text-bold">Public Board</h4>

		<div class="row row-cols-2 mt-3 m-0">
			<div class="col border-end border-r-2">
				<div class="bg-white m-auto mb-3 p-2 shadow-sm text-center w-75 fs-3">
					Preparing<span class="badge bg-primary mx-2">{{ filterOrder_Preparing.length }}</span>
				</div>
				<div class="column px-2 row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
					<PublicBoardItem v-for="(item, index) of filterOrder_Preparing" v-bind="item" :key="'board_preparing_' + index"/>
				</div>
			</div>
			<div class="col">
				<div class="bg-white m-auto mb-3 p-2 shadow-sm text-center w-75 fs-3">
					Ready<span class="badge bg-primary mx-2">{{ filterOrder_Ready.length }}</span>
				</div>
				<div class="column px-2 row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
					<PublicBoardItem v-for="(item, index) of filterOrder_Ready" v-bind="item" :key="'board_ready_' + index"/>
				</div>
			</div>
		</div>
	</section>
</template>

<style scoped>
</style>