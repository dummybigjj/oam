          <section class="tables">
            <div class="container-fluid">
              <div class="row">

                <div class="col-lg-12" style="margin: 0 auto">

                  <!-- <div class="alert alert-warning" role="alert">
                    <i class="fa fa-question-circle-o fa-lg"></i> IMPORTANT NOTE: Editing of this Attendance is only available until "11:59PM of the night"(starting from the class scheduled time), you cannot update attendance table after 11:59PM.
                  </div> -->

                  <div class="alert alert-info" role="alert">
                    <div class="text">
                      <i class="fa fa-info-circle fa-lg"></i>
                      <?php if(!empty($schedules['subject_code'])): ?>
                        <?php echo $schedules['subject_code'].' | '.$schedules['room_name'].' '.$schedules['day'].' '.$this->student_model->transformScheduleRange($schedules['time']); ?>
                        --- <b>P</b> - Present, <b>A</b> - Absent, <b>L</b> - Late, <b>E</b> - Excuse, <b>V</b> - Vacation
                      <?php endif; ?>
                    </div>
                  </div>

                  <!-- <div class="card">
                    <div class="card-close d-flex align-items-center">
                      <div class="dropdown">
                        <div class="btn-group">
                          <input type="submit" name="present" value="Present" disabled="" class="btn btn-success">
                          <input type="submit" name="absent" value=" Absent " disabled="" class="btn btn-danger">
                          <input type="submit" name="late" value=" &nbsp Late &nbsp " disabled="" class="btn btn-warning">
                          <input type="submit" name="excuse" value="Excuse" disabled="" class="btn btn-primary">
                        </div>&nbsp
                        <input type="submit" name="vacation" value="Vacation" disabled="" class="btn btn-success" />
                      </div>
                    </div>
                  </div> -->

                  <?php if($this->session->userdata('designation')=='Administrator' || $this->session->userdata('designation')=='Registrar'): ?>
                    <div class="d-flex p-2">
                      <div class="d-flex align-items-right">
                        <div class="btn-group">
                          <a target="_blank" href="<?php echo site_url('register_students/'.$schedule_id); ?>" class="btn btn-success"><i class="fa fa-plus-square-o"></i> Add Students</a>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>
                  <div class="card">

                    <form action="<?php echo site_url('faculty/faculty_change_student_attendance_status'); ?>" method="post" accept-charset="utf-8">
                    <div class="card-close d-flex align-items-center">
                      <div class="dropdown">
                        
                        <div class="btn-group">
                          <input type="submit" name="present" value="P" disabled="" class="btn btn-success">
                          <input type="submit" name="absent" value="A" disabled="" class="btn btn-danger">
                          <input type="submit" name="late" value="L" disabled="" class="btn btn-warning">
                          <input type="submit" name="excuse" value="E" disabled="" class="btn btn-primary">
                        </div>&nbsp
                        <input type="submit" name="vacation" value="V" disabled="" class="btn btn-success" />
                        <?php if($this->session->userdata('designation')=='Administrator' || $this->session->userdata('designation')=='Registrar'): ?>
                          <input type="submit" name="remove" value="Remove" disabled="" class="btn btn-danger">
                        <?php endif; ?>
                      </div>
                    </div>

                    <div class="card-header d-flex align-items-center">
                      <div class="dropdown">
                        <div class="form-inline">
                          <div class="form-group mb-2 mt-2">
                            <?php if($this->session->userdata('designation')=='Administrator' || $this->session->userdata('designation')=='Registrar'): ?>
                              <label class="form-control-label" for="attendance_date"> &nbsp </label>
                            <?php else: ?>
                              <label class="form-control-label h5" for="attendance_date"> <i class="fa fa-calendar fa-lg"></i> &nbsp<?php echo date('M d - D',strtotime($attend_date)); ?> </label>
                            <?php endif; ?>
                          </div>
                          <div class="form-group mx-sm-0 mb-1" style="outline: ;">
                            <?php if($this->session->userdata('designation')=='Administrator'|| $this->session->userdata('designation')=='Registrar'): ?>
                              <input type="text" name="attendance_date" id="attendance_date" class="form-control <?php echo ($this->session->userdata('designation')=='Registrar' || $this->session->userdata('designation')=='Administrator')?'datetimepicker2':''; ?>" value="<?php echo $attend_date; ?>" />
                            <?php else: ?>
                              <input type="hidden" name="attendance_date" id="attendance_date" class="form-control <?php echo ($this->session->userdata('designation')=='Registrar' || $this->session->userdata('designation')=='Administrator')?'datetimepicker2':''; ?>" value="<?php echo $attend_date; ?>" />
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card-body" style="overflow-y: auto;">
                      <table id="example" class="table table-striped bg-white table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th><input type="checkbox" id="checkAll" class="checkbox-template" /></th>
                            <th>Student No.</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th style="width: 15%">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($students)): ?>
                          <?php $p=0;$a=0;$l=0;$e=0;$v=0; ?>
                          <?php foreach($students as $value): ?>
                              <tr>
                                <td>
                                  <input type="checkbox" class="checkbox-template" name="student_ids[]" value="<?php echo $value['student_id'] ?>" />
                                  <input type="hidden" name="subject" value="<?php echo $value['subject']; ?>" />
                                  <input type="hidden" name="subject_c" value="<?php echo $value['subject_code']; ?>" />
                                  <input type="hidden" name="batch_year" value="<?php echo $value['batch_year']; ?>" />
                                  <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>" />
                                  <input type="hidden" name="schedule_day" value="<?php echo $schedules['day']; ?>" />

                                </td>
                                <td><?php echo $value['student_no']; ?></td>
                                <td><?php echo $value['arabic_name']; ?></td>
                                <th>
                                  <?php if($value['attendance']=='P'): ?>
                                    <?php $p++; ?>
                                    <font style="color: green">Present</font>
                                  <?php elseif($value['attendance']=='A'): ?>
                                    <?php $a++; ?>
                                    <font style="color: red">Absent</font>
                                  <?php elseif($value['attendance']=='L'): ?>
                                    <?php $l++; ?>
                                    <font style="color: yellow">Late</font>
                                  <?php elseif($value['attendance']=='E'): ?>
                                    <?php $e++; ?>
                                    <font style="color: blue">Excuse</font>
                                  <?php elseif($value['attendance']=='V'): ?>
                                    <?php $v++; ?>
                                    <font style="color: blue">Vacation</font>
                                  <?php endif; ?>
                                </th>
                                <td><?php echo $value['attendance_remarks']; ?></td>
                                <td>
                                  <div class="btn-group">
                                    <?php if(!empty($schedules['day']) && $schedules['day']==strtoupper(date('l')) && date('H:i:s') >= $value['time']): ?>
                                      <button type="button" class="btn btn-warning" onclick="edit_attendance(<?php echo $value['student_id'] ?>, <?php echo $value['subject']; ?>, '<?php echo $value['subject_code']; ?>', '<?php echo $value['batch_year']; ?>', '<?php echo date('Y-m-d'); ?>')">&nbsp<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Attendance &nbsp</button>
                                    <?php else: ?>
                                      <div class="alert alert-danger" role="alert" style="margin: 0 auto">
                                        <i class="fa fa-ban fa-lg"></i>
                                      </div>
                                      <?php if($this->session->userdata('designation')=='Registrar' || $this->session->userdata('designation')=='Administrator'): ?>
                                        <button type="button" class="btn btn-warning" onclick="update_attendance(<?php echo $value['student_id'] ?>, <?php echo $value['subject']; ?>, '<?php echo $value['subject_code']; ?>', '<?php echo $value['batch_year']; ?>')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update</button>
                                      <?php endif; ?>
                                    <?php endif; ?>

                                  </div>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th></th>
                            <th>Student No.</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Action</th>
                          </tr>
                          <tr>
                            <th colspan="6">Total Presents: <?php echo $p; ?> --- Total Absents: <?php echo $a; ?> --- Total Lates: <?php echo $l; ?> --- Total Excuses: <?php echo $e; ?> --- Total Vacation: <?php echo $v; ?></th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    </form>

                  </div>
                </div>

              </div>
            </div>
          </section>


