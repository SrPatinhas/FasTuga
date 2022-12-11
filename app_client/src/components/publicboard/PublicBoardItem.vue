<template>
	<li class="align-items-center card d-flex flex-row justify-content-around p-5">
		<div class="align-items-center d-flex fw-bold h1 mb-0" :class="status === 'Ready' && 'text-success'">
			<span class="h5 mb-0 mx-1 text-muted">#</span>{{ id }}
		</div>
		<span class="text-muted">{{ date }}</span>
    </li>

</template>

<script setup>
const item = defineProps({
	id: Number,
	status: String,
	date: String
});

</script>
