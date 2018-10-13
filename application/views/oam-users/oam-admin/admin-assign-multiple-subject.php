        <form action="<?php echo site_url('subject/subject_update_assign_faculty'); ?>" method="post" accept-charset="utf-8">
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
                      <div class="icon bg-red"><i class="fa fa-university"></i></div>
                      <div class="text"><small class="h4">Assign Multiple Subjects to Faculty</small></div>
                    </div>

                    <div class="card-body">

                      <p class="col-md-12">Fields with (<font style="color: red">*</font>) are required.</p>
                      
                      <div class="form-group col-md-12">
                        <div class="form-control-label"><font style="color: red">*</font><i class="icon-user" aria-hidden="true"></i> Assign Faculty</div>
                        <select name="faculty_assigned" required="" class="form-control">
                          <option> </option>
                          <?php if(!empty($faculty)): ?>
                            <?php foreach ($faculty as $value): ?>
                              <option value="<?php echo $value['user_id'] ?>"><?php echo $value['u_full_name']; ?></option>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </select>
                      </div>

                      <div class="line"></div>

                      <div class="form-footer">
                        <div class="form-group col-md-12">  
                          <button type="submit" class="btn btn-primary" style="float: right;"><i class="fa fa-floppy-o"></i> Save</button>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>

              </div>
            </div>
          </section>

          <section class="forms"> 
            <div class="container-fluid">
              <div class="row">

                <?php if(!empty($schedules)): ?>
                  <?php for ($i=0; $i < count($schedules); $i++): ?>
                    <div class="col-lg-6">
                      <div class="card">

                        <div class="card-close">
                          <div class="dropdown">
                          </div>
                        </div>

                        <div class="card-header statistic d-flex align-items-center">
                          <div class="icon bg-red"><i class="fa fa-calendar"></i></div>
                          <div class="text"><small class="h4">Schedule <?php echo $i+1; ?> Information</small></div>
                        </div>

                        <div class="card-body">
                          <div class="form-group col-md-12">
                            <input type="hidden" name="schedule_id[]" value="<?php echo $schedules[$i]['schedule_id']; ?>" class="form-control" required="">
                            <div class="form-control-label"><font style="color: red">*</font> Subject Title</div>
                            <input type="text" name="subject_title[]" value="<?php echo $schedules[$i]['subject_title']; ?>" readonly="" class="form-control" required="">
                            <div class="form-control-label"><font style="color: red">*</font> Subject Code</div>
                            <input type="text" name="subject_code[]" value="<?php echo $schedules[$i]['subject_code']; ?>" readonly="" class="form-control" required="">
                            <div class="form-control-label"><font style="color: red">*</font> Room Name</div>
                            <input type="text" name="room_name[]" value="<?php echo $schedules[$i]['room_name']; ?>" readonly="" class="form-control" required="">
                            <div class="form-control-label"><font style="color: red">*</font> Schedule Day</div>
                            <input type="text" name="day[]" value="<?php echo $schedules[$i]['day']; ?>" readonly="" class="form-control" required="">
                            <div class="form-control-label"><font style="color: red">*</font> Schedule Time</div>
                            <input type="hidden" name="time[]" value="<?php echo $schedules[$i]['time']; ?>" readonly="" class="form-control" required="">
                            <input type="text" name="sched" value="<?php echo $this->student_model->transformScheduleRange($schedules[$i]['time']) ?>" readonly="" class="form-control" required="">
                          </div>
                        </div>

                      </div>
                    </div>
                  <?php endfor; ?>
                <?php endif; ?>

              </div>
            </div>
          </section>
        </form>