@extends('admin.layouts.index')

@section('content')
    <!-- taggle -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/vendor/taggle/css/taggle.css') }}">
    <script src="{{ asset('public/vendor/taggle/js/taggle.min.js') }}"></script>
    <!-- add post category -->
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script type="text/javascript" src="{{ asset('public/js/editPost.js') }}"></script>

    <div class="card-mb-3">
        <div class="card-header">
            <i class="fas fa-fw fa-book"></i>
            Edit Posting
        </div>

        <div class="card-body">
            <div class="col-sm-4 mb-3">
                @if($errors->any())
                  <div class="alert alert-danger" id="alert-crud">
                      <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                  </div>
                  @elseif(session('messageFail'))
                  <div class="alert alert-danger" id="alert-crud">
                      {{ session('messageFail') }}
                  </div>
                @endif
            </div>


            <form id="frmPost" action="{{ url('/ekadi/admin/posts')."/".$posts->id }}" method="POST">
                @csrf
                {{ method_field('PUT') }}
                <input type="hidden" value="{{ $posts->id }}" name="id" readonly>
                <div class="form-group row mb-4" id="titleArea">
                    <label for="title" class="col-md-2 mt-1">Title:</label>
                    <div class="col-md-5">
                        <input type="text" value="{{$posts->post_title}}" class="form-control" id="title" name="post_title" maxlength="20" minlength="3">
                        <small id="titleDescription" style="display: none; color: #5cb85c;"><i><span>This is for displaying content title.</span></i></small>
                    </div>
                </div>

                <!-- <div class="form-group row mb-4">
                    <input type="text" id="txtTagByPost" value="{{ $posts->tags }}" readonly hidden>
                    <label for="divTags" class="col-md-2 mt-1">Tags</label>
                    <div class="col-md-5">
                        <div class="input textarea clearfix" id="divTags"></div>
                    </div>
                </div> -->

                <div class="form-group row mb-4" id="categoryArea">
                    <label for="category_id" class="col-md-2 mt-1">Category:</label>
                    <div class="col-md-5">
                        <select id="category_id" name="category_id" class="form-control">
                            <option value="" selected disabled>-- Please Select Category Type --</option>
                            @foreach($categories as $category)
                                @if($category->type != "MAINTANANCE" && $category->type != "FIRST PAGE")
                                    <option value="{{ $category->id }}" data-type="{{ $category->type }}" {{ $posts->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endif
                            @endforeach
                            <input type="hidden" id="hiddenTypeCategory">
                        </select>
                        <small id="categoryDescription" style="display: none; color: #5cb85c;"><i><span>This is for which category you will be posting to.</span></i></small>
                    </div>
                </div>

                <div class="form-group row mb-4" id="subcategoryArea">
                    <label for="subcategory_id" class="col-md-2 mt-1">Sub-Category:</label>
                    <div class="col-md-5">
                        <select id="subcategory_id" name="subcategory_id" class="form-control">
                            <option value="" selected disabled>-- Please Select Sub-Category Type --</option>
                            @foreach($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" {{ $posts->subcategory_id == $subCategory->id ? 'selected' : '' }}>
                                    {{ $subCategory->title }}
                                </option>
                            @endforeach
                        </select>
                        <small id="subcategoryDescription" style="display: none; color: #5cb85c;"><i><span>This is for which sub category you will be posting to.</span></i></small>
                    </div>
                    <label for="chkUsed" class="mr-3 mt-1 ml-3">Used:</label>
                    <div class="col-md-1 mt-2">
                        <input type="checkbox" id="chkUsed" class="form-check-input ml-1">
                    </div>
                </div>

                <div class="form-group row mb-4" id="productDiv">
                  <label for="content" class="col-md-2 mt-1">Product:</label>
                  <div class="col-md-5 mt-1">
                      <input type="radio" id="usedRadio" class="verticalRadio" name="product" value="1"
                      @if($posts->product == 1)
                        checked
                      @endif>
                      <label for="usedRadio">Used</label>
                      &nbsp;
                      <input type="radio" id="notUsedRadio" class="verticalRadio" name="product" value="0"
                      @if($posts->product == 0)
                        checked
                      @endif>
                      <label for="notUsedRadio">Not-Used</label>
                      <style>
                        input.verticalRadio {
                          margin-top: -1px;
                          vertical-align: middle;
                        }
                      </style>
                      <br>
                      <small id="productLabel" style="color: #5cb85c; display: none;"><i><span>Product is used for displaying PDF file.</span></i></small>
                  </div>
                </div>

                <div class="form-group row mb-4" id="contentTextArea">
                    <label for="content" class="col-md-2 mt-1">Text:</label>
                    <div class="col-md-7">
                        <textarea class="form-control" rows="5" id="bodyContent" name="body">{{ $posts->body }}</textarea>
                        <small id="textAreaLabel" style="color: #5cb85c; display: none;"><i><span>This is for post content text data.</span></i></small>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <div class="col-md-9">
                        <a class="btn btn-secondary" href="{{ route('posts.index') }}" style="float: right; color: white;">Back</a>
                        <input type="button" class="btn btn-primary mr-3" value="Update" id="btnPostUpdate" style="float: right;">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
