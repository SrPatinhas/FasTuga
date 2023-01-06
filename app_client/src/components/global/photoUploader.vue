<template>
	<div class="align-items-center row">
		<div class="col-12 col-md-6 text-center avatar-upload">
			<img v-if="urlOld && previewImage === avatarNoneUrl" :src="urlOld" class="img-thumbnail" alt="avatar">
			<img v-else :src="previewImage" class="img-thumbnail" alt="avatar">
		</div>
		<div class="col-12 col-md-6 text-center">
			<label for="formFile" class="form-label">Upload your photo</label>
			<input class="form-control" type="file" id="formFile" @change="pickFile">
			<button class="btn btn-danger mt-2" v-if="hasImage" @click="clearImage">Clear Image</button>
		</div>
	</div>
</template>

<script setup>
	import {ref} from "vue";
	import avatarNoneUrl from '@/assets/avatar-none.png';

	const emit = defineEmits(['imageChange']);

	const photoDefault = defineProps({
		urlOld: String
	});

	const previewImage = ref(avatarNoneUrl);
	const hasImage = ref(false);
	const imgInput = ref(null);

	function pickFile(e) {
		imgInput.value = e;
		let input = e.target;
		let file = input.files
		if (file && file[0]) {
			let reader = new FileReader
			reader.onload = e => {
				previewImage.value = e.target.result;
				hasImage.value = true;
			}
			reader.readAsDataURL(file[0])
			emit('imageChange', file[0]);
		}
	}
	function clearImage() {
		previewImage.value = avatarNoneUrl;
		hasImage.value = false;
		imgInput.value.target.value = null
		emit('imageChange', null);
	}
</script>