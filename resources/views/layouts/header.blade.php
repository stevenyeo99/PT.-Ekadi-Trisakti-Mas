<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-141019863-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-141019863-1');
    </script>


    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- include file one -->
    <script src="{{ asset('public/sb-admin-vendor/jquery/jquery.min.js') }}"></script>
    <title>PT. Ekadi Trisakti Mas</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/navigationWebPageNew.css') }}">
    <script type="text/javascript" src="{{ asset('public/js/navigationWebPageNew.js') }}"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/js/mdb.min.js"></script>
    <style>
      html, body {
        margin: 0;
        display: table;
        /* padding: 0; */
        height: 100%;
        width: 100%;
      }

      ul.pagination {
        float: right;
      }
    </style>
  </head>
<body>
    <header style="top: 0;">
        <div class="logo">PT. Ekadi Trisakti Mas</div>
        <nav>
            <ul>
                @foreach($categories as $category)
                    @php $count = 0; @endphp
                    @php $arraySubCategory = []; $arraySubId = []; @endphp
                    @foreach($subCategories as $subCategory)
                        @if($subCategory->category_id == $category->id)
                            @php
                                $count++;
                                array_push($arraySubCategory, $subCategory->title);
                                array_push($arraySubId, $subCategory->id);
                            @endphp
                        @endif
                    @endforeach
                    <li
                      @if($count > 0)
                        class="sub-menu"
                      @endif>
                      @if($count > 0)
                        <a href="#sublisting">{{ $category->title }}</a>
                        @else
                        <a class="@if($tab == $category->type) active @endif" href="@if($category->type == 'FIRST PAGE')
                          {{ route('firstpage')}}
                          @elseif($category->type == 'ABOUT US')
                            {{route('about')}}
                          @elseif($category->type == 'MAINTANANCE')
                            {{route('maintanance')}}
                          @elseif($category->type == 'LISTING')
                            {{url('/listing/'.$category->id)}}
                        @endif">{{ $category->title }}</a>
                      @endif
                        <ul>
                            @if($count > 0)
                              @for($i = 0; $i < $count; $i++)
                                  <li><a href="{{url('/sublisting/'.$arraySubId[$i])}}"
                                    class="@if(isset($subcategoryId) &&  $subcategoryId == $arraySubId[$i])
                                      active
                                    @endif"
                                    @if(isset($subcategoryId) &&  $subcategoryId == $arraySubId[$i])
                                      data-selected="yes"
                                    @endif
                                    >
                                    {{ $arraySubCategory[$i] }}
                                  </a></li>
                              @endfor
                            @endif
                        </ul>
                    </li>
                @endforeach
            </ul>
        </nav>
        <div class="menu-toggle">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </div>
    </header>
