@extends('admin.layouts.index')

@section('content')
    <script src="{{asset('public/js/ManageAdmin.js')}}" type="text/javascript"></script>

    <div class="card-mb-3">
        <div class="card-header">
            <i class="fas fa-fw fa-user"></i>
            View All Admin Profile
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
                <table id="dtManageAdmin" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th colspan="3" style="text-align: center;">
                                <div id="addBtnAdmin" style="cursor: pointer;" data-toggle="modal" data-target="#addAdminModal">
                                  <i class="fas fa-fw fa-user-plus"></i>
                                  Add
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
                            <th>Username</th>
                            <!-- <th>Email</th> -->
                            <th>
                                Remove
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($listOfAdmins as $admin)
                          <tr>
                              <td></td>
                              <td>{{$admin->name}}</td>
                              <!-- <td>{{$admin->email}}</td> -->
                              <td>
                                  <form id="deleteUserAdmin" method="POST" action="{{ route('manageAdmin.deleteAdminById') }}">
                                      @csrf
                                      {{ method_field('DELETE') }}
                                      <input type="hidden" class="deleteAdminId" value="{{ $admin->id }}" name="admin_id" readonly>
                                      <input type="button" class="btnDelete btn btn-danger" value="Delete">
                                  </form>
                              </td>
                          </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>


            <!-- modal for add-->
            <form id="frmAddAdminAccountProfile" method="POST" action="{{ route('manageAdmin.store') }}">
                @csrf
                <div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="top: 20%;">
                    <style>
                      @media(min-width: 800px)
                      {
                        #modal-form-admin {
                          max-width: 800px;
                        }
                      }

                      @media(max-width: 764px)
                      {
                        div#addAdminModal {
                          margin-top: -10%;
                        }
                      }
                    </style>
                    <div class="modal-dialog" id="modal-form-admin" role="document">
                        <div class="modal-content" style="padding: 0 20px;">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Admin</h5>
                                <button class="close noOutlineX" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group row" id="usernameArea">
                                    <label for="name" class="col-md-2 col-form-label text-md-right">Username <span style="color: red;">*</span></label>
                                    <div class="col-md-9">
                                      <input type="text" class="form-control" id="name" name="name" placeholder="ekadiAdmin">
                                      <small id="usernameLabel" style="display: none; color: #5cb85c;"><i><span>Admin User Name.</span></i></small>
                                    </div>
                                </div>

                                <!-- <div class="form-group row">
                                    <label for="email" class="col-md-2 col-form-label text-md-right">Email <span style="color: red;">*</span></label>
                                    <div class="col-md-9">
                                      <input type="text" class="form-control" id="email" name="email" placeholder="ekadiadmin@gmail.com">
                                    </div>
                                </div> -->

                                <div class="form-group row" id="passwordArea">
                                    <label for="password" class="col-md-2 col-form-label text-md-right">Password <span style="color: red;">*</span></label>
                                    <div class="col-md-9">
                                      <input type="password" class="form-control" id="password" name="password" placeholder="testing123">
                                      <small id="passwordLabel" style="display: none; color: #5cb85c;"><i><span>Admin Password.</span></i></small>
                                    </div>
                                </div>

                                <div class="form-group row" id="confirmPasswordArea">
                                    <label for="confirm_password" class="col-md-2 col-form-label text-md-right">Confirm <span style="color: red;">*</span></label>
                                    <div class="col-md-9">
                                      <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="testing123">
                                      <small id="confirmPasswordLabel" style="display: none; color: #5cb85c;"><i><span>Admin Password Confirmation.</span></i></small>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" id="btnAddUserAccount" type="button">Add</button>
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@endsection
