@extends('admin.layouts.index')

@section('content')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="{{ asset('public/js/dashboard.js') }}" type="text/javascript"></script>
<!-- Breadcrumbs -->
<div class="container-fluid">
    <div class="breadcrumb">
        Ekadi Dashboard
    </div>

    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-book"></i>
                    </div>
                    <div class="mr-5">{{ $postSize }} Posts</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('posts.index') }}">
                    <span class="float-left">View Details</span>
                    <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-file-image"></i>
                    </div>
                    <div class="mr-5">{{ $slideshowSize }} SlideShow</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('slideshow.index') }}">
                    <span class="float-left">View Details</span>
                    <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-file"></i>
                    </div>
                    <div class="mr-5">{{ $browsureSize }} Brochure</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('manageBrowsure.index') }}">
                    <span class="float-left">View Details</span>
                    <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-image"></i>
                    </div>
                    <div class="mr-5">{{ $gallerySize }} Gallery</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('manageGallery.index') }}">
                    <span class="float-left">View Details</span>
                    <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>

    <div class="card mb-3 mt-1">
        <div class="card-header">
            <i class="fas fa-chart-header"></i>
            Last 7 Days (Ekadi Analytics)
        </div>

      <div class="card-body">
          <div id="linechart"></div>
      </div>
    </div>
    <!-- <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-chart-header"></i>
            Posted Chart
        </div>

        <div class="card-body">
            <div id="columnchart_material"></div>
        </div>

        <div class="card-footer">
              <span style="float: right;">{{ date('d-M-y') }}</span>
        </div>
    </div> -->

    <!-- <div class="table-responsive mt-3">
        <table class="table table-bordered" id="dtReport">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Log Date Time</th>
                </tr>
            </thead>
        </table>
    </div> -->
</div>

<!-- end of container-fluid -->

@endsection
