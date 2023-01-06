<template>
	<div class="mt-3">
		<div class="bg-light shadow-lg rounded-3 overflow-hidden">
			<div class="row">
				<!-- Sidebar-->
				<settingsBar/>
				<!-- Content-->
				<router-view></router-view>
			</div>
		</div>
	</div>
</template>

<script setup>
	import SettingsBar from "../components/navigation/SettingsBar.vue";
</script>