<template>
	<!-- Item-->
	<div class="py-4">
		<div class="card p-4" :class="status !=='D' ? status ==='C' ? 'bg-faded-warning' : 'bg-faded-info' : ''">
			<div class="d-block fs-1 text-success">
				<span class="fw-sm fs-3 text-muted">#</span>{{ ticket_number }}
			</div>
			<div class="text-center text-sm-start">
				<h3 class="h6 product-title mb-2">{{ update_at }}</h3>
				<div class="d-inline-block text-muted fs-ms">Items: <span class="fw-medium">{{ total_items }}</span></div>
				<div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">Points Earned: <span class="fw-medium">{{ points_gained }}</span></div>
				<div class="d-flex justify-content-center justify-content-sm-start pt-3">
					<div class="d-inline-block text-accent">€{{ total_price }}</div>
					<div class="d-inline-block text-accent border-start ms-2 ps-2">Paid with: <span class="fw-medium">{{ payment_type }}</span></div>
				</div>
				<div class="d-flex justify-content-center justify-content-sm-start pt-3" v-if="status ==='D'">
					<div class="d-inline-block text-muted fs-ms">Delivered by: <span class="fw-medium">{{ delivered_by }}</span></div>
				</div>
				<div class="d-flex justify-content-center justify-content-sm-start pt-3" v-else>
					<div class="d-inline-block text-muted fs-ms">Status: <span class="fw-medium">{{ status_label }}</span></div>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
	const prod = defineProps({
		id: Number,
		ticket_number: Number,
		status: String,
		status_label: String,
		total_price: Number,
		total_paid: Number,
		points_gained: Number,
		payment_type: String,
		date: String,
		delivered_by: String,
		created_at: String,
		update_at: String,
		total_items: Number,
	});
</script>