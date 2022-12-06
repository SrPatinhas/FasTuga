<template>
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2">Timeline</h1>
	</div>
	<div class="bg-dark py-4">
		<div class="container d-lg-flex justify-content-between py-2 py-lg-3">
			<div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
						<li class="breadcrumb-item"><a class="text-nowrap" href="index.html"><i class="bi-home"></i>Home</a></li>
						<li class="breadcrumb-item text-nowrap"><a href="#">Shop</a>
						</li>
						<li class="breadcrumb-item text-nowrap active" aria-current="page">Order tracking</li>
					</ol>
				</nav>
			</div>
			<div class="order-lg-1 pe-lg-4 text-center text-lg-start">
				<h1 class="h3 text-light mb-0">Tracking order: <span class="h4 fw-normal text-light">34VB5540K83</span></h1>
			</div>
		</div>
	</div>
	<div class="container py-5 mb-2 mb-md-3">
		<!-- Details-->
		<div class="row gx-4 mb-4">
			<div class="col-md-4 mb-2">
				<div class="bg-secondary h-100 p-4 text-center rounded-3"><span class="fw-medium text-dark me-2">Waitress:</span>Jose E.</div>
			</div>
			<div class="col-md-4 mb-2">
				<div class="bg-secondary h-100 p-4 text-center rounded-3"><span class="fw-medium text-dark me-2">Status:</span>Processing order</div>
			</div>
			<div class="col-md-4 mb-2">
				<div class="bg-secondary h-100 p-4 text-center rounded-3"><span class="fw-medium text-dark me-2">Expected date:</span>October 15, 2019</div>
			</div>
		</div>
		<!-- Progress-->
		<div class="card border-0 shadow-lg">
			<div class="card-body pb-2">
				<ul class="nav nav-tabs media-tabs nav-justified">
					<li class="nav-item">
						<div class="nav-link completed">
							<div class="d-flex align-items-center">
								<div class="media-tab-media"><i class="bi-bag"></i></div>
								<div class="ps-3">
									<div class="media-tab-subtitle text-muted fs-xs mb-1">First step</div>
									<h6 class="media-tab-title text-nowrap mb-0">Order placed</h6>
								</div>
							</div>
						</div>
					</li>
					<li class="nav-item">
						<div class="nav-link active">
							<div class="d-flex align-items-center">
								<div class="media-tab-media"><i class="bi-cup-hot"></i></div>
								<div class="ps-3">
									<div class="media-tab-subtitle text-muted fs-xs mb-1">Second step</div>
									<h6 class="media-tab-title text-nowrap mb-0">Processing order</h6>
								</div>
							</div>
						</div>
					</li>
					<li class="nav-item">
						<div class="nav-link">
							<div class="d-flex align-items-center">
								<div class="media-tab-media"><i class="bi-list-check"></i></div>
								<div class="ps-3">
									<div class="media-tab-subtitle text-muted fs-xs mb-1">Third step</div>
									<h6 class="media-tab-title text-nowrap mb-0">Quality check</h6>
								</div>
							</div>
						</div>
					</li>
					<li class="nav-item">
						<div class="nav-link">
							<div class="d-flex align-items-center">
								<div class="media-tab-media"><i class="bi-shop"></i></div>
								<div class="ps-3">
									<div class="media-tab-subtitle text-muted fs-xs mb-1">Fourth step</div>
									<h6 class="media-tab-title text-nowrap mb-0">Product dispatched</h6>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<!-- Footer-->
		<div class="d-sm-flex flex-wrap justify-content-between align-items-center text-center pt-4">
			<div class="form-check mt-2 me-3">
				<input class="form-check-input" type="checkbox" id="notify-me" checked="">
				<label class="form-check-label" for="notify-me">Notify me when order is delivered</label>
			</div><a class="btn btn-primary btn-sm mt-2" href="#order-details" data-bs-toggle="modal">View Order Details</a>
		</div>
		error
		<i class="bi bi-exclamation-circle-fill"></i>
	</div>
</template>

<script setup>

</script>

