<template>
	<div class="align-items-center d-flex pt-3 px-3">
		<h1 class="h2">Tracking order: <span class="h5 fw-normal">34VB5540K83</span></h1>
	</div>
	<div class="container py-3 mb-2 mb-md-3">
		<!-- Details-->
		<div class="row gx-4 mb-4">
			<div class="col-md-4 mb-2">
				<div class="border-0 card h-100 p-4 shadow-sm text-center"><span class="fw-medium text-dark me-2">Order Created at:</span>October 15, 2019</div>
			</div>
			<div class="col-md-4 mb-2">
				<div class="border-0 card h-100 p-4 shadow-sm text-center"><span class="fw-medium text-dark me-2">Status:</span>Processing order</div>
			</div>
			<div class="col-md-4 mb-2">
				<div class="border-0 card h-100 p-4 shadow-sm text-center"><span class="fw-medium text-dark me-2">Waitress:</span>Jose E.</div>
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
									<h6 class="media-tab-title text-nowrap mb-0">Order sent</h6>
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
				<input class="form-check-input" type="checkbox" id="notify-me" v-model="getNotifications">
				<label class="form-check-label" for="notify-me">Notify me when order is delivered</label>
			</div><a class="btn btn-primary btn-sm mt-2" href="#order-details" data-bs-toggle="modal">View Order Details</a>
		</div>
		error
		<i class="bi bi-exclamation-circle-fill"></i>
	</div>
	<button @click="triggerNotifications">Notify me!</button>

	<div class="toast-container position-fixed top-65px end-0 p-3" id="toastContainer"></div>

	<div class="modal fade" id="order-details" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Order No - 34VB5540K83</h5>
					<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pb-0 last-item-no-border">
					<order-detail-item v-for="item of orderStore.orderItems" v-bind="item" />
				</div>
				<!-- Footer-->
				<div class="modal-footer flex-wrap justify-content-between bg-secondary fs-md">
					<div class="px-2 py-1"><span class="text-muted">Subtotal:&nbsp;</span><span>$265.<small>00</small></span></div>
					<div class="px-2 py-1"><span class="text-muted">Points earned:&nbsp;</span><span>$22.<small>50</small></span></div>
					<div class="px-2 py-1"><span class="text-muted">Discount:&nbsp;</span><span>$9.<small>50</small></span></div>
					<div class="px-2 py-1"><span class="text-muted">Total:&nbsp;</span><span class="fs-lg">{{ (orderStore.totalOrderDetailCost).split(".")[0] }}.<small>{{ (orderStore.totalOrderDetailCost).split(".")[1] }}€</small></span></div>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
	import {inject, ref} from "vue";
	import logoUrlMini from '@/assets/logo.png';
	import { Toast } from "bootstrap";
	import {useUserStore} from "@/stores/user";
	import {useOrdersStore} from "@/stores/order";

	import OrderDetailItem from "@/components/order/orderDetailItem.vue";

	const socket = inject("socket");
	const orderDetail = ref({});
	const getNotifications = ref(false);

	const orderStore = useOrdersStore();
	const userStore = useUserStore();


	function triggerNotifications() {
		socket.emit('orderUpdateStatus',
			{
				id: 32,
				status: 'ready',
				employee: 'mc',
				chef: 'asdas asd',
				notes: '',
				user_id: userStore.userId,
				items: [{
					id: 12,
					name: '7-Up',
					image: 'KPNzRRCrbwnrxbgk.jpg',
					price: 1.4,
					type: 'drink',
					description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
				}]
			}
		);
	}

	socket.on('orderUpdateStatus', (order) => {
		console.log('orderUpdateStatus event');
		orderDetail.value = order;
		notifyBrowserUser();
	});

	// request permission on page load
	document.addEventListener('DOMContentLoaded', function() {
		if (!Notification) {
			alert('Desktop notifications not available in your browser. Try Chromium.');
			return;
		}
		if (Notification.permission !== 'granted')
			Notification.requestPermission();
	});

	function notifyBrowserUser() {
		toastCreate();
		if(!getNotifications.value){
			return false;
		}
		if (Notification.permission !== 'granted')
			Notification.requestPermission();
		else {
			const notification = new Notification('Your order was updated!', {
				icon: logoUrlMini,
				body: "Your order was just updated to the status '" + orderDetail.value.status + "'"
			});
			notification.onclick = function() {
				window.open('//stackoverflow.com/a/13328397/1269037');
			};
		}
	}

	function toastCreate() {
		const toastContainer = document.getElementById('toastContainer');
		const toastLength = toastContainer.childNodes.length;

		const toastTitle = "New Order update";
		const toastContent = "Your order was just updated to the status <b>" + orderDetail.value.status + "</b>";
		const toastId = 'toast_' + toastLength;

		const toastEl = `<div class="toast ${toastId}" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="toast-header">
				<img src="${logoUrlMini}" class="rounded me-2 width-25" alt="FasTuga">
				<strong class="me-auto">${toastTitle}</strong>
				<small class="text-muted">just now</small>
				<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			<div class="toast-body">${toastContent}</div>
		</div>`;

		toastContainer.insertAdjacentHTML( 'beforeend', toastEl);
		const toastNode = document.querySelector('.' + toastId);//document.getElementById('liveToast')
		toastNode.addEventListener('hidden.bs.toast', () => {
			toastNode.remove();
		});
		const toast = new Toast(toastNode);
		toast.show();
	}
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