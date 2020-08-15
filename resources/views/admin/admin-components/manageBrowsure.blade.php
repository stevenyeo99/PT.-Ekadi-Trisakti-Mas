@extends('admin.layouts.index')

@section('content')
<script src="{{asset('public/js/ManageBrowsure.js')}}" type="text/javascript"></script>

<div class="card-mb-3">
    <div class="card-header">
        <i class="fas fa-fw fa-file"></i>
        Manage Product Brochure
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

        <div class="table-responsive">
            <table id="dtManageBrowsure" class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th colspan="4" style="text-align: center;">
                        <div id="addBtnAdmin" style="cursor: pointer;" data-toggle="modal" data-target="#addPDFModal">
                          <i class="fas fa-fw fa-plus-circle"></i>
                          PDF
                        </div>
                        <style>
                          div#addBtnAdmin:hover {
                            color: #5cb85c;
                          }
                        </style>
                      </th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th hidden></th>
                        <th>Product</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($listOfProductBrowsures as $productBrowsure)
                        <tr>
                            <td></td>
                            <td hidden>
                                <input type="hidden" id="browsureId" value="{{$productBrowsure->id}}" readonly>
                                <input type="hidden" id="postId" value="{{$productBrowsure->product_id}}" readonly>
                            </td>
                            <td>
                              <span>{{ $productBrowsure->product_name }}</span>
                              <input type="hidden" id="txtProductName" value="{{ $productBrowsure->product_name }}" readonly>
                              <input type="hidden" id="txtUrlViewBrowsure" value="/ekadi/admin/manageBrowsure/getBrowsurePDFPreview/{{ $productBrowsure->id }}" readonly>
                              <input type="hidden" id="txtFileName" value="{{ $productBrowsure->file_name }}" readonly>
                            </td>
                            <td>
                              <button class="btn btn-info" onclick="openPopUpNewWindows('/ekadi/admin/manageBrowsure/getBrowsurePDFPreview/{{ $productBrowsure->id }}', 'PreviewBrowsurePDF')">
                                View Brochure
                              </button>
                            </td>
                            <td>
                                <button class="btn btn-warning productRowEdit" data-toggle="modal" data-target="#updatePDFModal" style="color: white;">Modify</button>
                                <button class="btn btn-danger btnDeleteBrowsure" id="btnDeleteBrowsure">Delete</button>
                                <input type="hidden" name="browsureHiddenId" id="browsureHiddenIdDelete" value="{{ $productBrowsure->id }}" readonly>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <form method="POST" action="{{ route('manageBrowsure.deleteBrowsure') }}" id="frmDeleteBrowsureProduct">
                @csrf
                {{ method_field('DELETE') }}
            </form>

            <form id="frmUpdateBrowsureProduct" method="POST" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <div class="modal fade" id="updatePDFModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="top: 20%;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="padding: 0 20px;">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Browsure</h5>
                                <button class="close noOutlineX" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group row" id="createProductDDLArea">
                                    <label for="file_name" class="col-md-3 text-md-right">Product:</label>
                                    <div class="col-md-9">
                                        <select id="post_id_by_sub_category_edit" name="post_id">

                                        </select>
                                        <input type="hidden" id="txtProductEdit" name="product_name" readonly>
                                        <input type="hidden" id="hiddenId" name="hiddenId" readonly>
                                        <small id="createProductDDLLabel" style="display: none; color: #5cb85c;"><i><span>This is base posting that require product brochure.</span></i></small>
                                    </div>
                                </div>

                                <div class="form-group row" id="editFileBrochureArea">
                                  <label for="file_name" class="col-md-3 text-md-right">Brochure:</label>
                                  <div class="col-md-9">
                                      <div id="pdfPreview">
                                          <a id="hrefFileName" class="btn btn-primary" style="color: white;"></a>
                                          <small id="editBrocureALabel" style="display: none; color: #5cb85c;"><i><span>Click this button to view the brochure.</span></i></small>
                                      </div>

                                      <div id="editBrowsurePdf" hidden>
                                        <input type="file" class="form-control-file" id="input_file_name_edit" name="file_name" accept="application/pdf">
                                        <small id="editBrocureFileFileLabel" style="display: none; color: #5cb85c;"><i><span>This for upload product brochure file.</span></i></small>
                                      </div>
                                  </div>
                                </div>

                                <div class="form-group row" id="editBrocureArea">
                                    <label for="editBrowsureAttachment" class="col-md-3 text-md-right">Edit:</label>
                                    <div class="col-md-9">
                                        <input type="checkbox" id="toggleEditBrowsure" name="toggleEditBrowsure" style="vertical-align: middle; top: -1px;" value="1">
                                        <small id="editBrocureLabel" style="display: none; color: #5cb85c;"><i><span>This for edit product brochure file.</span></i></small>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                              <button class="btn btn-primary" id="btnUpdateProductBrowsure" type="button">Update</button>
                              <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- modal for add-->
            <form id="frmAddBrowsureProduct" method="POST" action="{{route('manageBrowsure.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal fade" id="addPDFModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="top: 20%;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="padding: 0 20px;">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Brochure</h5>
                                <button class="close noOutlineX" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group row" id="productAreaCreate">
                                  <label for="file_name" class="col-md-3 text-md-right">Product:</label>
                                  <div class="col-md-9">
                                      <select id="post_id_by_sub_category" name="post_id">
                                          <option value="" selected disabled>-- Please Select Your Product --</option>
                                          @foreach($postByProduct as $product)
                                              @if($product->subCatTitle == null)
                                                  <option value="{{ $product->id }}">{{ $product->post_title }} &nbsp;&nbsp; [{{$product->catTitle}}]</option>
                                                  @else
                                                  <option value="{{ $product->id }}">{{ $product->post_title }} &nbsp;&nbsp; [{{$product->catTitle}}({{$product->subCatTitle}})]</option>
                                              @endif
                                          @endforeach
                                      </select>
                                      <small id="productLabelCreate" style="display: none; color: #5cb85c;"><i><span>This is base posting that require product brochure.</span></i></small>
                                      <input type="hidden" id="txtProduct" name="product_name" readonly>
                                  </div>
                                </div>

                                <div class="form-group row" id="productFileCreateArea">
                                  <label for="file_name" class="col-md-3 text-md-right">Brochure:</label>
                                  <div class="col-md-9">
                                      <input type="file" class="form-control-file" id="input_file_name" name="file_name" accept="application/pdf">
                                      <small id="productLabelCreateArea" style="display: none; color: #5cb85c;"><i><span>This is file pdf uploader for brochure product.</span></i></small>
                                  </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" id="btnAddProductBrowsure" type="button">Add</button>
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>

@endsection