<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable({
      "pageLength": 50
    });
  });

  var checkboxes = $("input[type='checkbox']"), submitButt = $("input[type='submit']");
  $("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
  });
  checkboxes.click(function() {
    submitButt.attr("disabled", !checkboxes.is(":checked"));
  });

  // Modal functions
  function edit_attendance(student_id, subject_id, subject_code, batch_year_id, attendance_date){
  $('#formeditAttendance')[0].reset();
  // Set Primary keys
  $('[name="student_id"]').val(student_id);
  $('[name="subject_id"]').val(subject_id);
  $('[name="subject_code"]').val(subject_code);
  $('[name="batch_year_id"]').val(batch_year_id);
  $('[name="attendance_date"]').val(attendance_date);

  //LOAD DATA USING AJAX
  $.ajax({
      url: "<?php echo site_url('faculty/get_student_attendance/') ?>" + student_id + "/" + subject_id + "/" + subject_code + "/" + batch_year_id,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $('[name="status"]').val(data.attendance);
        $('[name="remarks"]').val(data.remarks);
        //SHOW MODAL
        $('#editAttendance').modal('show');
        $('.modal-title').text('Edit Student Attendance');
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('ERROR POPULATING DATA');
      }
  });
}

function update_attendance(student_id, subject_id, subject_code, batch_year_id){
  $('#formupdateAttendance')[0].reset();
  // Set Primary keys
  $('[name="student_id"]').val(student_id);
  $('[name="subject_id"]').val(subject_id);
  $('[name="subject_code"]').val(subject_code);
  $('[name="batch_year_id"]').val(batch_year_id);
  //SHOW MODAL
  $('#updateAttendance').modal('show');
  $('.modal-title').text('Update Old Student Attendance');
}

