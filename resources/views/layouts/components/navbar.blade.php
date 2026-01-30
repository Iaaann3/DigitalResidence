<header class="topbar">
        <div class="with-vertical"><!-- ---------------------------------- -->
          <!-- Start Vertical Layout Header -->
          <!-- ---------------------------------- -->
        <nav class="navbar navbar-expand-lg  p-2">
    <div class="container-fluid">

   <!-- Tombol toggle sidebar desktop -->
        <li class="nav-item nav-icon-hover-bg rounded-circle ms-n2 list-unstyled">
          <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
              <i class="ti ti-menu-2"></i>
          </a>
        </li>

        

        {{-- Toggler mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="ti ti-dots fs-7"></i>
        </button>

        {{-- Navbar content --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="d-flex align-items-center w-100 justify-content-between">

                {{-- Form Pencarian --}}
                <form class="d-flex align-items-center me-auto">
                    <h5 class="mb-0 text-uppercase fw-bold text-primary">
                        Digital
                        <span class="fw-normal text-muted">Residence</span>
                    </h5>
                </form>
                {{-- Navbar kanan --}}
                <ul class="navbar-nav flex-row align-items-center">

                    {{-- Dark/Light Mode --}}
                    <li class="nav-item me-2">
                        <a class="nav-link moon dark-layout" href="javascript:void(0)">
                            <i class="ti ti-moon"></i>
                        </a>
                        <a class="nav-link sun light-layout" href="javascript:void(0)">
                            <i class="ti ti-sun"></i>
                        </a>
                    </li>

                    {{-- Notifications --}}
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link position-relative" href="javascript:void(0)" id="notifDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-bell-ringing"></i>
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-primary border border-light rounded-circle"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown" style="min-width:300px;">
                            <li class="dropdown-header">Notifications</li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)">
                                    <img src="{{ asset('assets/images/profile/user-2.jpg') }}" class="rounded-circle me-2" width="40" height="40">
                                    <div>
                                        <div class="fw-bold">Roman Joined the Team!</div>
                                        <small>Congratulate him</small>
                                    </div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-center" href="javascript:void(0)">See All Notifications</a>
                            </li>
                        </ul>
                    </li>

                    {{-- Profile --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link d-flex align-items-center" href="javascript:void(0)" id="profileDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="35" height="35" alt="User">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown" style="min-width:250px;">
                            <li class="px-3 py-2">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle me-2" width="50" height="50">
                                    <div>
                                        <div class="fw-bold">Mathew Anderson</div>
                                        <small>Designer</small>
                                        <p class="mb-0"><i class="ti ti-mail"></i> info@modernize.com</p>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            
                            <li class="nav-item">
                                <!-- Form Logout -->
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </li>
                            </ul>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>


          <!-- ---------------------------------- -->
          <!-- End Vertical Layout Header -->
          <!-- ---------------------------------- -->

          <!-- ------------------------------- -->
          <!-- apps Dropdown in Small screen -->
          <!-- ------------------------------- -->
          <!--  Mobilenavbar -->
          <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="mobilenavbar" aria-labelledby="offcanvasWithBothOptionsLabel">
            <nav class="sidebar-nav scroll-sidebar">
              <div class="offcanvas-header justify-content-between">
                <img src="{{ asset('assets/images/logos/favicon.ico') }}" alt="modernize-img" class="img-fluid" />
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body h-n80" data-simplebar="" data-simplebar>
                <ul id="sidebarnav">
                  <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                      <span>
                        <i class="ti ti-apps"></i>
                      </span>
                      <span class="hide-menu">Apps</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level my-3">
                      <li class="sidebar-item py-2">
                        <a href="{{ asset('main/app-chat.html') }}" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/images/svgs/icon-dd-chat.svg') }}" alt="modernize-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div>
                            <h6 class="mb-1 bg-hover-primary">Chat Application</h6>
                            <span class="fs-2 d-block text-muted">New messages arrived</span>
                          </div>
                        </a>
                      </li>
                      <li class="sidebar-item py-2">
                        <a href="{{ asset('main/app-invoice.html') }}" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/images/svgs/icon-dd-invoice.svg') }}" alt="modernize-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div>
                            <h6 class="mb-1 bg-hover-primary">Invoice App</h6>
                            <span class="fs-2 d-block text-muted">Get latest invoice</span>
                          </div>
                        </a>
                      </li>
                      <li class="sidebar-item py-2">
                        <a href="{{ asset('main/app-cotact.html') }}" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/images/svgs/icon-dd-mobile.svg') }}" alt="modernize-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div>
                            <h6 class="mb-1 bg-hover-primary">Contact Application</h6>
                            <span class="fs-2 d-block text-muted">2 Unsaved Contacts</span>
                          </div>
                        </a>
                      </li>
                      <li class="sidebar-item py-2">
                        <a href="{{ asset('main/app-email.html') }}" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/images/svgs/icon-dd-message-box.svg') }}" alt="modernize-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div>
                            <h6 class="mb-1 bg-hover-primary">Email App</h6>
                            <span class="fs-2 d-block text-muted">Get new emails</span>
                          </div>
                        </a>
                      </li>
                      <li class="sidebar-item py-2">
                        <a href="{{ asset('main/page-user-profile.html') }}" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/images/svgs/icon-dd-cart.svg') }}" alt="modernize-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div>
                            <h6 class="mb-1 bg-hover-primary">User Profile</h6>
                            <span class="fs-2 d-block text-muted">learn more information</span>
                          </div>
                        </a>
                      </li>
                      <li class="sidebar-item py-2">
                        <a href="{{ asset('main/app-calendar.html') }}" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/images/svgs/icon-dd-date.svg') }}" alt="modernize-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div>
                            <h6 class="mb-1 bg-hover-primary">Calendar App</h6>
                            <span class="fs-2 d-block text-muted">Get dates</span>
                          </div>
                        </a>
                      </li>
                      <li class="sidebar-item py-2">
                        <a href="{{ asset('main/app-contact2.html') }}" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/images/svgs/icon-dd-lifebuoy.svg') }}" alt="modernize-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div>
                            <h6 class="mb-1 bg-hover-primary">Contact List Table</h6>
                            <span class="fs-2 d-block text-muted">Add new contact</span>
                          </div>
                        </a>
                      </li>
                      <li class="sidebar-item py-2">
                        <a href="{{ asset('main/app-notes.html') }}" class="d-flex align-items-center">
                          <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/images/svgs/icon-dd-application.svg') }}" alt="modernize-img" class="img-fluid" width="24" height="24" />
                          </div>
                          <div>
                            <h6 class="mb-1 bg-hover-primary">Notes Application</h6>
                            <span class="fs-2 d-block text-muted">To-do and Daily tasks</span>
                          </div>
                        </a>
                      </li>
                      <ul class="px-8 mt-7 mb-4">
                        <li class="sidebar-item mb-3">
                          <h5 class="fs-5 fw-semibold">Quick Links</h5>
                        </li>
                        <li class="sidebar-item py-2">
                          <a class="fw-semibold text-dark" href="{{ asset('main/page-pricing.html') }}">Pricing Page</a>
                        </li>
                        <li class="sidebar-item py-2">
                          <a class="fw-semibold text-dark" href="{{ asset('main/authentication-login.html') }}">Authentication
                            Design</a>
                        </li>
                        <li class="sidebar-item py-2">
                          <a class="fw-semibold text-dark" href="{{ asset('main/authentication-register.html') }}">Register Now</a>
                        </li>
                        <li class="sidebar-item py-2">
                          <a class="fw-semibold text-dark" href="{{ asset('main/authentication-error.html') }}">404 Error Page</a>
                        </li>
                        <li class="sidebar-item py-2">
                          <a class="fw-semibold text-dark" href="{{ asset('main/app-notes.html') }}">Notes App</a>
                        </li>
                        <li class="sidebar-item py-2">
                          <a class="fw-semibold text-dark" href="{{ asset('main/page-user-profile.html') }}">User Application</a>
                        </li>
                        <li class="sidebar-item py-2">
                          <a class="fw-semibold text-dark" href="{{ asset('main/page-account-settings.html') }}">Account Settings</a>
                        </li>
                      </ul>
                    </ul>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="./main/app-chat.html" aria-expanded="false">
                      <span>
                        <i class="ti ti-message-dots"></i>
                      </span>
                      <span class="hide-menu">Chat</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="./main/app-calendar.html" aria-expanded="false">
                      <span>
                        <i class="ti ti-calendar"></i>
                      </span>
                      <span class="hide-menu">Calendar</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="./main/app-email.html" aria-expanded="false">
                      <span>
                        <i class="ti ti-mail"></i>
                      </span>
                      <span class="hide-menu">Email</span>
                    </a>
                  </li>
                </ul>
              </div>
            </nav>
          </div>
        </div>
        <div class="app-header with-horizontal">
          <nav class="navbar navbar-expand-xl container-fluid p-0">
            <ul class="navbar-nav align-items-center">
              <li class="nav-item nav-icon-hover-bg rounded-circle d-flex d-xl-none ms-n2">
                <a class="nav-link sidebartoggler" id="sidebarCollapse" href="javascript:void(0)">
                  <i class="ti ti-menu-2"></i>
                </a>
              </li>
              <li class="nav-item d-none d-xl-block">
                <a href="./main/index.html" class="text-nowrap nav-link">
                  <img src="{{ asset('/assets/images/logos/dark-logo.svg') }}" class="dark-logo" width="180" alt="modernize-img" />
                  <img src="./assets/images/logos/light-logo.svg" class="light-logo" width="180" alt="modernize-img" />
                </a>
              </li>
              <li class="nav-item nav-icon-hover-bg rounded-circle d-none d-xl-flex">
                <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  <i class="ti ti-search"></i>
                </a>
              </li>
            </ul>
            <ul class="navbar-nav quick-links d-none d-xl-flex align-items-center">
              <!-- ------------------------------- -->
              <!-- start apps Dropdown -->
              <!-- ------------------------------- -->
              <li class="nav-item nav-icon-hover-bg rounded w-auto dropdown d-none d-lg-flex">
                <div class="hover-dd">
                  <a class="nav-link" href="javascript:void(0)">
                    Apps<span class="mt-1">
                      <i class="ti ti-chevron-down fs-3"></i>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-nav dropdown-menu-animate-up py-0">
                    <div class="row">
                      <div class="col-8">
                        <div class="ps-7 pt-7">
                          <div class="border-bottom">
                            <div class="row">
                              <div class="col-6">
                                <div class="position-relative">
                                  <a href="./main/app-chat.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-chat.svg" alt="modernize-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div>
                                      <h6 class="mb-1 fw-semibold fs-3">
                                        Chat Application
                                      </h6>
                                      <span class="fs-2 d-block text-body-secondary">New messages arrived</span>
                                    </div>
                                  </a>
                                  <a href="./main/app-invoice.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-invoice.svg" alt="modernize-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div>
                                      <h6 class="mb-1 fw-semibold fs-3">Invoice App</h6>
                                      <span class="fs-2 d-block text-body-secondary">Get latest invoice</span>
                                    </div>
                                  </a>
                                  <a href="./main/app-contact2.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-mobile.svg" alt="modernize-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div>
                                      <h6 class="mb-1 fw-semibold fs-3">
                                        Contact Application
                                      </h6>
                                      <span class="fs-2 d-block text-body-secondary">2 Unsaved Contacts</span>
                                    </div>
                                  </a>
                                  <a href="./main/app-email.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-message-box.svg" alt="modernize-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div>
                                      <h6 class="mb-1 fw-semibold fs-3">Email App</h6>
                                      <span class="fs-2 d-block text-body-secondary">Get new emails</span>
                                    </div>
                                  </a>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="position-relative">
                                  <a href="./main/page-user-profile.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-cart.svg" alt="modernize-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div>
                                      <h6 class="mb-1 fw-semibold fs-3">
                                        User Profile 
                                      </h6>
                                      <span class="fs-2 d-block text-body-secondary">learn more information</span>
                                    </div>
                                  </a>
                                  <a href="./main/app-calendar.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-date.svg" alt="modernize-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div>
                                      <h6 class="mb-1 fw-semibold fs-3">
                                        Calendar App
                                      </h6>
                                      <span class="fs-2 d-block text-body-secondary">Get dates</span>
                                    </div>
                                  </a>
                                  <a href="./main/app-contact.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-lifebuoy.svg" alt="modernize-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div>
                                      <h6 class="mb-1 fw-semibold fs-3">
                                        Contact List Table
                                      </h6>
                                      <span class="fs-2 d-block text-body-secondary">Add new contact</span>
                                    </div>
                                  </a>
                                  <a href="./main/app-notes.html" class="d-flex align-items-center pb-9 position-relative">
                                    <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                      <img src="./assets/images/svgs/icon-dd-application.svg" alt="modernize-img" class="img-fluid" width="24" height="24" />
                                    </div>
                                    <div>
                                      <h6 class="mb-1 fw-semibold fs-3">
                                        Notes Application
                                      </h6>
                                      <span class="fs-2 d-block text-body-secondary">To-do and Daily tasks</span>
                                    </div>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row align-items-center py-3">
                            <div class="col-8">
                              <a class="fw-semibold d-flex align-items-center lh-1" href="javascript:void(0)">
                                <i class="ti ti-help fs-6 me-2"></i>Frequently Asked Questions
                              </a>
                            </div>
                            <div class="col-4">
                              <div class="d-flex justify-content-end pe-4">
                                <button class="btn btn-primary">Check</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-4 ms-n4">
                        <div class="position-relative p-7 border-start h-100">
                          <h5 class="fs-5 mb-9 fw-semibold">Quick Links</h5>
                          <ul class="">
                            <li class="mb-3">
                              <a class="fw-semibold bg-hover-primary" href="./main/page-pricing.html">Pricing Page</a>
                            </li>
                            <li class="mb-3">
                              <a class="fw-semibold bg-hover-primary" href="./main/authentication-login.html">Authentication
                                Design</a>
                            </li>
                            <li class="mb-3">
                              <a class="fw-semibold bg-hover-primary" href="./main/authentication-register.html">Register Now</a>
                            </li>
                            <li class="mb-3">
                              <a class="fw-semibold bg-hover-primary" href="./main/authentication-error.html">404 Error Page</a>
                            </li>
                            <li class="mb-3">
                              <a class="fw-semibold bg-hover-primary" href="./main/app-notes.html">Notes App</a>
                            </li>
                            <li class="mb-3">
                              <a class="fw-semibold bg-hover-primary" href="./main/page-user-profile.html">User Application</a>
                            </li>
                            <li class="mb-3">
                              <a class="fw-semibold bg-hover-primary" href="./main/page-account-settings.html">Account Settings</a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <!-- ------------------------------- -->
              <!-- end apps Dropdown -->
              <!-- ------------------------------- -->
              <li class="nav-item dropdown-hover d-none d-lg-block">
                <a class="nav-link" href="{{ asset('main/app-chat.html') }}">Chat</a>
              </li>
              <li class="nav-item dropdown-hover d-none d-lg-block">
                <a class="nav-link" href="{{ asset('main/app-calendar.html') }}">Calendar</a>
              </li>
              <li class="nav-item dropdown-hover d-none d-lg-block">
                <a class="nav-link" href="{{ asset('main/app-email.html') }}">Email</a>
              </li>
            </ul>
            <div class="d-block d-xl-none">
              <a href="{{ asset('main/index.html') }}" class="text-nowrap nav-link">
                <img src="{{ asset('assets/images/logos/dark-logo.svg') }}" width="180" alt="modernize-img" />
              </a>
            </div>
            <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="p-2">
                <i class="ti ti-dots fs-7"></i>
              </span>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
              <div class="d-flex align-items-center justify-content-between px-0 px-xl-8">
                <a href="javascript:void(0)" class="nav-link round-40 p-1 ps-0 d-flex d-xl-none align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar" aria-controls="offcanvasWithBothOptions">
                  <i class="ti ti-align-justified fs-7"></i>
                </a>
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                  <!-- ------------------------------- -->
                  <!-- start language Dropdown -->
                  <!-- ------------------------------- -->
                  <li class="nav-item nav-icon-hover-bg rounded-circle">
                    <a class="nav-link moon dark-layout" href="javascript:void(0)">
                      <i class="ti ti-moon moon"></i>
                    </a>
                    <a class="nav-link sun light-layout" href="javascript:void(0)">
                      <i class="ti ti-sun sun"></i>
                    </a>
                  </li>
                  <!-- ------------------------------- -->
                  <!-- end language Dropdown -->
                  <!-- ------------------------------- -->

                  <!-- ------------------------------- -->
                  <!-- start shopping cart Dropdown -->
                  <!-- ------------------------------- -->
                  <!-- ------------------------------- -->
                  <!-- end shopping cart Dropdown -->
                  <!-- ------------------------------- -->

                  <!-- ------------------------------- -->
                  <!-- start notification Dropdown -->
                  <!-- ------------------------------- -->

                  <!-- ------------------------------- -->
                  <!-- end notification Dropdown -->
                  <!-- ------------------------------- -->

                  <!-- ------------------------------- -->
                  <!-- start profile Dropdown -->
                  <!-- ------------------------------- -->
                  <li class="nav-item dropdown">
                    <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" aria-expanded="false">
                      <div class="d-flex align-items-center">
                        <div class="user-profile-img">
                          <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="35" height="35" alt="modernize-img" />
                        </div>
                      </div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                      <div class="profile-dropdown position-relative" data-simplebar>
                        <div class="py-3 px-7 pb-0">
                          <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                        </div>
                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                          <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="80" height="80" alt="modernize-img" />
                          <div class="ms-3">
                            <h5 class="mb-1 fs-3">Mathew Anderson</h5>
                            <span class="mb-1 d-block">Designer</span>
                            <p class="mb-0 d-flex align-items-center gap-2">
                              <i class="ti ti-mail fs-4"></i> info@modernize.com
                            </p>
                          </div>
                        </div>
                        <div class="message-body">
                          <a href="{{ asset('main/page-user-profile.html') }}" class="py-8 px-7 mt-8 d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                              <img src="{{ asset('assets/images/svgs/icon-account.svg') }}" alt="modernize-img" width="24" height="24" />
                            </span>
                            <div class="w-100 ps-3">
                              <h6 class="mb-1 fs-3 fw-semibold lh-base">My Profile</h6>
                              <span class="fs-2 d-block text-body-secondary">Account Settings</span>
                            </div>
                          </a>
                          <a href="{{ asset('main/app-email.html') }}" class="py-8 px-7 d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                              <img src="{{ asset('assets/images/svgs/icon-inbox.svg') }}" alt="modernize-img" width="24" height="24" />
                            </span>
                            <div class="w-100 ps-3">
                              <h6 class="mb-1 fs-3 fw-semibold lh-base">My Inbox</h6>
                              <span class="fs-2 d-block text-body-secondary">Messages & Emails</span>
                            </div>
                          </a>
                          <a href="{{ asset('main/app-notes.html') }}" class="py-8 px-7 d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                              <img src="{{ asset('assets/images/svgs/icon-tasks.svg') }}" alt="modernize-img" width="24" height="24" />
                            </span>
                            <div class="w-100 ps-3">
                              <h6 class="mb-1 fs-3 fw-semibold lh-base">My Task</h6>
                              <span class="fs-2 d-block text-body-secondary">To-do and Daily Tasks</span>
                            </div>
                          </a>
                        </div>
                        <div class="d-grid py-4 px-7 pt-8">
                          <div class="upgrade-plan bg-primary-subtle position-relative overflow-hidden rounded-4 p-4 mb-9">
                            <div class="row">
                              <div class="col-6">
                                <h5 class="fs-4 mb-3 fw-semibold">Unlimited Access</h5>
                                <button class="btn btn-primary">Upgrade</button>
                              </div>
                              <div class="col-6">
                                <div class="m-n4 unlimited-img">
                                  <img src="{{ asset('assets/images/backgrounds/unlimited-bg.png') }}" alt="modernize-img" class="w-100" />
                                </div>
                              </div>
                            </div>
                          </div>
                          <a href="{{ asset('main/authentication-login.html') }}" class="btn btn-outline-primary">Log Out</a>
                        </div>
                      </div>
                    </div>
                  </li>
                  <!-- ------------------------------- -->
                  <!-- end profile Dropdown -->
                  <!-- ------------------------------- -->
                </ul>
              </div>
            </div>
          </nav>
        </div>
      </header>
