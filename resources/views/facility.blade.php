@extends('layouts.index')

@section('content')
    @if($listOfFacility->count() == 0)
      <div class="maintanance" style="height: 100vh; text-align: center; font-size: 84px; color: #FFFFFF;
                font-family: 'fantasy'; padding: 250px 0;
                background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url(public/img/images/test.jpg);background-size: cover;
    background-position: center;">
          Coming Soon
      </div>
      @else
        @foreach($listOfFacility as $facility)
            <div class="jumbotron">
              <h1 class="display-4">Hello, world!</h1>
              <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
              <hr class="my-4">
              <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
              <p class="lead">
                <a class="btn btn-primary btn-lg" href="#" role="button">View</a>
              </p>
            </div>
        @endforeach
    @endif

@endsection
