<script setup>
  import SettingsBar from "../navigation/SettingsBar.vue"
  import SettingsOrderTable from "../order/orderSettingsTable.vue"

</script>

<template>
            <!-- Content-->
            <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
              <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
                <h2 class="h3 py-2 text-center text-sm-start">Actual Orders</h2>
                <!-- Tabs-->
                <div class="table-responsive fs-md mb-4">
                  <SettingsOrderTable></SettingsOrderTable>
            </div>
              </div>
            </section>
</template>