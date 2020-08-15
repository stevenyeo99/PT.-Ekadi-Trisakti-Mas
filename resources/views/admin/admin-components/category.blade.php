@extends('admin.layouts.index')

@section('content')
    <!-- category javascript -->
    <script src="{{ asset('public/js/category.js') }}" type="text/javascript"></script>

    <!-- category content -->
    <div class="card mb-3">

        <div class="card-header">
            <i class="fas fa-fw fa-list"></i>
            Category
        </div>

        <div class="card-body">
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
                    <div class="alert alert-info" id="alert-crud">
                        {{ session('message') }}
                    </div>
                @elseif(session('messageFail'))
                    <div class="alert alert-danger" id="alert-crud">
                        {{ session('messageFail') }}
                    </div>
                @endif
            </div>
            @if($length < 5)
            <form id="frmCategory" method="POST" action="{{ route('category.store')}}">
                @csrf
                <!-- <div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="top: 20%;"> -->
                    <!-- <div class="modal-dialog" role="document">
                        <div class="modal-content" style="padding: 0 20px;">
                            <div class="modal-header"> -->
                                <!-- <h5 class="modal-title">Add Category</h5>
                                <button class="close noOutlineX" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                </button>
                            </div> -->

                          <!-- <div class="modal-body"> -->
                              <div class="form-group row">
                                <label for="file_name" class="col-md-2">Title:</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="title" name="title" maxlength="20" minlength="3">
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="file_name" class="col-md-2">Type:</label>
                                <div class="col-md-4">
                                    <select id="type" name="type">
                                        <option value="" selected disabled>-- Please Select Your Type --</option>
                                        @if($home != 1)
                                        <option value="FIRST PAGE">FIRST PAGE</option>
                                        @endif
                                        @if($about != 1)
                                        <option value="ABOUT US">ABOUT US</option>
                                        @endif
                                        @if($listing != 1)
                                        <option value="LISTING">LISTING</option>
                                        @endif
                                        @if($sublisting != 1)
                                        <option value="LISTING SUB">LISTING SUB</option>
                                        @endif
                                        @if($maintanance != 1)
                                        <option value="MAINTANANCE">MAINTANANCE</option>
                                        @endif
                                    </select>
                                </div>
                              </div>
                          <!-- </div> -->

                          <!-- < <div class="modal-footer"> -->
                          <div class="form-group row">
                              <div class="col-md-6">
                                <button class="btn btn-primary" style="float: right;" id="btnAddCategory" type="button">Add</button>
                              </div>
                          </div>
                              <!-- <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button> -->
                          <!-- </div> -->
                      <!-- </div> -->
                  <!-- </div> -->
            </form>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dtCategory" width="100%" cellspacing="0">
                    <thead>

                          <!-- <tr>
                            <th colspan="4" style="text-align: center;">
                                <div id="addBtnAdmin" style="cursor: pointer;" data-toggle="modal" data-target="#addAdminModal">
                                  <i class="fas fa-fw fa-plus-circle"></i>
                                  Add
                                </div>
                                <style>
                                  div#addBtnAdmin:hover {
                                    color: #5cb85c;
                                  }
                                </style>
                            </th>
                          </tr> -->

                        <tr>
                            <th style="width: 20%;">No</th>
                            <th hidden>Id</th>
                            <th style="width: 30%;">Tittle</th>
                            <th style="width: 30%;">Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td></td>
                                <td hidden>{{ $category->id}} </td>
                                <td>
                                    <span>{{ $category->title }}</span>
                                    <input type="hidden" value="{{ $category->title }}" readonly>
                                </td>
                                <td>
                                    <span>{{ $category->type }}</span>
                                    <input type="hidden" value="{{ $category->type }}" readonly>
                                </td>
                                <form method="POST" action="{{ route('category.deleteTitle') }}" id="frmDeleteCategory">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                </form>
                                <td>
                                    <button id="btnEditCategory" class="btn btn-warning" data-toggle="modal" data-target="#editCategory" style="color: white;">Modify</button>
                                        <input type="hidden" value="{{ $category->id }}" name="id" id="txtIdDelete" readonly>
                                        <button class="btnDeleteCategory btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <!-- modal edit -->
            <form id="frmEdit" method="POST" action="{{ route('category.updateTitle') }}">
                @csrf
                {{ method_field('PUT') }}
                <div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="top: 30%;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Category</h5>
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
                                    <label for="editTitle" class="col-md-2 col-form-label text-md-right">Title:</label>
                                    <div class="col-md-9">
                                      <input type="text" class="form-control" id="editTitle" name="title">
                                    </div>
                                </div>

                                <!-- <div class="form-group row">
                                    <label for="editTitle" class="col-md-2 col-form-label text-md-right">Type:</label>
                                    <div class="col-md-9 mt-2">
                                      <select id="typeEdit" name="type">
                                          <option value="">-- Please Select Your Type --</option>
                                          <option value="FIRST PAGE">FIRST PAGE</option>
                                          <option value="ABOUT US">ABOUT US</option>
                                          <option value="LISTING">LISTING</option>
                                      </select>
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" id="btnUpdateCategory" type="button">Update</button>
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
