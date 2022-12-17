<script setup>
  import SettingsBar from "../components/navigation/SettingsBar.vue"

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
                <h2 class="h3 py-2 text-center text-sm-start">Dashboard </h2>
                <!-- Tabs-->
                <div class="bg-secondary h-100 rounded-3 p-4 text-center">
                      <h3 class="fs-sm text-muted">Total Menus</h3>
                      <p class="h2 mb-2">6</p>
                    </div>
                    <div class="bg-secondary h-100 rounded-3 p-4 text-center">
                      <h3 class="fs-sm text-muted">Total de vendas - Hoje</h3>
                      <p class="h2 mb-2">4</p>
                    </div>  
                    <div class="bg-secondary h-100 rounded-3 p-4 text-center">
                      <h3 class="fs-sm text-muted">Total de Clientes com conta - Hoje </h3>
                      <p class="h2 mb-2">6</p>
                    </div>  
                    <div class="bg-secondary h-100 rounded-3 p-4 text-center">
                      <h3 class="fs-sm text-muted">Total de Clientes sem conta - Hoje</h3>
                      <p class="h2 mb-2">5</p>
                    </div>  
              </div>
            </section>
          </div>
        </div>
   </div>
</template>