<style scoped>
.media-tabs .nav-item {
	margin-bottom: 0;
	text-align: left;
}
.media-tabs .nav-link {
	padding: 0.375rem 0.625rem;
}
.nav-link.completed .media-tab-media {
	overflow: visible;
}
.nav-link.disabled .media-tab-media, .nav-link.completed .media-tab-media {
	background-color: #f6f9fc;
	color: #7d879c;
}
.media-tab-media {
	position: relative;
	width: 3.75rem;
	height: 3.75rem;
	transition: color .25s ease-in-out,background-color .25s ease-in-out,box-shadow .25s ease-in-out,border-color .25s ease-in-out;
	border: 1px solid #e3e9ef;
	border-radius: 50%;
	background-color: #fff;
	color: #4b566b;
	text-align: center;
	overflow: hidden;
}
.media-tab-media>i {
	font-size: 1.25rem;
	line-height: calc(3.75rem - (1px * 2));
}
.nav-link.completed .media-tab-media::after {
	position: absolute;
	top: -0.175rem;
	right: -0.175rem;
	width: 1.25rem;
	height: 1.25rem;
	border-radius: 50%;
	background: #eafaf3;
	border: 1px solid #42d697;
	color: #42d697;
	font-family: bootstrap-icons !important;
	content: "\F272";
}
.media-tab-title, .media-tab-subtitle {
	transition: color .25s ease-in-out,background-color .25s ease-in-out,box-shadow .25s ease-in-out,border-color .25s ease-in-out;
}
.nav-link:not(.dropdown-toggle).active {
	pointer-events: none;
}
.nav-fill .nav-item .nav-link, .nav-justified .nav-item .nav-link {
	width: 100%;
}

.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
	color: var(--bs-nav-tabs-link-active-color);
	background-color: var(--bs-nav-tabs-link-active-bg);
	border-color: var(--bs-nav-tabs-link-active-border-color);
	border: 0;
}
.nav-link.active .media-tab-media, .nav-link.active:hover .media-tab-media {
	border-color: var(--bs-primary);
	background-color: var(--bs-primary);
	color: #fff;
	box-shadow: 0 0.5rem 1.125rem -0.5rem rgba(var(--bs-primary-rgb), 0.9);
}
.nav-link.active .media-tab-subtitle, .nav-link.active:hover .media-tab-subtitle {
	color: rgba(var(--bs-primary-rgb), 0.65) !important;
}
.nav {
	--bs-nav-link-padding-x: 1.25rem;
	--bs-nav-link-padding-y: 0.75rem;
	--bs-nav-link-font-weight: normal;
	--bs-nav-link-color: #4b566b;
	--bs-nav-link-hover-color: var(--bs-primary);
	--bs-nav-link-disabled-color: #7d879c;
	display: flex;
	flex-wrap: wrap;
	padding-left: 0;
	margin-bottom: 0;
	list-style: none;
}
.nav-tabs {
	--bs-nav-tabs-border-width: 1px;
	--bs-nav-tabs-border-color: #e3e9ef;
	--bs-nav-tabs-border-radius: 0;
	--bs-nav-tabs-link-hover-border-color: transparent;
	--bs-nav-tabs-link-active-color: var(--bs-primary);
	--bs-nav-tabs-link-active-bg: transparent;
	--bs-nav-tabs-link-active-border-color: var(--bs-primary);
	border-bottom: 0 solid var(--bs-nav-tabs-border-color);
}

.nav-tabs .nav-link {
	margin-bottom: calc(-1*var(--bs-nav-tabs-border-width));
	background: none;
	border: var(--bs-nav-tabs-border-width) solid rgba(0,0,0,0);
	border-top-left-radius: var(--bs-nav-tabs-border-radius);
	border-top-right-radius: var(--bs-nav-tabs-border-radius);
}
.nav-link {
	display: block;
	padding: var(--bs-nav-link-padding-y) var(--bs-nav-link-padding-x);
	font-size: var(--bs-nav-link-font-size);
	font-weight: var(--bs-nav-link-font-weight);
	color: var(--bs-nav-link-color);
	transition: color .25s ease-in-out,background-color .25s ease-in-out,box-shadow .25s ease-in-out,border-color .25s ease-in-out;
}
</style>