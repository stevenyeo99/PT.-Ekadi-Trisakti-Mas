@extends('layouts.index')

@section('content')
<script src="{{ asset('public/vendor/slippry/dist/slippry.min.js') }}"></script>
<script src="//use.edgefonts.net/cabin;source-sans-pro:n2,i2,n3,n4,n6,n7,n9.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/home.css') }}">
<script type="text/javascript" src="{{ asset('public/js/home.js') }}"></script>
<link href="{{ asset('public/vendor/slippry/dist/slippry.css') }}" rel="stylesheet" type="text/css">

<section class="slide_wrapper">
    <article class="slide_block">
        <ul id="ekadiSlideShow">
            @foreach($listOfSlideShow as $slideshow)
                <li>
                  <a>
                      <img class="imgSldEkadi" src="public/{{ $slideshow->original_path }}" alt="{{ $slideshow->alt }}" style="width: 100%; cursor: context-menu;">
                  </a>
                </li>
            @endforeach
        </ul>
    </article>
</section>
    @foreach($categories as $cat)
          @if($cat->type == 'ABOUT US')
            <div class="jumbotron mt-3">
              <h1 class="display-4">About Us</h1>
              <p class="lead">Wanna Know More About Our Company Background?</p>
              <hr class="my-4">
              <p class="lead">
                <a class="btn btn-primary btn-lg" href="{{ route('about') }}" role="button">Read More</a>
              </p>
            </div>
          @endif

          @if($cat->type == 'MAINTANANCE')
            <div class="jumbotron mt-3">
              <h1 class="display-4">Our Facility</h1>
              <p class="lead">Lets Read More About Facility That We Serve.</p>
              <hr class="my-4">
              <p class="lead">
                <a class="btn btn-primary btn-lg" href="{{ route('maintanance') }}" role="button">Read More</a>
              </p>
            </div>
          @endif

          @if($postListing->count() > 0)
              @if($cat->type == 'LISTING')
                  <div class="jumbotron mt-3">
                      <h1 class="display-4">Event & Promo</h1>
                      <p class="lead">Latest Event & Promo</p>
                      <hr class="my-4">
                      <div class="row">
                          @foreach($postListing as $listing)
                            <div class="col span-1-of-2 box">
                                {{ $listing->catTitle }} ({{ $listing->post_title }})
                                <br>
                                <a href="{{ url('/ViewContent').'/LISTING/'.$listing->id }}" role="button" class="btn btn-primary btn-lg">
                                    View
                                </a>
                            </div>
                          @endforeach
                      </div>
                  </div>
              @endif
          @endif

          @if($postSubListing->count() > 0)
              @if($cat->type == 'LISTING SUB')
                  <div class="jumbotron" style="margin-top: 30px;">
                    <h1 class="display-4">Master Plan</h1>
                    <p class="lead">
                        Latest Master Plan Product
                    </p>
                    <hr class="my-4">
                    <div class="row">
                      @foreach($postSubListing as $sub)
                        <div class="col span-1-of-2 box">
                            {{ $sub->subTitle }} - {{ $sub->post_title }}
                            <br>
                            <a href="{{ url('/ViewContent').'/SUB LISTING/'.$sub->id }}" role="button" class="btn btn-primary btn-lg">View</a>
                        </div>
                      @endforeach
                    </div>
                  </div>
              @endif
          @endif
    @endforeach
@endsection
