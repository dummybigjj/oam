<section class="forms"> 
            <div class="container-fluid">
              <div class="row">

                <!-- Basic Form-->
                <div class="col-lg-6" style="margin: 0 auto">
                  <div class="card">

                    <div class="card-close">
                      <div class="dropdown">
                      </div>
                    </div>

                    <div class="card-header statistic d-flex align-items-center">
                      
                        <div class="icon bg-green"><i class="fa fa-user"></i></div>
                        <div class="text"><small class="h4"> User Information</small></div>
                      
                    </div>

                    <div class="card-body">
                      <p class="col-md-12">Fields with (<small style="color: red">*</small>) are required.</p>

                      <form action="<?php echo site_url('user/user_update_profile'); ?>" method="post" accept-charset="utf-8">
                        <div class="form-group col-md-12">
                          <label class="form-control-label"><small style="color: red">*</small> Fullname</label>
                          <input type="text" name="name" maxlength="60" value="<?php echo $this->session->userdata('u_full_name'); ?>" required="" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                          <label class="form-control-label"><small style="color: red">*</small> Email</label>
                          <input type="email" name="email" maxlength="60" value="<?php echo $this->session->userdata('email'); ?>" required=""  class="form-control">
                        </div>

                        <div class="line"></div>
                        <p class="col-md-12">Change Password <i class="fa fa-question-circle-o"></i></p>

                        <div class="form-group col-md-12">       
                          <label class="form-control-label">New Password</label>
                          <input type="password" name="password1" placeholder="Password" class="form-control">
                        </div>

                        <div class="line"></div>
                        <div class="form-group col-md-12">
                          <label class="form-control-label"><i class="fa fa-history"></i> Security History </label><br>
                          <small class="form-control-label"><i class="fa fa-clock-o"></i> Recent Login: <?php echo $this->session->userdata('recent_login'); ?></small><br>
                          <small class="form-control-label"><i class="fa fa-lock"></i> Password Reset: <?php echo $this->session->userdata('password_reset_date'); ?></small>
                        </div>

                        <div class="line"></div>
                        <div class="form-footer">
                          <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary" style="float: right;"><i class="fa fa-floppy-o"></i> Save</button>
                          </div>
                        </div>
                      </form>

                    </div>

                  </div>
                </div>

              </div>
            </div>
          </section>