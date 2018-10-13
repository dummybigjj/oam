          <section class="tables">   
            <div class="container-fluid">
              <div class="row">

                <div class="col-lg-12" style="margin: 0 auto">
                  <div class="card">

                    <div class="card-close d-flex align-items-center">
                    </div>

                    <div class="card-header d-flex align-items-center">
                      <div class="dropdown">
                        <div class="statistic d-flex align-items-center no-padding-top no-padding-bottom">
                          <div class="icon bg-green"><i class="icon-bill" aria-hidden="true"></i></div>
                          <div class="text"><small class="h5">Assinged Subject || <?php echo (!empty($batch_year['batch_name']))?$batch_year['batch_name']:''; ?></small></div>
                        </div>
                      </div>
                    </div>

                    <div class="card-body" style="overflow-y: auto;">
                      <table id="example" class="table table-striped bg-white table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Subject Title</th>
                            <th>Subject Code</th>
                            <th>Room</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th style="width: 15%">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($schedules)): ?>
                          <?php foreach($schedules as $value): ?>
                              <tr style="margin: 0">
                                <td><?php echo $value['subject_title']; ?></td>
                                <td><?php echo $value['subject_code']; ?></td>
                                <td><?php echo $value['room_name']; ?></td>
                                <td><?php echo $value['day']; ?></td>
                                <td><?php echo $this->student_model->transformScheduleRange($value['time']); ?></td>
                                <td>
                                  
                                  <a href="<?php echo site_url('faculty/faculty_attendance/'.$value['schedule_id']); ?>" class="btn btn-warning">&nbsp<i class="fa fa-calendar" aria-hidden="true"></i> Attendance &nbsp</a>
                                  
                                </td>
                              </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Subject Title</th>
                            <th>Subject Code</th>
                            <th>Room</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Action</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>

                  </div>
                </div>

              </div>
            </div>
          </section>


<script type="text/javascript">
$(document).ready(function() {
  $('#example').DataTable();
});
</script>