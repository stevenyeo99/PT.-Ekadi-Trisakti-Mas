@extends('layouts.index')

@section('content')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<div class="container" style="margin-top: 80px; margin-bottom: 50px;">
    <h1 style="text-align: center;">{!! $post->post_title !!}</h1>
    <hr>
    <div class="row">
        <div class="row">
            @foreach($gallery as $image)
                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                    <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="{{ $image->alt }}"
                        data-image="{{ asset('public').'/'.$image->thumbnail_path }}"
                        data-target="#image-gallery">
                            <img class="img-thumbnail"
                                 src="{{ asset('public').'/'.$image->thumbnail_path }}"
                                 alt="{{ $image->alt }}">
                    </a>
                </div>
            @endforeach
        </div>

        <div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="image-gallery-title"></h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <img id="image-gallery-image" class="img-responsive col-md-12" src="">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn float-left" id="show-previous-image">
                            <i class="fa fa-arrow-left"></i>
                        </button>

                        <button type="button" id="show-next-image" class="btn float-right">
                            <i class="fa fa-arrow-right"></i>
                        </button>

                        <style>
                          #show-previous-image,
                          #show-next-image {
                            background-color: #5cb85c;
                            color: white;
                          }

                          .btn:focus, .btn:active, button:focus, button:active {
                            outline: none !important;
                            box-shadow: none !important;
                          }

                          #image-gallery .modal-footer{
                            display: block;
                          }

                          .thumb{
                            margin-top: 15px;
                            margin-bottom: 15px;
                          }
                        </style>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! $post->body !!}

    @if($countBrowsure == 1)
        Interested You Can View This Product Browsure
        <a class="btn btn-primary" onclick="openPopUpNewWindows('{{ url('/ViewBrowsure').'/'.$post->id }}', 'viewBrowsure');">View Brochure</a>
    @endif
</div>
@endsection
