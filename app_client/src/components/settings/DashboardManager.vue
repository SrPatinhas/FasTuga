<script setup>
	import {Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale} from 'chart.js';
	import { Bar } from 'vue-chartjs'
	import {computed, inject, reactive, ref} from "vue";
	const axios = inject('axios');

	ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

	const weeks = [];
	Date.prototype.getWeek = function () {
		const firstDay = new Date(this.getFullYear(), 0, 1);
		return Math.ceil((((this - firstDay) / 86400000) + firstDay.getDay() + 1) / 7);
	}

	for (let i = 0; i < 6; i++) {
		const weekStart = new Date(new Date().setDate(new Date().getDate() - new Date().getDay() - i * 7));
		const weekEnd = new Date(weekStart.getFullYear(), weekStart.getMonth(), weekStart.getDate() + 6);
		const weekNumber = weekStart.getWeek();

		//weeks.push({
		//	week_number: weekNumber,
		//	start: weekStart,
		//	end: weekEnd,
		//});
		weeks.push(weekNumber);
	}


	const loaded = ref(false);
	const statistics = ref({});
	const data = reactive({
		labels: [5, 4, 3, 2, 1, 0],
		datasets: [
			{
				label: 'Data One',
				backgroundColor: '#f87979',
				data: []
			}
		]
	});
	async function fetchGraphValues() {
		const response = await axios.get('/employees/statistic');
		data.datasets[0].data = response.data.chart;
		delete response.data.chart;
		statistics.value = response.data;
		loaded.value = true;
	}
	fetchGraphValues();

	const startOfMonth = new Date();
	startOfMonth.setDate(1);
	startOfMonth.setMonth(startOfMonth.getMonth());
	const startOfMonthString = computed(() => {
		return startOfMonth.toLocaleDateString('en-US', { day: '2-digit', month: '2-digit', year: 'numeric' });
	});
	const currentDay = computed(() => {
		return new Date().toLocaleDateString('en-US', { day: '2-digit', month: '2-digit',  year: 'numeric' });
	});
</script>

<template>
	<!-- Content-->
	<section class="col-lg-8 pt-lg-4 pb-4 mb-3">
		<div class="pt-2 px-4 ps-lg-0 pe-xl-5">
			<h2 class="h3 py-2 text-center text-sm-start">Your sales / earnings</h2>
			<div class="row mx-n2 pt-2" v-if="statistics.monthReveneu !== undefined">
				<div class="col-md-4 col-sm-6 px-2 mb-4">
					<div class="bg-secondary h-100 rounded-3 p-4 text-center">
						<h3 class="fs-sm text-muted">Earnings (this month)</h3>
						<p class="h2 mb-2">{{ statistics.monthReveneu.toFixed(2) }}€</p>
						<p class="fs-ms text-muted mb-0">{{ startOfMonthString }} - {{ currentDay }}</p>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 px-2 mb-4">
					<div class="bg-secondary h-100 rounded-3 p-4 text-center">
						<h3 class="fs-sm text-muted">Products sold</h3>
						<p class="h2 mb-2">{{ statistics.orderItems }}</p>
						<p class="fs-ms text-muted mb-0">{{ startOfMonthString }} - {{ currentDay }}</p>
					</div>
				</div>
				<div class="col-md-4 col-sm-12 px-2 mb-4">
					<div class="bg-secondary h-100 rounded-3 p-4 text-center">
						<h3 class="fs-sm text-muted">Orders made </h3>
						<p class="h2 mb-2">{{ statistics.orders }}</p>
						<p class="fs-ms text-muted mb-0">{{ startOfMonthString }} - {{ currentDay }}</p>
					</div>
				</div>
			</div>
			<div class="row mx-n2">
				<div class="col-lg-8 px-2">
					<div class="card mb-4 mb-lg-2">
						<div class="card-body">
							<!-- TODO Pedido para este "grafico" -->
							<h3 class="fs-sm pb-3 mb-3 border-bottom">Total Revenue <span class="fw-normal fs-xs text-muted">(Past 6 weeks)</span></h3>
							<Bar v-if="loaded" :data="data" />
						</div>
					</div>
				</div>
				<div class="col-lg-4 px-2">
					<div class="card">
						<div class="card-body">
							<h3 class="fs-sm pb-3 mb-0 border-bottom">Your top 5 Dishes</h3>

							<div class="d-flex justify-content-between align-items-center fs-sm py-2 border-bottom" v-for="(item, index) of statistics.topItems" :key="index">
								<div class="d-flex align-items-start py-1">
									<img :src="item.photo_url" width="20" :alt="item.name">
									<div class="ps-1">{{ item.name }}</div>
								</div>
								<span>{{ item.price }}€</span>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>