<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ekadi Admin</title>

    <!-- Custom fonts for this template -->
    <link href="{{ asset('public/sb-admin-vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS -->
    <link href="{{ asset('public/sb-admin-vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- custom styles for this template -->
    <link href="{{ asset('public/sb-admin-vendor/css/sb-admin.css') }}" rel="stylesheet">

    <!-- common.css -->
    <link href="{{ asset('public/css/common.css') }}" rel="stylesheet" type="text/css">

    <!-- include file one -->
    <script src="{{ asset('public/sb-admin-vendor/jquery/jquery.min.js') }}"></script>
    <!-- choosen dropdown cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
</head>
<body id="page-top">
  <nav class="navbar navbar-expand navbar-dark static-top bg-permata-reverview">
      <a class="navbar-brand mr-1" href="">PT. Ekadi Trisakti Mas</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0 mt-1" id="sidebarToggle">
          <i class="fas fa-bars" id="iSideBar"></i>
      </button>

      <div class="input-group">
      </div>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
          <li class="nav-item" style="width: 90px;" style="padding-right:0;">
              <a class="nav-link" href="https://bukitpermata.id/viewsite" target="_blank">
                  View Site
              </a>
          </li>

          <li class="nav-item">
              <a class="nav-link" href="#" id="userDropdown" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-power-off fa-fw"></i>
              </a>
          </li>
      </ul>
  </nav>

  <div id="wrapper">
      <!-- Sidebar -->
      <ul class="sidebar navbar-nav bg-permata-reverview">
          <li class="nav-item @if($tab == 'dashboard')
              active
          @endif">
              <a class="nav-link" href="{{ route('dashboard') }}">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span>Dashboard</span>
              </a>
          </li>

          <li class="nav-item @if($tab == 'category')
              active
          @endif">
            <a class="nav-link" href="{{ route('category.index') }}">
              <i class="fas fa-fw fa-list"></i>
              <span>Category</span>
            </a>
          </li>

          <li class="nav-item @if($tab == 'subcategory')
              active
          @endif">
              <a class="nav-link" href="{{route('subcategory.index')}}">
                  <i class="fas fa-fw fa-clone"></i>
                  <span>Sub-Category</span>
              </a>
          </li>

          <li class="nav-item @if($tab == 'posts')
              active
          @endif">
              <a class="nav-link" href="{{ route('posts.index') }}">
                  <i class="fas fa-fw fa-book"></i>
                  <span>Manage Posts</span>
              </a>
          </li>

          <li class="nav-item @if($tab == 'slideshow')
              active
          @endif">
            <a class="nav-link" href="{{route('slideshow.index')}}">
              <i class="fas fa-fw fa-file-image"></i>
              <span>Slideshows</span>
            </a>
          </li>

          <li class="nav-item @if($tab == 'profile')
              active
          @endif">
            <a class="nav-link" href="{{ route('profile.index') }}">
              <i class="fas fa-fw fa-user"></i>
              <span>Profile</span>
            </a>
          </li>

          @if(Auth::user()->user_role == 1)
            <li class="nav-item @if($tab == 'manageAdmin')
                active
            @endif">
              <a class="nav-link" href="{{ route('manageAdmin.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Manage Admin</span>
              </a>
            </li>
          @endif


          <li class="nav-item @if($tab == 'manageBrowsure') active @endif">
              <a class="nav-link" href="{{ route('manageBrowsure.index') }}">
                <i class="fas fa-fw fa-file"></i>
                <span>Manage Brochure</span>
              </a>
          </li>

          <li class="nav-item @if($tab == 'manageGallery') active @endif">
              <a class="nav-link" href="{{ route('manageGallery.index') }}">
                <i class="fas fa-fw fa-image"></i>
                <span>Product Gallery</span>
              </a>
          </li>
      </ul>

      <div id="content-wrapper">
          @yield('content')
      </div>
      <!-- end content wrapper -->
    </div>
    <!-- end wrappper -->

    <!-- Sticky Footer -->
    <footer class="sticky-footer">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright @ PT. Ekadi Trisakti Mas</span>
            </div>
        </div>
    </footer>

    <!-- Scroll to top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to leave?</h5>
                <button class="close noOutlineX" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">x</span>
                </button>
              </div>
              <div class="modal-body">You Will Redirect To Login Page</div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="btn btn-primary" type="submit">Logout</button>
                </form>
              </div>
            </div>
        </div>
    </div>
</body>
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('public/sb-admin-vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- common.js -->
<script type="text/javascript" src="{{ asset('public/js/common.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('public/sb-admin-vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Page level plugin JavaScript-->
<script src="{{ asset('public/sb-admin-vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('public/sb-admin-vendor/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/sb-admin-vendor/datatables/dataTables.bootstrap4.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('public/sb-admin-vendor/js/sb-admin.min.js') }}"></script>

<!-- Demo scripts for this page-->
<script src="{{ asset('public/sb-admin-vendor/js/demo/datatables-demo.js') }}"></script>
<!-- <script src="{{ asset('sb-admin-vendor/js/demo/chart-area-demo.js') }}"></script> -->
</html>
