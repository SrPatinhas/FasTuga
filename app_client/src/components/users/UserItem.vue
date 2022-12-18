<script setup>
	import {useUserStore} from "../../stores/user.js";
  const userStore = useUserStore();
  userStore.loadUsers();

</script>

<template>
	<div  v-for="(users,index) of useUserStore.users.data" :key="index" class="d-block d-sm-flex align-items-center py-4 border-bottom"><a class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto" href="" style="width: 12.5rem;"><img class="rounded-3" src="img/marketplace/products/th08.jpg" alt="Product"></a>
                  <div class="text-center text-sm-start">
                    <h3 class="h6 product-title mb-2">{{ userStore.users.name }}</h3>
                    <div class="d-inline-block text-accent">{{ userStore.users.email }}</div>
                    <div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">Type: <span class="fw-medium">{{ userStore.user.type }}</span></div>
                    <div class="d-flex justify-content-center justify-content-sm-start pt-3">
                      <button class="btn bg-faded-info btn-icon me-2" type="button" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit"><i class="bi bi-pencil-square"></i></button>
                      <button class="btn bg-faded-danger btn-icon" type="button" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete"><i class="bi bi-trash"></i></button>
                    </div>
                  </div>
                </div>
</template>