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
                          <div class="text"><small class="h5">Generate Attendance and Remarks Reports || <?php echo (!empty($batch_year['batch_name']))?$batch_year['batch_name']:''; ?></small></div>
                        </div>
                      </div>
                    </div>

                    <div class="card-body" style="overflow-y: auto;">
                      <table id="example" class="table table-striped bg-white table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Subject Title</th>
                            <th>Subject Code</th>
                            <th>Room Schedule</th>
                            <th>Schedule Day</th>
                            <th>Schedule Time</th>
                            <th>Attendance Report</th>
                            <th>Remarks Report</th>
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
                                  <button type="button" onclick="generate_subject_code_attendance_report(<?php echo $batch_year['batch_year_id']; ?>,'<?php echo $value['subject_code']; ?>')" class="btn btn-warning"><i class="fa fa-calendar" aria-hidden="true"></i> Attendance</button>
                                </td>
                                <td>
                                  <button type="button" onclick="generate_subject_code_remarks_report(<?php echo $batch_year['batch_year_id']; ?>,'<?php echo $value['subject_code']; ?>')" class="btn btn-danger">&nbsp<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Remarks &nbsp</button>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Subject Title</th>
                            <th>Subject Code</th>
                            <th>Room Schedule</th>
                            <th>Schedule Day</th>
                            <th>Schedule Time</th>
                            <th>Attendance Report</th>
                            <th>Remarks Report</th>
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

function generate_subject_code_attendance_report(id,subject_code) {
  $('#formGenerateSubjectCodeAttendanceReport')[0].reset();
  $('[name="batch_year_id"]').val(id);
  $('[name="subject_code"]').val(subject_code);
  //SHOW MODAL
  $('#GenerateSubjectCodeAttendanceReport').modal('show');
  $('.modal-title').text('Generate Attendance Report');
}

function generate_subject_code_remarks_report(id,subject_code) {
  $('#formGenerateRemarksReport')[0].reset();
  $('[name="batch_year_id"]').val(id);
  $('[name="subject_code"]').val(subject_code);
  //SHOW MODAL
  $('#GenerateRemarksReport').modal('show');
  $('.modal-title').text('Generate Subject Code Remarks Report');
}

</script>