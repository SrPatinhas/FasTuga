<template>
	<li class="list-group-item d-flex justify-content-between align-items-start">
			<div class="ms-2 me-auto">
				<div class="fw-bold h3">
					<span class="h5 text-muted">#</span> {{ id }}
				</div>
			</div>
			<span class="text-muted">{{ hour }}</span>
    </li>

</template>

<script setup>
const item = defineProps({
	id: Number,
	status: String,
	hour: String
});

</script>
