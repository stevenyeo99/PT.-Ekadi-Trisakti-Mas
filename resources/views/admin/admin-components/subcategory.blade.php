@extends('admin.layouts.index')

@section('content')
      <script src="{{ asset('public/js/subcategory.js') }}" type="text/javascript"></script>

      <div class="card mb-3">

          <div class="card-header">
              <i class="fas fa-fw fa-clone"></i>
              Sub-Category
          </div>

          <div class="card-body">
            <form method="POST" action="{{ route('subcategory.store') }}" id="frmAddSubCategory">
              @csrf
              <div class="col-sm-12 mb-3">
                    @if($errors->any())
                      <div class="alert alert-danger" id="alert-crud">
                          <ul>
                              @foreach($errors->all() as $error)
                                  <li>{{ $error }}</li>
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

                  <div class="form-group row">
                      <label for="ddlCategory" class="col-md-2">Category Type: </label>
                      <div class="col-md-4">
                      <select class="form-control" id="ddlCategory" name="category_id">
                          <option value="" selected disabled>-- Please Select Category --</option>
                          @foreach($categories as $category)
                              <option value="{{ $category->id }}">
                                  {{ $category->title }}
                              </option>
                          @endforeach
                      </select>
                    </div>
                    </div>

                      <div class="form-group row">
                        <label for="txtTitle" class="mt-1 col-md-2">Title: </label>
                        <div class="col-md-4">
                        <input type="text" class="form-control" id="txtTitle" name="title" maxlength="20" minlength="3">
                      </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-md-6">

                          <input type="button" id="btnAddSubCategory" value="Add" style="float: right;"class="btn btn-primary ml-3">
                        </div>
                        </div>

            </form>

              <div class="table-responsive">
                  <table class="table table-bordered" id="dtSubCategory" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                              <th style="width: 10%;">No</th>
                              <th hidden>Id</th>
                              <th>Type</th>
                              <th>Title</th>
                              <th style="width: 20%;">Action</th>
                          </tr>
                      </thead>

                      <tbody>
                          @foreach($subCategories as $subCategory)
                              <tr>
                                  <td></td>
                                  <td hidden>{{ $subCategory->id }}</td>
                                  <td>
                                    <span>{{ $subCategory->catTitle }}</span>
                                    <input type="hidden" value="{{ $subCategory->category_id }}" readonly>
                                  </td>
                                  <td>
                                    <span>{{ $subCategory->title }}</span>
                                    <input type="hidden" value="{{ $subCategory->title }}" readonly>
                                  </td>
                                  <form method="POST" action="{{ route('subcategory.deleteSubCategory')}}" id="frmDltSubCat">
                                      @csrf
                                      {{ method_field('delete') }}
                                  </form>
                                  <td>
                                      <button class="btn btn-warning" data-toggle="modal" data-target="#editSubCategory" style="color: white;">
                                        Modify
                                      </button>
                                      <input type="hidden" value="{{ $subCategory->id }}" id="idHidden" name="id" readonly>
                                      <button class="btn btn-danger btnDeleteSubCategory">Delete</button>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>

              <!-- modal edit -->
              <form id="frmEdit" method="POST">
                  @csrf
                  {{ method_field('PUT') }}
                  <div class="modal fade" id="editSubCategory" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"
                  style="top:30%;">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title">Edit Sub-Category</h5>
                                  <button class="close noOutlineX" type="button" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">x</span>
                                  </button>
                              </div>

                              <div class="modal-body">
                                  <div class="form-group row" hidden>
                                      <label for="hiddenId" class="col-md-2 col-form-label text-md-right">id:</label>
                                      <div class="col-md-9">
                                          <input type="text" class="form-control" id="hiddenId" name="id">
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label for="ddlCategoryId" class="col-md-2 col-form-label text-md-right">Type:</label>
                                      <div class="col md-9">
                                          <select id="ddlCategoryId" name="category_id" class="form-control">
                                              @foreach($categories as $category)
                                              <option value="{{$category->id}}">{{$category->title}}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label for="txtSubCategory" class="col-md-2 col-form-label text-md-right">Title:</label>
                                      <div class="col md-9">
                                          <input type="text" class="form-control" name="title" id="txtSubCategory">
                                      </div>
                                  </div>
                              </div>

                              <div class="modal-footer">
                                  <button class="btn btn-primary" id="btnUpdateSubCategory" type="button">Update</button>
                                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </form>

          </div>

      </div>


@endsection
