@extends('admin.layouts.index')

@section('content')
    <style>
        @media screen and (max-width: 1000px) {
            .desc {
                display: none;
            }
        }
    </style>
    <script src="{{ asset('public/js/slideshow.js') }}" type="text/javascript"></script>

    <!-- slide show content -->
    <div class="card mb-3">

        <div class="card-header">
            <i class="fas fa-fw fa-file-image"></i>
            Slide-Show
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
                      <div class="alert alert-success" id="alert-crud">
                          {{ session('message') }}
                      </div>
                    @elseif(session('messageFail'))
                      <div class="alert alert-danger" id="alert-crud">
                            {{ session('messageFail') }}
                      </div>
                @endif
            </div>

            <form method="POST" action="{{ route('slideshow.store') }}" id="frmUploadFile" enctype="multipart/form-data">
              @csrf
              <div class="form-group row" id="addImageSlideShowArea">
                  <label for="file" class="col-md-2">Image:</label>
                  <div class="col-md-4">
                      <input type="file" id="file_name" name="file_name" class="form-control-file" accept="image/*">
                      <small id="addImageSlideShowLabel" style="display: none; color: #5cb85c;"><i><span>File for upload slideshow image.</span></i></small>
                  </div>
              </div>

              <div class="form-group row" id="addDescSlideShowArea">
                  <label for="alt" class="col-md-2 mt-1">Description</label>
                  <div class="col-md-4">
                      <input type="text" id="alt" name="alt" class="form-control">
                      <small id="addDescSlideShowLabel" style="display: none; color: #5cb85c;"><i><span>This for slideshow description.</span></i></small>
                  </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6">
                    <button class="btn btn-primary" id="btnAddImage" style="float: right;">Upload</button>
                </div>
              </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" id="dtSlideShow" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Image</th>
                            <th hidden>Id</th>
                            <th style="width:30%;" class="desc">Description</th>
                            <!-- <th style="width: 10%;">Date Created Or Updated</th> -->
                        </tr>
                    </thead>

                    <tbody>
                      @foreach($slideShow as $slide)
                        <tr data-toggle="modal" data-target="#slideShowAction">
                            <td></td>
                            <td>
                              <img
                              src="{{ asset('public').'/'.$slide->original_path }}"
                              class="img-fluid img-responsive"
                              style="height: 300px;"
                              alt="{{$slide->file_name}}"
                              >
                              <span hidden>{{$slide->file_name}}</span>
                            </td>
                            <td hidden>
                                {{ $slide->id }}
                            </td>
                            <td class="desc">
                                <span>{{ $slide->alt }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- modal action -->
            <form id="frmActionSlideShow" enctype="multipart/form-data">
              @csrf
              <div class="modal fade" id="slideShowAction" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"
              style="top: 30%;">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title">Edit/Delete Image</h5>
                              <button class="close noOutlineX" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">x</span>
                              </button>
                          </div>

                          <div class="modal-body">
                              <div class="form-group row" hidden>
                                  <label for="hiddenId" class="col-md-2 col-form-label text-md-right">id</label>
                                  <div class="col-md-9">
                                      <input type="text" class="form-control" id="hiddenId" name="id" readonly>
                                      <!-- <input type="text" class="form-control" id="file_nameOld" name="file_name" readonly> -->
                                  </div>
                              </div>

                              <div class="form-group row" id="bodyUploadImage" hidden>
                                  <label for="file_name" class="col-md-3 text-md-right">Image</label>
                                  <div class="col-md-9">
                                      <input type="file" class="form-control-file" id="input_file_name" name="file_name">
                                      <small id="bodyUploadImageLabel" style="display: none; color: #5cb85c;"><i><span>File for upload slideshow image.</span></i></small>
                                  </div>
                              </div>

                              <div class="form-group row" id="modifyImageChkArea">
                                <label for="changeImage" class="col-md-3 text-md-right">Modify</label>
                                <div class="col-md-9">
                                    <input type="checkbox" value="1" id="changeImage" style="vertical-align: middle; top: -1px;" name="changeImage">
                                    <br>
                                    <small id="modifyImageChkLabel" style="display: none; color: #5cb85c;"><i><span>This for edit image slideshow.</span></i></small>
                                </div>
                              </div>

                              <div class="form-group row" id="modifyDescriptionArea">
                                  <label for="file_name" class="col-md-3 text-md-right">Description</label>
                                  <div class="col-md-9">
                                      <input type="text" class="form-control" id="altModal" name="alt">
                                      <small id="modifyDescriptionLabel" style="display: none; color: #5cb85c;"><i><span>This for slideshow description.</span></i></small>
                                  </div>
                              </div>
                          </div>

                          <div class="modal-footer">
                              <button class="btn btn-primary" id="btnUpdateSlideShowImage">
                                Update
                              </button>
                              <button class="btn btn-danger" id="btnDeleteSlideShowImage">
                                Delete
                              </button>
                              <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                      </div>
                  </div>
              </div>
          </form>
        </div>
    </div>
@endsection
