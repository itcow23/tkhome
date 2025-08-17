@extends('client.layouts.master')

@section('content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="#">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="#">Product</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->
<button class="btn" data-toggle="modal" data-target="#login">
    modal
</button>
<div class="modal fade" id="login" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 500px;">
        <div class="modal-content" style="border-radius: 40px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body" style="max-height: 600px;">
                <div class="row no-gutters">
                    <div class="col-md-8 offset-md-2" style="margin: 60px auto;">
                        <ul class="nav nav-pills">
                            <li class="nav-item" style="width: 50%;"><a style="text-align: center;" class="nav-link active" data-toggle="tab" href="#signin">Sign in</a></li>
                            <li class="nav-item" style="width: 50%;"><a style="text-align: center;" class="nav-link" data-toggle="tab" href="#signup">Sign up</a></li>
                          </ul>
                        
                          <div class="tab-content">
                            <div id="signin" class="tab-pane fade active show">
                              <div class="card">
                                  <article class="card-body">
                                      <h4 class="card-title text-center mb-4 mt-1">Sign in</h4>
                                      <hr>
                                      <p class="text-success text-center">Some message goes here</p>
                                      <form>
                                      <div class="form-group">
                                      <div class="input-group">
                                          <div class="input-group-prepend" style="margin-right: 6px; margin-top: 4px; ">
                                              <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                           </div>
                                          <input name="" class="form-control" placeholder="Email or login" type="email">
                                      </div> <!-- input-group.// -->
                                      </div> <!-- form-group// -->
                                      <div class="form-group">
                                      <div class="input-group">
                                          <div class="input-group-prepend" style="margin-right: 6px; margin-top: 4px; ">
                                              <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                           </div>
                                          <input class="form-control" placeholder="******" type="password">
                                      </div> <!-- input-group.// -->
                                      </div> <!-- form-group// -->
                                      <div class="form-group">
                                      <button type="submit" class="btn btn-primary btn-block"> Login  </button>
                                      </div> <!-- form-group// -->
                                      <p class="text-center"><a href="#">Forgot password?</a></p>
                                      <div class="text-center" style="margin-top: 10px;">
                                        <a href="#" style="font-size: 20px; margin-right:20px;"><i class="fa fa-google"></i></a>
                                        <a href="#" style="font-size: 20px;"><i class="fa fa-facebook"></i></a>
                                      </div>
                                      </form>
                                  </article>
                              </div>
                            </div>
                            <div id="signup" class="tab-pane fade">
                                <div class="card">
                                    <article class="card-body">
                                        <h4 class="card-title text-center mb-4 mt-1">Sign up</h4>
                                        <hr>
                                        <p class="text-success text-center">Some message goes here</p>
                                        <form>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend" style="margin-right: 6px; margin-top: 4px; ">
                                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                                </div>
                                                <input name="" class="form-control" placeholder="Name" type="text">
                                            </div> <!-- input-group.// -->
                                        </div> <!-- form-group// -->
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend" style="margin-right: 6px; margin-top: 4px; ">
                                                    <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                                                </div>
                                                <input class="form-control" placeholder="Phone number" type="text">
                                            </div> <!-- input-group.// -->
                                        </div> <!-- form-group// -->
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend" style="margin-right: 6px; margin-top: 4px; ">
                                                    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                                </div>
                                                <input class="form-control" placeholder="Email" type="email">
                                            </div> <!-- input-group.// -->
                                        </div> <!-- form-group// -->
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend" style="margin-right: 6px; margin-top: 4px; ">
                                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                                </div>
                                                <input class="form-control" placeholder="******" type="password">
                                            </div> <!-- input-group.// -->
                                        </div> <!-- form-group// -->
                                        <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block"> Sign up  </button>
                                        </div> <!-- form-group// -->
                                        
                                        </form>
                                    </article>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
