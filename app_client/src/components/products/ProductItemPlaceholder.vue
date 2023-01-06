<template>
	<div class="col">
		<div class="card border-0 shadow" aria-hidden="true">
			<div class="position-relative placeholder-wave">
				<div class="card-img-top placeholder ratio ratio-16x9"></div>
				<i class="ci-image position-absolute top-50 start-50 translate-middle fs-1 text-muted opacity-50"></i>
			</div>
			<div class="card-body">
				<h5 class="card-title placeholder-glow">
					<span class="placeholder col-6"></span>
				</h5>
				<p class="card-text placeholder-glow">
					<span class="placeholder placeholder-sm col-7 me-2"></span>
					<span class="placeholder placeholder-sm col-4"></span>
					<span class="placeholder placeholder-sm col-4 me-2"></span>
					<span class="placeholder placeholder-sm col-6"></span>
				</p>
				<div class="d-flex justify-content-between align-items-center">
					<span class="placeholder placeholder-lg bg-primary col-2"></span>
					<div class="btn btn-icon disabled placeholder placeholder-wave">
						<i class="bi-bag"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: "ProductItemPlaceholder"
	}
</script>