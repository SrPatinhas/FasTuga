<script setup>
  import SettingsBar from "../components/navigation/SettingsBar.vue"
  import SettingsUsers from "../components/users/UserItem.vue"
</script>

<template>
   <div class="container mb-5 pb-3">
        <div class="bg-light shadow-lg rounded-3 overflow-hidden">
          <div class="row">
            <!-- Sidebar-->
            <SettingsBar></SettingsBar>
            <!-- Content-->
            <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
              <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
                <h2 class="h3 py-2 text-center text-sm-start">Purchases</h2>
                <!-- Tabs-->
                <div class="table-responsive fs-md mb-4">
              <SettingsUsers></SettingsUsers>
                </div>
              </div>
            </section>
          </div>
        </div>
   </div>
</template>