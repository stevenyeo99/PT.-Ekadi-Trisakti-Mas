@extends('admin.layouts.index')

@section('content')
  <!-- <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
  <script src="{{asset('public/js/viewAllPosts.js')}}" type="text/javascript"></script>

    <div class="card-mb-3">
        <div class="card-header">
            <i class="fas fa-fw fa-book"></i>
            View All Posts
        </div>

        <div class="card-body">
            <div class="col-sm-4 mb-3">
                @if($errors->any())
                    <div class="alert alert-danger" id="alert-crud">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>$error</li>
                            @endforeach
                        </ul>
                    </div>

                    @elseif(session('message'))
                        <div class="alert alert-success" id="alert-crud">
                            {{ session('message') }}
                        </div>

                  @elseif(session('messageFail'))
                    <div class="alert alert-danger" id="alert-crud">
                        {{ session('messageFail') }}
                    </div>

                @endif
            </div>

            <form id="frmDeletePost" action="{{ route('posts.deletePosts') }}" method="POST">
                @csrf
                <div class="col-md-4 mb-3">
                    <div class="form-check">
                        <input class="form-check-input mt-3" type="checkbox" id="tickDeleteAll">
                        <label class="form-check-label mt-2 ml-2" for="tickDeleteAll">Tick To Delete All</label>
                        <input type="text" value="" id="idToBeDelete" name="ids" hidden readonly>
                        <button type="button" class="btn btn-danger ml-3" id="btnDeletePost">Delete</button>
                    </div>
                </div>
            </form>

            <form method="POST" action="{{ route('posts.filterPostsResult') }}" id="frmGetPost">
                @csrf
                <div class="form-group row">
                    <label for="ddlCategoryFilter" class="col-md-2">Category: </label>
                    <div class="col-md-4">
                        <select id="ddlCategoryFilter" name="ddlCategoryFilter">
                            <option value="" selected disabled>-- Please Select Category --</option>
                            <option value="0"
                            @if(session('category_id') == 0)
                              selected
                            @endif
                            >-- All --</option>
                            @foreach($categories as $category)
                                @if($category->type != "MAINTANANCE" && $category->type != "FIRST PAGE")
                                    <option value="{{ $category->id }}"
                                      @if(session('category_id') == $category->id)
                                        selected
                                      @endif
                                      >{{ $category->title }}</option>
                                  @endif
                            @endforeach
                        </select>
                    </div>
                  </div>

                <div class="form-group row">
                    <label for="ddlSubCategoryFilter" class="col-md-2">Sub-Category: </label>
                    <div class="col-md-4">
                        <select id="ddlSubCategoryFilter" name="ddlSubCategoryFilter">
                            @if(session('sizeSub'))
                                    <option value="0"
                                    @if(session('subCategoryId') == 0)
                                        selected
                                    @endif
                                    >-- All --</option>
                                @foreach(session('listOfSubCategories') as $subCategory)
                                    <option value="{{ $subCategory->id }}"
                                      @if(session('subCategoryId') == $subCategory->id)
                                          selected
                                      @endif
                                      >{{ $subCategory->title }}</option>
                                @endforeach
                              @else
                                <option value="" selected disabled>-- Empty Sub-Category --</option>
                            @endif
                        </select>
                    </div>
                  </div>

                  <!-- <div class="col-md-1 ml-2" style="margin-top: -5px;"> -->
                    <div class="form-group row">
                      <div class="col-md-6">
                      <button id="btnFilter" type="button" class="btn btn-success" style="float: right;">Filter</button>
                    </div>
                  </div>
            </form>

            <div class="table-responsive">
                <table id="dtPosts" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th colspan="7" style="border: none;">
                                <a class="btn btn-primary" href="{{ route('posts.create') }}" style="float: right; color: white;">Add Post</a>
                            </th>
                        </tr>

                        <tr>
                            <th>No</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Product</th>
                            <th>Text</th>
                            <th style="width: 5%;">
                              Edit
                            </th>
                            <th style="width: 5%;">Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(session('postResultFilter'))
                            @foreach(session('postResultFilter') as $post)
                            <tr>
                                <td></td>
                                <td>
                                  @if($post->subCatTitle == null)
                                    {{ $post->catTitle }}
                                    @else
                                    {{ $post->catTitle }} ({{ $post->subCatTitle }})
                                  @endif
                                </td>
                                <td>{{ $post->post_title }}</td>
                                <td>
                                    @if($post->product == 1)
                                        Product
                                        @else
                                          Non-Product
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-info" onclick="openPopUpNewWindows('posts/showPostById/{{$post->id}}', 'view Post')">
                                        View Text
                                    </button>
                                </td>
                                <td>
                                    <label class="btn btn-warning" class="btnEditPost">
                                        <a href="posts/{{$post->id}}/edit" style="color: white;">
                                          <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                    </label>
                                </td>
                                <td>
                                  <label class="btn btn-danger">
                                      <input type="checkbox" class="tickDelete" value="{{ $post->id }}" hidden>
                                      <i class="fa fa-fw fa-check" style="opacity: 0;"></i>
                                  </label>
                                </td>
                            </tr>
                            @endforeach

                            @else
                              @foreach($posts as $post)
                                  <tr>
                                      <td></td>
                                      <td>
                                        @if($post->subCatTitle == null)
                                          {{ $post->catTitle }}
                                          @else
                                          {{ $post->catTitle }} ({{ $post->subCatTitle }})
                                        @endif
                                      </td>
                                      <td>{{ $post->post_title }}</td>
                                      <td>
                                          @if($post->product == 1)
                                              Product
                                              @else
                                                Non-Product
                                          @endif
                                      </td>
                                      <td>
                                          <button class="btn btn-info" onclick="openPopUpNewWindows('posts/showPostById/{{$post->id}}', 'view Post')">
                                              View Text
                                          </button>
                                      </td>
                                      <th>
                                          <label class="btn btn-warning" class="btnEditPost">
                                              <a href="posts/{{$post->id}}/edit" style="color: white;">
                                                <i class="fa fa-fw fa-edit"></i>
                                              </a>
                                          </label>
                                      </th>
                                      <th>
                                        <label class="btn btn-danger">
                                            <input type="checkbox" class="tickDelete" value="{{ $post->id }}" hidden>
                                            <i class="fa fa-fw fa-check" style="opacity: 0;"></i>
                                        </label>
                                      </th>
                                  </tr>
                              @endforeach
                          @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
