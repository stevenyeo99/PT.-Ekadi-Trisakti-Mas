@extends('admin.layouts.index')

@section('content')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" type="text/css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js.map"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js.map"></script>
  <link rel="stylesheet" href="{{ asset('public/css/manageGallery.css') }}" type="text/css">
  <script src="{{ asset('public/js/manageGallery.js') }}" type="text/javascript"></script>

  <div class="card-mb-3">
      <div class="card-header">
        <i class="fas fa-fw fa-image"></i>
        Manage Gallery
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


            <form method="POST" action="{{ route('manageGallery.store') }}" id="frmAddPhoto" enctype="multipart/form-data">
                @csrf
                <div class="form-group row" id="typeArea">
                    <label for="ddlType" class="col-md-2">Type:</label>
                    <div class="col-md-4">
                        <select id="ddlType" name="type">
                            <option value="" selected disabled>-- Please Select Type --</option>
                            @foreach($listing as $list)
                                <option value="{{$list->id}}"
                                  @if(isset($postId))
                                      @if($postId == $list->id)
                                          selected
                                      @endif
                                  @endif
                                  >{{ $list->post_title }}</option>
                            @endforeach
                        </select>
                        <small id="typeLabel" style="display: none; color: #5cb85c;"><i><span>Select Type to retrieve posting gallery images.</span></i></small>
                    </div>
                </div>

                @if(isset($valid))
                    <div class="form-group row" id="galleryAddImageArea">
                        <label for="file_name" class="col-md-2">Image:</label>
                        <div class="col-md-4">
                            <input type="file" id="file_name" name="file_name" class="form-control-file" accept="image/*">
                            <small id="galleryAddImageLabel" style="display: none; color: #5cb85c;"><i><span>This for image file uploader base on posting.</span></i></small>
                        </div>
                    </div>

                    <div class="form-group row" id="galleryAddDescArea">
                        <label for="" class="col-md-2">Description</label>
                        <div class="col-md-4">
                            <input type="text" id="description" name="description" class="form-control">
                            <small id="galleryAddDescLabel" style="display: none; color: #5cb85c;"><i><span>This for image description.</span></i></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="button" id="btnAddPhoto" class="btn btn-primary" value="Add" style="float: right;">
                        </div>
                    </div>
                @endif
            </form>

           @if(isset($valid))
        <div class="table-responsive">
            <table id="dtManageGallery" class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Product</th>
                        <th style="width: 30%;">Image</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if(isset($listImageByPostId))
                        @foreach($listImageByPostId as $image)
                            <tr>
                                <td></td>
                                <td>{!! $name !!}</td>
                                <td>
                                    <a href="{{ asset('public').'/'.$image->original_path }}" data-toggle="lightbox">
                                      <img src="{{ asset('public').'/'.$image->original_path }}"
                                      class="img-fluid"
                                      alt="{{ $image->file_name }}">
                                    </a>
                                </td>
                                <td>
                                    <span>{{ $image->alt }}</span>
                                    <input type="hidden" value="{{ $image->alt }}">
                                </td>
                                <td>
                                    <input type="hidden" id="id" value="{{ $image->id }}" readonly>
                                    <input id="post_id" type="hidden" value="{{$image->post_id}}" readonly>
                                    <button class="btn btn-warning appendIdBtn" style="color: white;" data-toggle="modal" data-target="#EditImageModal">Modify</button>
                                    <button class="btn btn-danger deleteBtnImage">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
          @else
          <div class="container">
            <h1>Product Image Gallery</h1>
          </div>
          @endif

          <form id="frmDeleteImage" method="POST" action="{{ route('manageGallery.deleteImage') }}">
            @csrf
            {{ method_field('DELETE') }}
                <input type="hidden" id="deleteId" name="id" readonly>
          </form>

        <form id="frmEditImage" method="POST" action="{{ route('manageGallery.updateImage') }}" enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal fade" id="EditImageModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="top: 20%;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="padding: 0 20px;">
                        <div class="modal-header">
                            <h5 class="modal-title">Modify Image</h5>
                            <button class="close noOutlineX" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">x</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group row" id="bodyUploadImage" hidden>
                              <label for="file_name" class="col-md-3 text-md-right">Image:</label>
                              <div class="col-md-9">
                                  <input type="hidden" id="edit_id" name="id" readonly>
                                  <input type="hidden" id="post_id_edit" name="post_id_edit" readonly>
                                  <input type="file" class="form-control-file" id="input_file_name" name="file_name" accept="image/*">
                                  <small id="bodyUploadImageLabel" style="display: none; color: #5cb85c;"><i><span>File for upload image gallery.</span></i></small>
                              </div>
                            </div>

                            <div class="form-group row" id="changeImageArea">
                              <label for="changeImage" class="col-md-3 text-md-right">Modify</label>
                              <div class="col-md-9">
                                  <input type="checkbox" value="1" id="changeImage" style="vertical-align: middle; top: -1px;" name="changeImage">
                                  <small id="changeImageLabel" style="display: none; color: #5cb85c;"><i><span>This for edit image file.</span></i></small>
                              </div>
                            </div>

                            <div class="form-group row" id="modifyDescriptionArea">
                                <label for="edit_description" class="col-md-3 text-md-right mt-1">Description:</label>
                                <div class="col-md-9">
                                    <input type="text" id="edit_description" name="description" class="form-control">
                                    <small id="modifyDescriptionLabel" style="display: none; color: #5cb85c;"><i><span>This for image description.</span></i></small>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary" id="btnEditImage" type="button">Update</button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
              </form>
      </div>
  </div>
@endsection
