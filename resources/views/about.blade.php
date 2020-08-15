@extends('layouts.index')

@section('content')
<div class="container">
  @foreach($listOfAbouts as $about)

      <h1 style="text-align: center;">{{ $about->post_title }}</h1>
        {!! $about->body !!}
  @endforeach

  <h1 style="text-align: center;">Our location</h1>
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d144.6331148466561!2d104.00410859531853!3d1.1278337456996157!2m3!1f319.04999999999995!2f0!3f0!3m2!1i1024!2i768!4f35!3m3!1m2!1s0x31d98bf3177bbfed%3A0xf71602d579becc34!2sPT.+Ekadi+Trisakti+Mas!5e1!3m2!1sen!2sid!4v1556527865106!5m2!1sen!2sid" width="100%" height="450" frameborder="0" style="border:0; margin-bottom: 1rem;" allowfullscreen></iframe>


  <h1 style="text-align: center;">Our Products</h1>
  <div class="row mt-1 mb-3">
      <div class="col span-1-of-2 box">
          <img src="{{asset('public/img/images/1.jpg')}}" style="width: 100%; height: 100px;">
      </div>

      <div class="col span-1-of-2 box">
        <img src="{{asset('public/img/images/2.png')}}" style="width: 100%; height: 100px;">
      </div>
  </div>
</div>


@endsection
