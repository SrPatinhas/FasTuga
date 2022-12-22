<template>
	<div class="col">
		<div class="align-items-center card d-flex flex-row justify-content-around p-5">
			<div class="align-items-center d-flex fw-bold h1 mb-0" :class="status.toLowerCase() === 'r' && 'text-success'">
				<span class="h5 mb-0 mx-1 text-muted">#</span>{{ ticket_number }}
			</div>
			<span class="text-muted">{{ date }}</span>
		</div>
    </div>

</template>

<script setup>
const item = defineProps({
	id: Number,
	status: String,
	status_label: String,
	date: String,
	ticket_number: Number
});

</script>
