<template>
	<div class="col">
		<div class="card h-100">
			<div class="card-header border-bottom">
				<div class="d-flex justify-content-between align-items-center">
					<h4 class="m-0"><span class="badge bg-info">#{{ id }}</span> <span class="fs-5 text-muted">{{ status }}</span></h4>
					<h5 class="m-0">{{ employeeName }}</h5>
				</div>
			</div>
			<div class="card-body">
				<div v-if="items.length > 0" class="accordion_items">
					<div class="d-flex align-items-center mb-2 border-bottom fw-bold ">
						<span class="flex-1 mb-0">Item</span>
						<span class="mb-0">Status</span>
					</div>
					<div v-for="(item, index) in items" :key="index" class="py-2 border-bottom">
						<div class="d-flex align-items-center" :class="item.type !== 'hot dish' && 'opacity-25 text-decoration-line-through'">
							<span class="flex-1 mb-0" :class="item.type === 'hot dish' && 'text-900 fw-semi-bold'">{{ item.name }}</span>
							<span class="mb-0" v-if="item.type === 'hot dish'">
								<button class="btn btn-primary">Ready</button>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body p-0 flex-1">
				<div class="accordion accordion-flush">
					<div class="accordion-item">
						<h2 class="accordion-header" :id="'flush-heading_' + id">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#flush-collapse_' + id" aria-expanded="false" :aria-controls="'flush-collapse_' + id">
								More Details
							</button>
						</h2>
						<div :id="'flush-collapse_' + id" class="accordion-collapse collapse" :aria-labelledby="'flush-heading_' + id" :data-bs-parent="'#accordionFlush_' + id">
							<div class="accordion-body p-0">
								<div class="p-3 border">
									<h5>Payment</h5>
									<div>
										<div><b>Method:</b> <span>{{ method }}</span></div>
										<div><b>Price:</b> <span>{{ price }}</span></div>
										<div><b>Paid:</b> <span>{{ paid }}</span></div>
									</div>
								</div>
								<div class="p-3 border">
									<h5>Client</h5>
									<div>
										<div><b>Name:</b> <span>{{ clientName }}</span></div>
										<div><b>Points:</b> <span>{{ numberOfPoints }}</span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer flex-nowrap p-0">
				<button type="button" class="btn btn-link col-6 text-decoration-none border-end">
					[Kitchen] OK
				</button>
				<button type="button" class="btn btn-link text-decoration-none col-6 m-0">
					[Delivery] OK
				</button>
			</div>
		</div>
	</div>
</template>

<script setup>
const item = defineProps({
	id: Number,
	status: String,
	employeeName: String,
	method: String,
	price: Number,
	Paid: String,
	clientName: String,
	numberOfPoints: Number,
	items: Array
});
</script>


<style scoped>

</style>