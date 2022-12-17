<script setup>
	import { ref } from 'vue'
	import ProductItem from "@/components/products/ProductItem.vue";

	const foodTypeList = ref(['hot', 'cold', 'drinks', 'desserts']);
	const foodTypeActive = ref('hot');
	const foodList = ref([1, 2, 3]);

	function changeTab(type) {
		foodTypeActive.value = type;
	}
</script>

<template>
	<section id="our_menu" class="pt-5 pb-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="page_title text-center mb-4">
						<h1>our menu</h1>
						<div class="single_line"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<ul class="nav nav-tabs menu_tab mb-4" id="myTab" role="tablist">
					<li v-for="foodType of foodTypeList" class="nav-item">
						<a class="nav-link" :class="foodTypeActive === foodType ?? 'active'" :id="foodType + '-tab'" data-toggle="tab" :href="foodType" @click="changeTab(foodType)" role="tab">{{ foodType }}</a>
					</li>
				</ul>
			</div>
			<div class="row">
				<div class="tab-content col-lg-12" id="myTabContent">
					<div class="tab-pane fade show active" id="breakfast" role="tabpanel" aria-labelledby="breakfast-tab">
						<div class="row">
							<div v-for="food of foodList" class="col-md-6">
								<ProductItem />
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="lunch" role="tabpanel" aria-labelledby="lunch-tab">
						<div class="row">
							<div class="col-md-6">
								<div class="single_menu">
									<img src="https://i.imgur.com/Aowufa1.jpg" alt="pizza">
									<div class="menu_content">
										<h4>12" Pizza  <span>$35</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
								<div class="single_menu">
									<img src="https://i.imgur.com/DJlmZDJ.jpg" alt="salad">
									<div class="menu_content">
										<h4>Salad <span>$20</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
								<div class="single_menu">
									<img src="https://i.imgur.com/knnQm7e.jpg" alt="green tea">
									<div class="menu_content">
										<h4>green tea <span>$15</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
								<div class="single_menu">
									<img src="https://i.imgur.com/YkDi8Nb.jpg" alt="meat">
									<div class="menu_content">
										<h4>meat  <span>$24</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="single_menu">
									<img src="https://i.imgur.com/kbpceNv.jpg" alt="burger">
									<div class="menu_content">
										<h4>Chicken Burger  <span>$24</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
								<div class="single_menu">
									<img src="https://i.imgur.com/lYKUORL.jpg" alt="black coffee">
									<div class="menu_content">
										<h4>Black coffee <span>$20</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
								<div class="single_menu">
									<img src="https://i.imgur.com/AXAHrf6.jpg" alt="fried rice">
									<div class="menu_content">
										<h4>Fried Rice  <span>$45</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
								<div class="single_menu">
									<img src="https://i.imgur.com/YkDi8Nb.jpg" alt="meat">
									<div class="menu_content">
										<h4>meat  <span>$24</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="dinner" role="tabpanel" aria-labelledby="dinner-tab">
						<div class="row">
							<div class="col-md-6">
								<div class="single_menu">
									<img src="https://i.imgur.com/kbpceNv.jpg" alt="burger">
									<div class="menu_content">
										<h4>Chicken Burger  <span>$24</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
								<div class="single_menu">
									<img src="https://i.imgur.com/lYKUORL.jpg" alt="black coffee">
									<div class="menu_content">
										<h4>Black coffee <span>$20</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
								<div class="single_menu">
									<img src="https://i.imgur.com/AXAHrf6.jpg" alt="fried rice">
									<div class="menu_content">
										<h4>Fried Rice  <span>$45</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
								<div class="single_menu">
									<img src="https://i.imgur.com/YkDi8Nb.jpg" alt="meat">
									<div class="menu_content">
										<h4>meat  <span>$24</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="single_menu">
									<img src="https://i.imgur.com/kbpceNv.jpg" alt="burger">
									<div class="menu_content">
										<h4>Chicken Burger  <span>$24</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
								<div class="single_menu">
									<img src="https://i.imgur.com/lYKUORL.jpg" alt="black coffee">
									<div class="menu_content">
										<h4>Black coffee <span>$20</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
								<div class="single_menu">
									<img src="https://i.imgur.com/AXAHrf6.jpg" alt="fried rice">
									<div class="menu_content">
										<h4>Fried Rice  <span>$45</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
								<div class="single_menu">
									<img src="https://i.imgur.com/YkDi8Nb.jpg" alt="meat">
									<div class="menu_content">
										<h4>meat  <span>$24</span></h4>
										<p>Aperiam tempore sit,perferendis numquam repudiandae porro voluptate dicta saepe facilis.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<a href="#" class=" menu_btn btn btn-danger">view more</a>
			</div>
		</div>
	</section>
