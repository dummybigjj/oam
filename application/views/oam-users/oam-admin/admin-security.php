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
                      
                        <div class="icon bg-green"><i class="fa fa-lock"></i></div>
                        <div class="text"><small class="h4">Login Security Config</small></div>
                      
                    </div>

                    <div class="card-body">
                      <p class="col-md-12">Fields with (<small style="color: red">*</small>) are required.</p>

                      <form action="<?php echo site_url('admin/admin_update_security_config'); ?>" method="post" accept-charset="utf-8">
                        <div class="form-group col-md-12">
                          <label class="form-control-label"><small style="color: red">*</small> Maximum Login Attempt</label>
                          <input type="text" name="login_attempt" required="" maxlength="1" onkeypress="validate(event)" value="<?php echo $config['max_login_attempt']; ?>" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                          <label class="form-control-label"><small style="color: red">*</small> Soft Lock Time (seconds)</label>
                          <input type="text" name="soft_lock" required="" maxlength="3" onkeypress="validate(event)" value="<?php echo $config['soft_lock']; ?>" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                          <label class="form-control-label"><small style="color: red">*</small> Maximum Password Age (days)</label>
                          <input type="text" name="password_age" required="" maxlength="3" onkeypress="validate(event)" value="<?php echo $config['max_password_age']; ?>" class="form-control">
                        </div>

                        <div class="line"></div>
                        <div class="form-group col-md-12">
                          <label class="form-control-label"><i class="fa fa-history"></i> History Logs</label><br>
                          <small class="form-control-label"><i class="fa fa-clock-o"></i> Modified: <?php echo $config['modified']; ?></small><br>
                          <small class="form-control-label"><i class="fa fa-user"></i> Updated by: <?php echo $config['u_full_name'].' - '.$config['designation']; ?></small>
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