function save_student_attendance(){
  var url;
  $('#editAttendance').modal('hide');
  url = "<?php echo site_url('faculty/faculty_update_student_attendance')?>";
  //AJAX ADDING DATA TO DATABASE
  $.ajax({
    url : url,
    type: "POST",
    data: $('#formeditAttendance').serialize(),
    dataType: "JSON",
    success: function(data){
       if(data.class_add=='alert alert-success'){
        swal({title: "Good job", text: data.msg, type: "success"},
          function(){location.reload();}
        );
      }
      if(data.class_add=='alert alert-warning'){
        swal({title: "Server Warning", text: data.msg, type: "warning"});
      }
      if(data.class_add=='alert alert-danger'){
        swal({title: "Server Error", text: data.msg, type: "error"});
      }
    },
    error: function (jqXHR, textStatus, errorThrown){
      alert('ERROR UPDATING DATA');
    }
  });
}

function update_old_student_attendance(){
  var url;
  $('#updateAttendance').modal('hide');
  url = "<?php echo site_url('faculty/faculty_update_old_student_attendance')?>";
  //AJAX ADDING DATA TO DATABASE
  $.ajax({
    url : url,
    type: "POST",
    data: $('#formupdateAttendance').serialize(),
    dataType: "JSON",
    success: function(data){
       if(data.class_add=='alert alert-success'){
        swal({title: "Good job", text: data.msg, type: "success"},
          function(){location.reload();}
        );
      }
      if(data.class_add=='alert alert-warning'){
        swal({title: "Server Warning", text: data.msg, type: "warning"});
      }
      if(data.class_add=='alert alert-danger'){
        swal({title: "Server Error", text: data.msg, type: "error"});
      }
    },
    error: function (jqXHR, textStatus, errorThrown){
      alert('ERROR UPDATING DATA');
    }
  });
}

var startTime = $('.datetimepicker2');
$('.datetimepicker2').datetimepicker({
  format:'Y-m-d',
  timepicker:false
});


// DEPRECATED
// function override_update_attendance() {
//   $('#formMassupdateAttendance')[0].reset();
//   //SHOW MODAL
//   $('#MassupdateAttendance').modal('show');
//   $('.modal-title').text('Update Old Student Attendance');
// }

// function override_update_student_attendance() {
//   var url;
//   $('#MassupdateAttendance').modal('hide');
//   url = "<?php //echo site_url('faculty/faculty_override_student_attendance_status')?>";
//   //AJAX ADDING DATA TO DATABASE
//   $.ajax({
//     url : url,
//     type: "POST",
//     data: $('#formMassupdateAttendance').serialize(),
//     dataType: "JSON",
//     success: function(data){
//        if(data.class_add=='alert alert-success'){
//         swal({title: "Good job", text: data.msg, type: "success"},
//           function(){location.reload();}
//         );
//       }
//       if(data.class_add=='alert alert-warning'){
//         swal({title: "Server Warning", text: data.msg, type: "warning"});
//       }
//       if(data.class_add=='alert alert-danger'){
//         swal({title: "Server Error", text: data.msg, type: "error"});
//       }
//     },
//     error: function (jqXHR, textStatus, errorThrown){
//       alert('ERROR UPDATING DATA');
//     }
//   });
// }


</script>