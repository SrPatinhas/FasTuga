<template>
	<div v-if="pagination?.current_page">
		<nav aria-label="Page navigation" class="mt-3">
			<ul class="pagination justify-content-center">
				<li class="page-item" :class="pagination?.from == pagination?.current_page && 'disabled'">
					<a class="page-link" @click.prevent="changePage(pagination?.current_page - 1)">Previous</a>
				</li>
				<li class="page-item" v-for="page in pages" :key="page" :class="{ 'active': page === pagination?.current_page }">
					<a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
				</li>
				<li class="page-item" :class="pagination?.last_page == pagination?.current_page && 'disabled'">
					<a class="page-link" href="#" @click.prevent="changePage(pagination?.current_page + 1)">Next</a>
				</li>
			</ul>
		</nav>
	</div>
</template>

<script setup>
	import { ref, computed } from 'vue';

	const emit = defineEmits(["pageChange"]);
	const props = defineProps({
		pagination: {
			type: Object,
			required: true
		}
	});

	const offset = ref(3);

	function changePage(page){
		if(page > 0 && page <= props.pagination.total) {
			emit('pageChange', page);
		}
	}

	const pages = computed(() => {
		if (!props.pagination.to) {
			return [];
		}

		let from = props.pagination.current_page - offset.value;
		if (from < 1) {
			from = 1;
		}

		let to = from + (offset.value * 2);
		if (to >= props.pagination.last_page) {
			to = props.pagination.last_page;
		}

		let pages = [];
		while (from <= to) {
			pages.push(from);
			from++;
		}
		return pages;
	});
</script>