</template>

<style scoped>
	.page_title {
		padding: 30px 0px;
	}
	.page_title h1 {
		color: #c0392b;
		font-weight: 700;
		line-height: 2;
		margin-bottom: 0;
		position: relative;
		text-transform: capitalize;
	}
	.page_title h1::before {
		background: #c0392b;
		width: 70px;
		height: 2px;
		position: absolute;
		content: '';
		top: 90%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	.page_title h1::after {
		position: absolute;
		content: '';
		background: #fbc531;
		width: 30px;
		height: 2px;
		top: 90%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	/*Menu starts*/
	.menu_tab {
		margin: 0 auto;
		justify-content: center;
	}
	.nav-item {
		display: inline-block;
		text-align: center;
	}
	.nav-tabs .nav-link{
		transition: .3s;
	}
	.nav-tabs .nav-link.active {
		background: #c0392b;
		color: #fff;
		font-weight: 700;
		border: 1px solid #c0392b;
		text-transform: capitalize;
	}
	.nav-link {
		color: #000;
	}
	.nav-tabs .nav-link:hover {
		background: #c0392b;
		color: #fff;
		border: 1px solid #c0392b;
	}
	.single_menu {
		position: relative;
		margin-bottom: 75px;
		transition: .3s;
	}
	.single_menu:hover img{
		-webkit-clip-path: polygon(0% 0%, 100% 0, 100% 50%, 100% 100%, 0% 100%);
		clip-path: polygon(0% 0%, 100% 0, 100% 50%, 100% 100%, 0% 100%);

	}
	.single_menu img {
		width: 33%;
		position: absolute;
		height: 140px;
		-webkit-clip-path: polygon(0% 0%, 75% 0%, 100% 50%, 75% 100%, 0% 100%);
		clip-path: polygon(0% 0%, 75% 0%, 100% 50%, 75% 100%, 0% 100%);
		transition: .3s;
		border: 1px solid #ddd;
		border-radius: 5px;
	}
	.menu_content {
		padding-left: 200px;
	}
	.menu_content h4 {
		font-size: 25px;
		font-weight: 300;
		border-bottom: 1px dashed #c0392b;
		line-height: 2;
		text-transform: capitalize;
	}
	.menu_content h4 span {
		font-size: 25px;
		font-weight: 800;
		float: right;
		font-style: italic;
		color: #c0392b;
	}
	.menu_content p {
		font-weight: 200;
		font-size: 16px;
		letter-spacing: 1px;
	}
	.menu_btn.btn.btn-danger {
		margin: 0 auto;
		display: block;
		width: 140px;
	}
	/*Menu ends*/
	.menu_btn.btn.btn-danger {
		margin: 0 auto;
		display: block;
		width: 140px;
	}
	.btn.btn-danger {
		background: #c0392b;
		border: 1px solid #c0392b;
		transition: .3s;
		position: relative;
		z-index: 1;
		text-transform: capitalize;
		font-weight: 700;
		overflow: hidden;
		padding: 15px 25px;
	}
	.btn.btn-danger::before {
		position: absolute;
		content: '';
		background: #e74c3c;
		width: 100%;
		height: 100%;
		left: -100%;
		top: 100%;
		transition: .3s;
		z-index: -1;
	}
	.btn.btn-danger:hover:before{
		top: 0;
		left: 0;
	}
</style>