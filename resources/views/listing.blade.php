@extends('layouts.index')

@section('content')
  @php $i = 1; @endphp
  @if($postListing->count() != 0)
      @foreach($postListing as $post)
            <div class="jumbotron" @if($i == 1) style="margin-top: 80px;" @endif>
                <h1 class="display-4">{{ $post->post_title}}</h1>
                <!-- <p class="lead">Latest Event & Promo</p> -->
                <hr class="my-4">
                <p class="lead">
                  <a class="btn btn-primary btn-lg" href="{{ url('/ViewContent').'/'.$tab.'/'.$post->id }}" role="button">View</a>
                </p>
            </div>
            @php $i++; @endphp
      @endforeach

  {{ $postListing->links() }}
    @else
    <div class="maintanance" style="height: 100vh; text-align: center; font-size: 84px; color: #FFFFFF;
              font-family: 'fantasy'; padding: 250px 0;
              background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url(../../public/img/images/test.jpg);background-size: cover;
  background-position: center;">
        Coming Soon
    </div>
  @endif
@endsection
