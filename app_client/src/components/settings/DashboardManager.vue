<script setup>
import SettingsBar from "../navigation/SettingsBar.vue"

</script>

<template>
	<!-- Content-->
	<section class="col-lg-8 pt-lg-4 pb-4 mb-3">
		<div class="pt-2 px-4 ps-lg-0 pe-xl-5">
			<h2 class="h3 py-2 text-center text-sm-start">Your sales / earnings</h2>
			<div class="row mx-n2 pt-2">
				<!-- TODO Pedido para estes 3 cards -->
				<div class="col-md-4 col-sm-6 px-2 mb-4">
					<div class="bg-secondary h-100 rounded-3 p-4 text-center">
						<h3 class="fs-sm text-muted">Earnings (before taxes)</h3>
						<p class="h2 mb-2">$1,690.<small>50</small></p>
						<p class="fs-ms text-muted mb-0">Sales 8/1/2021 - 8/15/2021</p>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 px-2 mb-4">
					<div class="bg-secondary h-100 rounded-3 p-4 text-center">
						<h3 class="fs-sm text-muted">Your balance</h3>
						<p class="h2 mb-2">$1,375.<small>00</small></p>
						<p class="fs-ms text-muted mb-0">To be paid on 8/15/2021</p>
					</div>
				</div>
				<div class="col-md-4 col-sm-12 px-2 mb-4">
					<div class="bg-secondary h-100 rounded-3 p-4 text-center">
						<h3 class="fs-sm text-muted">Lifetime earnings</h3>
						<p class="h2 mb-2">$9,156.<small>74</small></p>
						<p class="fs-ms text-muted mb-0">Based on list price</p>
					</div>
				</div>
			</div>
			<div class="row mx-n2">
				<div class="col-lg-8 px-2">
					<div class="card mb-4 mb-lg-2">
						<div class="card-body">
							<!-- TODO Pedido para este "grafico" -->
							<h3 class="fs-sm pb-3 mb-3 border-bottom">Order count <span class="fw-normal fs-xs text-muted">(Past 2 weeks)</span></h3>
							<div class="ct-chart ct-perfect-fourth line-chart-1" data-line-chart="{&quot;labels&quot;: [&quot;22 Jul&quot;, &quot;&quot;, &quot;24 Jul&quot;, &quot;&quot;, &quot;26 Jul&quot;, &quot;&quot;, &quot;28 Jul&quot;, &quot;&quot;, &quot;30 Jul&quot;, &quot;&quot;, &quot;01 Aug&quot;, &quot;&quot;, &quot;03 Aug&quot;, &quot;&quot;, &quot;05 Aug&quot;], &quot;series&quot;: [[0, 2, 4, 3, 1, 0, 0, 1, 0, 1, 1, 1, 0, 2, 0]]}" data-options="{&quot;axisY&quot;: {&quot;onlyInteger&quot;: true}}">
								<svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-line" style="width: 100%; height: 100%;">
									<g class="ct-grids">
										<line x1="50" x2="50" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line x1="76.37708333333333" x2="76.37708333333333" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line x1="102.75416666666666" x2="102.75416666666666" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line x1="129.13125000000002" x2="129.13125000000002" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line x1="155.50833333333333" x2="155.50833333333333" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line x1="181.88541666666669" x2="181.88541666666669" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line x1="208.26250000000002" x2="208.26250000000002" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line x1="234.63958333333335" x2="234.63958333333335" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line x1="261.01666666666665" x2="261.01666666666665" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line x1="287.39375" x2="287.39375" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line x1="313.77083333333337" x2="313.77083333333337" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line x1="340.1479166666667" x2="340.1479166666667" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line x1="366.52500000000003" x2="366.52500000000003" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line x1="392.90208333333334" x2="392.90208333333334" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line x1="419.2791666666667" x2="419.2791666666667" y1="15" y2="310.484375" class="ct-grid ct-horizontal"></line>
										<line y1="310.484375" y2="310.484375" x1="50" x2="445.65625" class="ct-grid ct-vertical"></line>
										<line y1="236.61328125" y2="236.61328125" x1="50" x2="445.65625" class="ct-grid ct-vertical"></line>
										<line y1="162.7421875" y2="162.7421875" x1="50" x2="445.65625" class="ct-grid ct-vertical"></line>
										<line y1="88.87109375" y2="88.87109375" x1="50" x2="445.65625" class="ct-grid ct-vertical"></line>
										<line y1="15" y2="15" x1="50" x2="445.65625" class="ct-grid ct-vertical"></line></g>
									<g>
										<g class="ct-series ct-series-a">
											<path d="M50,310.484C58.792,261.237,67.585,211.99,76.377,162.742C85.169,113.495,93.962,15,102.754,15C111.547,15,120.339,56.039,129.131,88.871C137.924,121.703,146.716,203.782,155.508,236.613C164.301,269.445,173.093,310.484,181.885,310.484C190.678,310.484,199.47,310.484,208.263,310.484C217.055,310.484,225.847,236.613,234.64,236.613C243.432,236.613,252.224,310.484,261.017,310.484C269.809,310.484,278.601,236.613,287.394,236.613C296.186,236.613,304.978,236.613,313.771,236.613C322.563,236.613,331.356,236.613,340.148,236.613C348.94,236.613,357.733,310.484,366.525,310.484C375.317,310.484,384.11,162.742,392.902,162.742C401.694,162.742,410.487,261.237,419.279,310.484" class="ct-line"></path>
											<line x1="50" y1="310.484375" x2="50.01" y2="310.484375" class="ct-point" ct:value="0"></line>
											<line x1="76.37708333333333" y1="162.7421875" x2="76.38708333333334" y2="162.7421875" class="ct-point" ct:value="2"></line>
											<line x1="102.75416666666666" y1="15" x2="102.76416666666667" y2="15" class="ct-point" ct:value="4"></line>
											<line x1="129.13125000000002" y1="88.87109375" x2="129.14125" y2="88.87109375" class="ct-point" ct:value="3"></line>
											<line x1="155.50833333333333" y1="236.61328125" x2="155.51833333333332" y2="236.61328125" class="ct-point" ct:value="1"></line>
											<line x1="181.88541666666669" y1="310.484375" x2="181.89541666666668" y2="310.484375" class="ct-point" ct:value="0"></line>
											<line x1="208.26250000000002" y1="310.484375" x2="208.2725" y2="310.484375" class="ct-point" ct:value="0"></line>
											<line x1="234.63958333333335" y1="236.61328125" x2="234.64958333333334" y2="236.61328125" class="ct-point" ct:value="1"></line>
											<line x1="261.01666666666665" y1="310.484375" x2="261.02666666666664" y2="310.484375" class="ct-point" ct:value="0"></line>
											<line x1="287.39375" y1="236.61328125" x2="287.40375" y2="236.61328125" class="ct-point" ct:value="1"></line>
											<line x1="313.77083333333337" y1="236.61328125" x2="313.78083333333336" y2="236.61328125" class="ct-point" ct:value="1"></line>
											<line x1="340.1479166666667" y1="236.61328125" x2="340.15791666666667" y2="236.61328125" class="ct-point" ct:value="1"></line>
											<line x1="366.52500000000003" y1="310.484375" x2="366.535" y2="310.484375" class="ct-point" ct:value="0"></line>
											<line x1="392.90208333333334" y1="162.7421875" x2="392.9120833333333" y2="162.7421875" class="ct-point" ct:value="2"></line>
											<line x1="419.2791666666667" y1="310.484375" x2="419.2891666666667" y2="310.484375" class="ct-point" ct:value="0"></line>
										</g>
									</g>
									<g class="ct-labels">
										<foreignObject style="overflow: visible;" x="50" y="315.484375" width="26.377083333333335" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 26px; height: 20px;">22 Jul</span></foreignObject>
										<foreignObject style="overflow: visible;" x="76.37708333333333" y="315.484375" width="26.377083333333335" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 26px; height: 20px;"></span></foreignObject>
										<foreignObject style="overflow: visible;" x="102.75416666666666" y="315.484375" width="26.37708333333334" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 26px; height: 20px;">24 Jul</span></foreignObject>
										<foreignObject style="overflow: visible;" x="129.13125000000002" y="315.484375" width="26.37708333333333" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 26px; height: 20px;"></span></foreignObject>
										<foreignObject style="overflow: visible;" x="155.50833333333333" y="315.484375" width="26.377083333333346" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 26px; height: 20px;">26 Jul</span></foreignObject>
										<foreignObject style="overflow: visible;" x="181.88541666666669" y="315.484375" width="26.37708333333333" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 26px; height: 20px;"></span></foreignObject>
										<foreignObject style="overflow: visible;" x="208.26250000000002" y="315.484375" width="26.37708333333333" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 26px; height: 20px;">28 Jul</span></foreignObject>
										<foreignObject style="overflow: visible;" x="234.63958333333335" y="315.484375" width="26.37708333333333" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 26px; height: 20px;"></span></foreignObject>
										<foreignObject style="overflow: visible;" x="261.01666666666665" y="315.484375" width="26.37708333333333" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 26px; height: 20px;">30 Jul</span></foreignObject>
										<foreignObject style="overflow: visible;" x="287.39375" y="315.484375" width="26.37708333333336" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 26px; height: 20px;"></span></foreignObject>
										<foreignObject style="overflow: visible;" x="313.77083333333337" y="315.484375" width="26.377083333333303" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 26px; height: 20px;">01 Aug</span></foreignObject>
										<foreignObject style="overflow: visible;" x="340.1479166666667" y="315.484375" width="26.37708333333336" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 26px; height: 20px;"></span></foreignObject>
										<foreignObject style="overflow: visible;" x="366.52500000000003" y="315.484375" width="26.377083333333303" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 26px; height: 20px;">03 Aug</span></foreignObject>
										<foreignObject style="overflow: visible;" x="392.90208333333334" y="315.484375" width="26.37708333333336" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 26px; height: 20px;"></span></foreignObject>
										<foreignObject style="overflow: visible;" x="419.2791666666667" y="315.484375" width="30" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">05 Aug</span></foreignObject>
										<foreignObject style="overflow: visible;" y="236.61328125" x="10" height="73.87109375" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 74px; width: 30px;">0</span></foreignObject>
										<foreignObject style="overflow: visible;" y="162.7421875" x="10" height="73.87109375" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 74px; width: 30px;">1</span></foreignObject>
										<foreignObject style="overflow: visible;" y="88.87109375" x="10" height="73.87109375" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 74px; width: 30px;">2</span></foreignObject>
										<foreignObject style="overflow: visible;" y="15" x="10" height="73.87109375" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 74px; width: 30px;">3</span></foreignObject>
										<foreignObject style="overflow: visible;" y="-15" x="10" height="30" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 30px; width: 30px;">4</span></foreignObject>
									</g>
								</svg>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 px-2">
					<div class="card">
						<div class="card-body">
							<h3 class="fs-sm pb-3 mb-0 border-bottom">Your top Dishes</h3>
							<!-- TODO Criar lista de top 10 dos produtos mais vendidos e o total que cada 1 fez -->
							<div class="d-flex justify-content-between align-items-center fs-sm py-2 border-bottom">
								<div class="d-flex align-items-start py-1">
