<script setup>
  import SettingsUsers from "../users/UserItem.vue"
  import Pagination from "../navigation/Pagination.vue"
</script>

<template>
            <!-- Content-->
            <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
              <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
                <h2 class="h3 py-2 text-center text-sm-start">Users</h2>
                <!-- Tabs-->
                <div class="table-responsive fs-md mb-4">
              <SettingsUsers></SettingsUsers>
                </div>
              </div>
            </section>
            <Pagination></Pagination>
</template>