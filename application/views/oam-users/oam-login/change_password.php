          <section class="dashboard-counts no-padding-bottom no-padding-top" style="width: 80%;margin: 0 auto">
            <div class="container-fluid">
              <div class="row">
                
                  <!-- Item -->
                  <div class="col-xl-5 col-sm-5" style="margin: 0 auto;">
                    <div class="item d-flex align-items-center">
                      <i class="fa fa-calendar fa-5x" style="color: #4caf50"></i>
                      <div class="title">
                        <span style="font-size: 36px">eAttendace</span><br><small> Attendance Monitoring System </small>
                      </div>
                    </div>
                  </div>

              </div>
            </div>
          </section>

          <!-- Dashboard Counts Section-->
          <section class="forms no-padding-top">
            <div class="container-fluid">
              <div class="row">
                
                  <!-- Basic Form-->
                <div class="col-lg-5" style="margin: 0 auto">
                  <div class="card">

                    <div class="card-close">
                      <div class="dropdown">
                      </div>
                    </div>

                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Change Password</h3>
                    </div>

                    <div class="card-body">
                      <div class="statistic d-flex align-items-center no-padding-top">
                        <div class="icon bg-red" style="margin: 0 auto"><i class="fa fa-lock"></i></div>
                      </div>

                      <form action="<?php echo site_url('user/user_cp'); ?>" method="post" accept-charset="utf-8">
                        <div class="form-group col-md-12">
                          <label class="form-control-label"><font style="color: red">*</font> New Password</label>
                          <input type="password" name="password1" maxlength="100" required="" placeholder="New Password" class="form-control">
                        </div>
                        <div class="form-group col-md-12">       
                          <label class="form-control-label"><font style="color: red">*</font> Confirm Password</label>
                          <input type="password" name="password2" maxlength="100" required="" placeholder="Confirm Password" class="form-control">
                        </div>
                        <div class="form-group col-md-12">       
                          <input type="submit" value="Submit" class="btn btn-primary">
                        </div>
                      </form>
                    </div>

                  </div>
                </div>

              </div>
            </div>
          </section>