<!--									<img src="img/marketplace/account/flags/usa.png" width="20" alt="USA">-->
									<div class="ps-1">prato 1</div>
								</div><span>$452</span>
							</div>
							<div class="d-flex justify-content-between align-items-center fs-sm py-2 border-bottom">
								<div class="d-flex align-items-start py-1">
<!--									<img src="img/marketplace/account/flags/sweden.png" width="20" alt="Sweden">-->
									<div class="ps-1">prato 1</div>
								</div><span>$318</span>
							</div>
							<div class="d-flex justify-content-between align-items-center fs-sm py-2 border-bottom">
								<div class="d-flex align-items-start py-1">
<!--									<img src="img/marketplace/account/flags/india.png" width="20" alt="India">-->
									<div class="ps-1">prato 1</div>
								</div><span>$106</span>
							</div>
							<div class="d-flex justify-content-between align-items-center fs-sm py-2 border-bottom">
								<div class="d-flex align-items-start py-1">
<!--									<img src="img/marketplace/account/flags/france.png" width="20" alt="France">-->
									<div class="ps-1">prato 1</div>
								</div><span>$82</span>
							</div>
							<div class="d-flex justify-content-between align-items-center fs-sm py-2 border-bottom">
								<div class="d-flex align-items-start py-1">
<!--									<img src="img/marketplace/account/flags/argentina.png" width="20" alt="Argentina">-->
									<div class="ps-1">prato 14</div>
								</div><span>$40</span>
							</div>
							<div class="d-flex justify-content-between align-items-center fs-sm pt-2">
								<div class="d-flex align-items-start py-1">
<!--									<img src="img/marketplace/account/flags/south-africa.png" width="20" alt="South Africa">-->
									<div class="ps-1">prato 23</div>
								</div><span>$17</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>