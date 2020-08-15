@extends('admin.layouts.index')

@section('content')
    <script type="text/javascript" src="{{ asset('public/js/profile.js') }}"></script>

    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-fw fa-user"></i>
            Profile
        </div>

        <div class="card-body">
            <div class="col-sm-12 mb-3">
                @if(session('message'))
                    <div class="alert alert-success" id="alert-crud">
                        {{ session('message') }}
                    </div>
                    @elseif(session('messageFail'))
                    <div class="alert alert-danger" id="alert-crud">
                        {{ session('messageFail') }}
                    </div>
                @endif
            </div>

            <form method="POST" action="{{ route('profile.updateNameAndEmail') }}" id="frmEditUserNameAndEmail">
                @csrf
                {{ method_field('PUT') }}
                <div class="form-group row" id="userNameArea">
                    <input type="hidden" name="id" value="{{ $user->id }}" readonly>
                    <label for="name" class="col-sm-2 col-form-label">
                        User name:
                    </label>
                    <div class="col-sm-6">
                        <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control">
                        <small id="userNameLabel" style="display: none; color: #5cb85c;"><i><span>This is for user name data.</span></i></small>
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                </div>

                <!-- <div class="form-group row mb-4">
                    <label class="col-sm-2 mt-1" for="email">
                        Email:
                    </label>
                    <div class="col-sm-6">
                        <input type="text" id="email" name="email" value="{{ $user->email }}" class="form-control">
                          <span class="text-danger">{{ $errors->first('email') }}</span>
                    </div>

                </div> -->

                <div class="form-group row mb-4">
                    <label class="col-sm-2 mt-1" for="password">
                        Role:
                    </label>
                    <div class="col-sm-6">
                        <input type="text" value="@if($user->user_role == 1) General-Admin @else Admin @endif" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row mb-4" id="captchaArea">
                    <label class="col-sm-2 mt-1 mr-3" for="captcha">Captcha:</label>
                    <div class="col-sm-6">
                      {!! NoCaptcha::renderJs() !!}
                      {!! NoCaptcha::display() !!}
                      <span class="text-danger ml-3">{{ $errors->first('g-recaptcha-response') }}</span>
                      <small id="captchaLabel" style="display: none; color: #5cb85c;"><i><span>This is for make sure you are not robot.</span></i></small>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <div class="col-md-5">
                        <input type="button"
                               id="btnUpdateUserNameAndEmail"
                               class="btn btn-primary"
                               value="Update"
                               style="float: right; color: white; margin-left: 10px;">
                        <button type="button"
                              class="btn btn-warning"
                              style="float: right; color: white;"
                              data-toggle="modal"
                              data-target="#resetPassword"
                              id="modalResetProfile">Reset Password
                        </button>
                        <input type="hidden" id="userId" value="{{$user->id}}" readonly>
                    </div>
                </div>
            </form>

            <form id="frmEditPassword" method="POST" action="{{ route('profile.changeNewPassword') }}">
                  {{ method_field('PUT') }}
                  <input type="hidden" value="{{ $user->id }}" name="id" readonly>
                  <input type="hidden" value="{{ csrf_token() }}" id="laravelTokken" name="_token" readonly>
                  <div class="modal fade" id="resetPassword" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="top: 25%;">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title">Reset Password</h5>
                                  <button class="close noOutlineX" type="button" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">x</span>
                                  </button>
                              </div>
                              <input type="hidden" name="token" id="token" value="{{ $user->token }}" readonly>
                              <div class="modal-body">
                                  <!-- <div class="form-group row">
                                      <label for="email" class="col-md-3 col-form-label text-md-center">Email:</label>
                                      <div class="col-md-9">
                                          <input type="text" class="form-control" id="emailModal" name="email" readonly>
                                      </div>
                                  </div> -->

                                  <div class="form-group row" id="passwordArea">
                                      <label for="password" class="col-md-3 col-form-label text-md-center">Pass:</label>
                                      <div class="col-md-9">
                                          <input type="password" class="form-control" id="password" name="password">
                                          <small id="passwordLabel" style="display: none; color: #5cb85c;"><i><span>New Password Changes.</span></i></small>
                                      </div>
                                  </div>

                                  <div class="form-group row" id="confirmPasswordArea">
                                      <label for="confirmation_password" class="col-md-3 col-form-label text-md-center">Confirm:</label>
                                      <div class="col-md-9">
                                          <input type="password" class="form-control" id="confirmation_password" name="confirmation_password">
                                          <small id="confirmPasswordLabel" style="display: none; color: #5cb85c;"><i><span>New Confirmation Password Changes.</span></i></small>
                                      </div>
                                  </div>
                              </div>

                              <div class="modal-footer">
                                  <button class="btn btn-primary" id="btnResetPassword" type="button">Change</button>
                                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                              </div>
                          </div>
                      </div>
                  </div>
            </form>
        </div>
    </div>
@endsection
