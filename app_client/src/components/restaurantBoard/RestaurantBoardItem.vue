<template>
	<div class="col">
		<div class="card h-100">
			<div class="card-header border-bottom">
				<div class="d-flex justify-content-between align-items-center">
					<h4 class="m-0"><span class="badge bg-info">#{{ id }} - {{ ticket_number }}</span> <span class="fs-5 text-muted">{{ status_label }}</span></h4>
					<h5 class="m-0">
						{{ created_at }}
					</h5>
				</div>
			</div>
			<div class="card-body">
				<div v-if="items.length > 0" class="accordion_items">
					<div class="d-flex align-items-center mb-2 border-bottom fw-bold ">
						<span class="flex-1 mb-0">Item</span>
						<span class="mb-0">Status</span>
					</div>
					<div v-for="(item, index) in items" :key="index" class="py-2 border-bottom">
						<div class="d-flex align-items-center" :class="item.product_type !== 'hot dish' && 'opacity-25 text-decoration-line-through'">
							<span class="flex-1 mb-0" :class="item.product_type === 'hot dish' && 'text-900 fw-semi-bold'">{{ item.product_name }}</span>
							<span class="mb-0" v-if="item.product_type === 'hot dish'">
								<button class="btn btn-primary">Ready</button>
							</span>
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
	user_id: Number,
	items: Array,
	created_at: String,
	date: String,
	status: String,
	status_label: String,
	ticket_number: String,
	update_at: String,
});
</script>


<style scoped>

</style>