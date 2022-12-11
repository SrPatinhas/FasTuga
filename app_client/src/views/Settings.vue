<script setup>
</script>

<template>
   <div class="container mb-5 pb-3">
        <div class="bg-light shadow-lg rounded-3 overflow-hidden">
          <div class="row">
            <!-- Sidebar-->
            <aside class="col-lg-4 pe-xl-5">
              <!-- Account menu toggler (hidden on screens larger 992px)-->
              <div class="d-block d-lg-none p-4"><a class="btn btn-outline-accent d-block" href="#account-menu" data-bs-toggle="collapse"><i class="ci-menu me-2"></i>Account menu</a></div>
              <!-- Actual menu-->
              <div class="h-100 border-end mb-2">
                <div class="d-lg-block collapse" id="account-menu">
                  <div class="bg-secondary p-4">
                    <h3 class="fs-sm mb-0 text-muted">Account</h3>
                  </div>
                  <ul class="list-unstyled mb-0">
                    <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 active" href="dashboard-settings.html"><i class="ci-settings opacity-60 me-2"></i>Settings</a></li>
                  </ul>
                  <div class="bg-secondary p-4">
                    <h3 class="fs-sm mb-0 text-muted">Orders</h3>
                  </div>
                  <ul class="list-unstyled mb-0">
                    <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="dashboard-sales.html"><i class="ci-dollar opacity-60 me-2"></i>Purchase history<span class="fs-sm text-muted ms-auto"></span></a></li>
                  </ul>
                  <div class="bg-secondary p-4">
                    <h3 class="fs-sm mb-0 text-muted">Security</h3>
                  </div>
                  <ul class="list-unstyled mb-0">
                    <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="dashboard-sales.html"><i class="ci-dollar opacity-60 me-2"></i>Change Password<span class="fs-sm text-muted ms-auto"></span></a></li>
                    <li class="mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="account-signin.html"><i class="ci-sign-out opacity-60 me-2"></i>Sign out</a></li>
                  </ul>
                  <hr>
                </div>
              </div>
            </aside>
            <!-- Content-->
            <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
              <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
                <h2 class="h3 py-2 text-center text-sm-start">Settings</h2>
                <!-- Tabs-->
                <ul class="nav nav-tabs nav-justified" role="tablist">
                  <li class="nav-item" role="presentation"><a class="nav-link px-0 active" href="#profile" data-bs-toggle="tab" role="tab" aria-selected="true">
                      <div class="d-none d-lg-block"><i class="ci-user opacity-60 me-2"></i>Profile</div>
                      <div class="d-lg-none text-center"><i class="ci-user opacity-60 d-block fs-xl mb-2"></i><span class="fs-ms">Profile</span></div></a></li>
                  <li class="nav-item" role="presentation"><a class="nav-link px-0" href="#notifications" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
                      <div class="d-none d-lg-block"><i class="ci-bell opacity-60 me-2"></i>User information</div>
                      <div class="d-lg-none text-center"><i class="ci-bell opacity-60 d-block fs-xl mb-2"></i><span class="fs-ms">User information</span></div></a></li>
                  <li class="nav-item" role="presentation"><a class="nav-link px-0" href="#payment" data-bs-toggle="tab" role="stab" aria-selected="false" tabindex="-1">
                      <div class="d-none d-lg-block"><i class="ci-card opacity-60 me-2"></i>Payment methods</div>
                      <div class="d-lg-none text-center"><i class="ci-card opacity-60 d-block fs-xl mb-2"></i><span class="fs-ms">Payment</span></div></a></li>
                </ul>
                <!-- Tab content-->
                <div class="tab-content">
                  <!-- Profile-->
                  <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    <div class="bg-secondary rounded-3 p-4 mb-4">
                      <div class="d-flex align-items-center"><img class="rounded" src="img/marketplace/account/avatar.png" width="90" alt="Createx Studio">
                        <div class="ps-3">
                          <button class="btn btn-light btn-shadow btn-sm mb-2" type="button"><i class="ci-loading me-2"></i>Change <span class="d-none d-sm-inline">avatar</span></button>
                          <div class="p mb-0 fs-ms text-muted">Upload JPG, GIF or PNG image. 300 x 300 required.</div>
                        </div>
                      </div>
                    </div>
                    <div class="row gx-4 gy-3">
                      <div class="col-sm-6">
                        <label class="form-label" for="dashboard-fn">First Name</label>
                        <input class="form-control" type="text" id="dashboard-fn" value="John">
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="dashboard-ln">Last Name</label>
                        <input class="form-control" type="text" id="dashboard-ln" value="Doe">
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="dashboard-email">Email address</label>
                        <input class="form-control" type="text" id="dashboard-email" value="contact@example.com" disabled="">
                      </div>
                      <div class="col-12">
                        <hr class="mt-2 mb-4">
                        <div class="d-sm-flex justify-content-between align-items-center">
                          <button class="btn btn-primary mt-3 mt-sm-0" type="button">Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- User information -->
                  <div class="tab-pane fade" id="userinformation" role="tabpanel">
                    <div class="row gx-4 gy-3">
                      <div class="col-sm-6">
                        <label class="form-label" for="dashboard-fn">Phone Number</label>
                        <input class="form-control" type="text" id="dashboard-fn" value="John">
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="dashboard-ln">NIF</label>
                        <input class="form-control" type="text" id="dashboard-ln" value="Doe">
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="dashboard-email">Default payment type</label>
                        <input class="form-control" type="text" id="dashboard-email" value="contact@example.com" disabled="">
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="dashboard-email">Total points owned</label>
                        <input class="form-control" type="text" id="dashboard-email" value="contact@example.com" disabled="">
                      </div>
                      <div class="col-12">
                        <hr class="mt-2 mb-4">
                        <div class="d-sm-flex justify-content-between align-items-center">
                          <button class="btn btn-primary mt-3 mt-sm-0" type="button">Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Payment methods-->
                  <div class="tab-pane fade" id="payment" role="tabpanel">
                    <div class="bg-secondary rounded-3 p-4 mb-4">
                      <p class="fs-sm text-muted mb-0">Primary payment method is used by default</p>
                    </div>
                    <div class="table-responsive fs-md mb-4">
                      <table class="table table-hover mb-0">
                        <thead>
                          <tr>
                            <th>Your credit / debit cards</th>
                            <th>Name on card</th>
                            <th>Expires on</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="py-3 align-middle">
                              <div class="d-flex align-items-center"><img src="img/card-visa.png" width="39" alt="Visa">
                                <div class="ps-2"><span class="fw-medium text-heading me-1">Visa</span>ending in 4999<span class="align-middle badge badge-info ms-2">Primary</span></div>
                              </div>
                            </td>
                            <td class="py-3 align-middle">John doe</td>
                            <td class="py-3 align-middle">08 / 2019</td>
                            <td class="py-3 align-middle"><a class="nav-link-style me-2" href="#" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit"><i class="ci-edit"></i></a><a class="nav-link-style text-danger" href="#" data-bs-toggle="tooltip" aria-label="Remove" data-bs-original-title="Remove">
                                <div class="ci-trash"></div></a></td>
                          </tr>
                          <tr>
                            <td class="py-3 align-middle">
                              <div class="d-flex align-items-center"><img src="img/card-master.png" width="39" alt="MesterCard">
                                <div class="ps-2"><span class="fw-medium text-heading me-1">MasterCard</span>ending in 0015</div>
                              </div>
                            </td>
                            <td class="py-3 align-middle">John doe</td>
                            <td class="py-3 align-middle">11 / 2021</td>
                            <td class="py-3 align-middle"><a class="nav-link-style me-2" href="#" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit"><i class="ci-edit"></i></a><a class="nav-link-style text-danger" href="#" data-bs-toggle="tooltip" aria-label="Remove" data-bs-original-title="Remove">
                                <div class="ci-trash"></div></a></td>
                          </tr>
                          <tr>
                            <td class="py-3 align-middle">
                              <div class="d-flex align-items-center"><img src="img/card-paypal.png" width="39" alt="PayPal">
                                <div class="ps-2"><span class="fw-medium text-heading me-1">PayPal</span>j.doe@example.com</div>
                              </div>
                            </td>
                            <td class="py-3 align-middle">—</td>
                            <td class="py-3 align-middle">—</td>
                            <td class="py-3 align-middle"><a class="nav-link-style me-2" href="#" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit"><i class="ci-edit"></i></a><a class="nav-link-style text-danger" href="#" data-bs-toggle="tooltip" aria-label="Remove" data-bs-original-title="Remove">
                                <div class="ci-trash"></div></a></td>
                          </tr>
                          <tr>
                            <td class="py-3 align-middle">
                              <div class="d-flex align-items-center"><img src="img/card-visa.png" width="39" alt="Visa">
                                <div class="ps-2"><span class="fw-medium text-heading me-1">Visa</span>ending in 6073</div>
                              </div>
                            </td>
                            <td class="py-3 align-middle">John doe</td>
                            <td class="py-3 align-middle">09 / 2021</td>
                            <td class="py-3 align-middle"><a class="nav-link-style me-2" href="#" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit"><i class="ci-edit"></i></a><a class="nav-link-style text-danger" href="#" data-bs-toggle="tooltip" aria-label="Remove" data-bs-original-title="Remove">
                                <div class="ci-trash"></div></a></td>
                          </tr>
                          <tr>
                            <td class="py-3 align-middle">
                              <div class="d-flex align-items-center"><img src="img/card-visa.png" width="39" alt="Visa">
                                <div class="ps-2"><span class="fw-medium text-heading me-1">Visa</span>ending in 9791</div>
                              </div>
                            </td>
                            <td class="py-3 align-middle">John doe</td>
                            <td class="py-3 align-middle">05 / 2021</td>
                            <td class="py-3 align-middle"><a class="nav-link-style me-2" href="#" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit"><i class="ci-edit"></i></a><a class="nav-link-style text-danger" href="#" data-bs-toggle="tooltip" aria-label="Remove" data-bs-original-title="Remove">
                                <div class="ci-trash"></div></a></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="text-sm-end"><a class="btn btn-primary" href="#add-payment" data-bs-toggle="modal">Add payment method</a></div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
</template>
  