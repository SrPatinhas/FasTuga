<script setup>
	import {ref, computed} from 'vue'
	import OrderKitchenItem from "../components/dashboard/dashboardItem.vue";
	import {useOrdersKitchenStore} from "@/stores/ordersKitchen";

	const orderKitchenStore = useOrdersKitchenStore();

	const orderKitchenStatusList = ref(['Preparing', 'Ready', 'Delivered', 'Cancelled']);
	const orderKitchenTypeActive = ref('Preparing');
	const orderKitchenList = ref([
		{
			id: 12,
			date: '2022-12-08 20:00',
			employeeName: 'Jéjé',
			method: 'Card',
			type: 'Preparing',
			price: 1.4,
			paid: 2,
			clientName: "Alice",
			numberOfPoints: 10
		},
		{
			id: 13,
			date: '2022-12-08 20:00',
			employeeName: 'Jéjé',
			method: 'Card',
			type: 'Preparing',
			price: 1.4,
			paid: 2,
			clientName: "Alice",
			numberOfPoints: 10
		}
	]);

	function changeTab(type) {
		orderKitchenTypeActive.value = type;
	}

	const filterOrderKitchen = computed(() => {
		return orderKitchenList.value.filter(item => item.type === orderKitchenTypeActive.value)
	});

	const acc = document.getElementsByClassName("accordion");
	let i;

	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function () {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			if (panel.style.display === "block") {
				panel.style.display = "none";
			} else {
				panel.style.display = "block";
			}
		});
	}
</script>

<template>
	<section id="store_orderKitchen">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="text-uppercase text-bold">Menu</h1>
				</div>
			</div>

			<div class="row">

				<ul class="nav nav-tabs justify-content-center menu_tab">
					<li v-for="orderKitchenstatus of orderKitchenList" class="nav-item">
						<a class="nav-link text-capitalize"
						   :class="orderKitchenTypeActive === orderKitchenType && 'active'" aria-current="page" href="#"
						   @click="changeTab(orderKitchenstatus)">{{ orderKitchenstatus }}</a>
					</li>
				</ul>
			</div>
			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 gap-4 pt-3">
				<div v-for="item of filterOrderKitchen" class="col">
					<OrderKitchenItem v-bind="item"/>
				</div>
			</div>
		</div>
	</section>
</template>

<style scoped>
#filters {
	height: 2em;
	text-align: center;
	margin-bottom: 1.5em;
}

#filters a {
	font: bold 1.2em Arial, sans-serif;
	display: inline-block;
	height: 2em;
	line-height: 2;
	text-align: center;
	padding: 0 1em;
	margin-left: 1em;
	border: 2px solid #ccc;
	color: #000;
	text-decoration: none;
}

#filters a.selected {
	color: #08c;
	border-color: #08c;
}

* {
	box-sizing: border-box;
}

.row {
	margin-left: -5px;
	margin-right: -5px;
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

.description {
	text-align: left;
}

.title-left {
	text-align: left;
}

.title-right {
	text-align: right;
}

.title-center {
	text-align: center;
}

.accordion {
	background-color: #eee;
	color: #444;
	cursor: pointer;
	padding: 18px;
	width: 100%;
	border: none;
	text-align: left;
	outline: none;
	font-size: 15px;
	transition: 0.4s;
}

.active, .accordion:hover {
	background-color: #ccc;
}

.panel {
	padding: 0 18px;
	display: none;
	background-color: white;
	overflow: hidden;
}
</style>
  
  