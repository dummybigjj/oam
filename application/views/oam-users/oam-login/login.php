        
          <!-- Dashboard Counts Section-->
          <section class="page forms dashboard-counts">
            <div class="container d-flex align-items-center">
              <div class="container-fluid">

                <!-- Item -->
                <div class="col-xl-5 col-sm-6" style="margin: 0 auto;outline-style:; ;">
                  <div class="item d-flex align-items-center" style="outline-style: ;">
                    <i class="fa fa-calendar fa-5x" style="color: #4caf50;margin: 0 auto;margin-right: 0px"></i>
                    <div class="title" style="outline-style: ;margin-right: 50px">
                      <span style="font-size: 36px">eAttendance</span><br><small> Attendance Monitoring System </small>
                    </div>
                  </div>
                </div>

                <div class="row">
                  
                    <!-- Basic Form-->
                  <div class="col-lg-6" style="margin: 0 auto">
                    <div class="card">

                      <div class="card-close">
                        <div class="dropdown">
                        </div>
                      </div>

                      <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Login Form</h3>
                      </div>

                      <div class="card-body">
                        <div class="statistic d-flex align-items-center no-padding-top">
                          <div class="icon bg-red"><i class="fa fa-lock"></i></div>
                          <div class="text"><small class="h5">Enter Your Login Credentials</small></div>
                        </div>

                        <form action="<?php echo site_url('user/user_resolve_login'); ?>" method="post" accept-charset="utf-8">
                          <div class="form-group col-md-12">
                            <label class="form-control-label"><font style="color: red">*</font> Email</label>
                            <input type="email" name="email" maxlength="100" required="" placeholder="Email" class="form-control" autocomplete="off">
                          </div>
                          <div class="form-group col-md-12">       
                            <label class="form-control-label"><font style="color: red">*</font> Password</label>
                            <input type="password" name="password" maxlength="100" required="" placeholder="Password" class="form-control">
                          </div>
                          <div class="form-group col-md-12">       
                            <input type="submit" value="Signin" class="btn btn-primary">
                          </div>
                        </form>
                      </div>

                    </div>
                  </div>

                </div>
              </div>
            </div>
          </section>