          <section class="tables">   
            <div class="container-fluid">
              <div class="row">

                <div class="col-lg-12" style="margin: 0 auto">

                  <div class="alert alert-primary" role="alert">
                    <div class="statistic d-flex align-items-center no-padding-top no-padding-bottom">
                      <div class="icon bg-blue"><i class="icon-bill" aria-hidden="true"></i></div>
                      <div class="text"><small class="h5" style="color: #111">Opened Schedule For <?php echo $batch_year['batch_name']; ?></small></div>
                    </div>
                  </div>

                  <div class="card">

                    <form action="<?php echo site_url('subject/update_multiple_schedule'); ?>" method="post" accept-charset="utf-8">
                      <div class="card-close d-flex align-items-center">
                        <!-- <input type="submit" name="delete" value="&nbsp Delete &nbsp" disabled="" class="btn btn-danger"> -->
                        <div class="btn-group">
                          <input type="submit" name="assign" class="btn btn-warning" disabled="" value="Assign"/>
                          <input type="submit" name="delete" class="btn btn-danger" disabled="" value="Delete"/>
                        </div>&nbsp
                        <div class="btn-group">
                          <!-- <input type="submit" name="activate" class="btn btn-success" disabled="" value="Activate"/> -->
                          <input type="submit" name="deactivate" class="btn btn-danger" disabled="" value="Deactivate"/>
                        </div>
                      </div>

                      <div class="card-header d-flex align-items-center">
                        <div class="dropdown">
                          <i class="fa fa-table fa-2x" aria-hidden="true"></i>
                        </div>
                      </div>

                      <div class="card-body" style="overflow-y: auto;">
                        <table id="example" class="table table-striped bg-white table-bordered" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th><input type="checkbox" id="checkAll" class="checkbox-template" /></th>
                              <th>Subject Title</th>
                              <th>Subject Code</th>
                              <th>Room</th>
                              <th>Day</th>
                              <th>Time</th>
                              <th>Faculty</th>
                              <?php if($this->session->userdata('designation')!='Program Head'): ?>
                              <th style="width: 10%">Attendance</th>
                              <th style="width: 18%">Action</th>
                              <?php endif; ?>
                            </tr>
                          </thead>
                          <tbody>
                          <?php if(!empty($schedules)): ?>
                            <?php foreach($schedules as $value): ?>
                                <tr>
                                  <td><input type="checkbox" class="checkbox-template" name="schedule_id[]" value="<?php echo $value['schedule_id'] ?>" /></td>
                                  <td><?php echo $value['subject_title']; ?></td>
                                  <td><?php echo $value['subject_code']; ?></td>
                                  <td><?php echo $value['room_name']; ?></td>
                                  <td><?php echo $value['day']; ?></td>
                                  <td><?php echo $this->student_model->transformScheduleRange($value['time']); ?></td>
                                  <td><?php echo $value['u_full_name']; ?></td>
                                  <?php if($this->session->userdata('designation')!='Program Head'): ?>
                                  <td>
                                    <a target="_blank" href="<?php echo site_url('faculty/faculty_attendance/'.$value['schedule_id']); ?>" class="btn btn-warning">&nbsp<i class="fa fa-calendar" aria-hidden="true"></i> Attendance &nbsp</a>
                                  </td>
                                  <td>
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-warning" onclick="assign_faculty(<?php echo $value['schedule_id'];?>)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </button>
                                      <button type="button" class="btn btn-danger" onclick="delete_schedule(<?php echo $value['schedule_id'];?>)"><i class="icon-close" aria-hidden="true"></i> Delete</button>
                                    </div>
                                  </td>
                                  <?php endif; ?>
                                </tr>
                              <?php endforeach; ?>
                          <?php endif; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th></th>
                              <th>Subject Title</th>
                              <th>Subject Code</th>
                              <th>Room</th>
                              <th>Day</th>
                              <th>Time</th>
                              <th>Faculty</th>
                              <?php if($this->session->userdata('designation')!='Program Head'): ?>
                              <th style="width: 10%">Attendance</th>
                              <th>Action</th>
                              <?php endif; ?>
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
  $('#example').DataTable();
});

var checkboxes = $("input[type='checkbox']"), submitButt = $("input[type='submit']");
$("#checkAll").change(function () {
  $("input:checkbox").prop('checked', $(this).prop("checked"));
});
checkboxes.click(function() {
  submitButt.attr("disabled", !checkboxes.is(":checked"));
});

$('.card-body').css( 'display', 'block' );
table.columns.adjust().draw();

// Modal functions

function delete_schedule(id){
  $('#formremoveSchedule')[0].reset();
  $('[name="schedule_id"]').val(id);
  $('#removeSchedule').modal('show');
  $('.modal-title').text('Delete Schedule');
}

function remove_schedule() {
  var url;
  $('#removeSchedule').modal('hide');
  url = "<?php echo site_url('subject/remove_schedule')?>";
  //AJAX ADDING DATA TO DATABASE
  $.ajax({
    url : url,
    type: "POST",
    data: $('#formremoveSchedule').serialize(),
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

function assign_faculty(id){
  $('#formAssignFaculty')[0].reset();                          //RESET FORM ON MODAL
  //LOAD DATA USING AJAX
  $.ajax({
      url: "<?php echo site_url('subject/get_subject_schedule/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $('[name="schedule_id"]').val(data.schedule_id);
        $('[name="subject_id"]').val(data.subject_id);
        $('[name="subject_code"]').val(data.subject_code);
        $('[name="room_id"]').val(data.room_id);
        $('[name="day"]').val(data.day);
        $('[name="time"]').val(data.time);
        $('[name="sched"]').val(data.sched);
        $('[name="faculty_assigned"]').val(data.faculty_assigned);
        //SHOW MODAL
        $('#AssignFaculty').modal('show');
        $('.modal-title').text('Assign Faculty');
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('ERROR POPULATING DATA');
      }
  });
}

function save_schedule(){
  var url;
  $('#AssignFaculty').modal('hide');
  url = "<?php echo site_url('subject/subject_update_schedule_and_faculty')?>";
  //AJAX ADDING DATA TO DATABASE
  $.ajax({
    url : url,
    type: "POST",
    data: $('#formAssignFaculty').serialize(),
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

function closeModal(){
  location.reload();
}

</script>