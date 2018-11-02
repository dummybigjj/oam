          <section class="tables">   
            <div class="container-fluid">
              <div class="row">

                <div class="col-lg-12" style="margin: 0 auto">

                  <div class="alert alert-primary" role="alert">
                    <div class="statistic d-flex align-items-center no-padding-top no-padding-bottom">
                      <div class="icon bg-blue"><i class="icon-bill" aria-hidden="true"></i></div>
                      <div class="text"><small class="h5" style="color: #111">Registered Students for <?php echo $batch_year['batch_name']; ?></small></div>
                    </div>
                  </div>

                  <div class="card">

                    <form action="<?php echo site_url('student/student_remove_enrollment_registration'); ?>" method="post" accept-charset="utf-8">
                      <div class="card-close d-flex align-items-center">
                        <?php if($this->session->userdata('designation')!='Program Head'): ?>
                        <div class="dropdown">
                          <a href="<?php echo site_url('register_students'); ?>" class="btn btn-primary"><i class="fa fa-plus-square-o"></i> Register </a>&nbsp
                          <button type="submit" class="btn btn-danger" disabled="" ><i class="icon-close" aria-hidden="true"></i> Delete </button>
                        </div>
                        <?php endif; ?>
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
                              <th>Stud. No.</th>
                              <th>ES</th>
                              <th>Student Name</th>
                              <th>Subject</th>
                              <th>Subj. Code</th>
                              <th>Hall</th>
                              <th>Day</th>
                              <th>Time</th>
                              <th>Vocational</th>
                              <?php if($this->session->userdata('designation')!='Program Head'): ?>
                              <th style="width: 15%">Action</th>
                              <?php endif; ?>
                            </tr>
                          </thead>
                          <tbody>
                          <?php if(!empty($enrolled)): ?>
                            <?php $ctr = 1; ?>
                            <?php foreach($enrolled as $value): ?>
                                <tr>
                                  <td><input type="checkbox" class="checkbox-template" name="tbl_id[]" value="<?php echo $value['tbl_id'] ?>" /></td>
                                  <td><?php echo $value['student_no']; ?></td>
                                  <td><?php echo $ctr; ?></td>
                                  <td><?php echo $value['arabic_name']; ?></td>
                                  <td><?php echo $value['subject_title']; ?></td>
                                  <td><?php echo $value['subject_code']; ?></td>
                                  <td><?php echo $value['room_name']; ?></td>
                                  <td><?php echo $value['day']; ?></td>
                                  <td><?php echo $this->student_model->transformScheduleRange($value['time']); ?></td>
                                  <td><?php echo $value['voc_program_acronym']; ?></td>
                                  <?php if($this->session->userdata('designation')!='Program Head'): ?>
                                  <td>
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-primary" onclick="view_student_registration(<?php echo $value['tbl_id'];?>)"> <i class="fa fa-eye" aria-hidden="true"></i> </button>
                                      <button type="button" class="btn btn-warning" onclick="edit_student_registration(<?php echo $value['tbl_id'];?>)"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button>
                                      <button type="button" class="btn btn-danger" onclick="remove_student_registration(<?php echo $value['tbl_id'];?>)"> <i class="icon-close" aria-hidden="true"></i> </button>
                                    </div>
                                  </td>
                                  <?php endif; ?>
                                </tr>
                              <?php $ctr++; ?>
                              <?php endforeach; ?>
                          <?php endif; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th></th>
                              <th>Stud. No.</th>
                              <th>ES</th>
                              <th>Student Name</th>
                              <th>Subject</th>
                              <th>Subj. Code</th>
                              <th>Hall</th>
                              <th>Day</th>
                              <th>Time</th>
                              <th>Vocational Program</th>
                              <?php if($this->session->userdata('designation')!='Program Head'): ?>
                              <th>Action</th>
                              <?php endif; ?>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                      
                    </form>

                  </div>
                  <?php if($count>500): ?>
                    <small id="example_paginate" class="form-text text-muted d-flex justify-content-center h6">Use Pagination links below to Navigate Query Results.</small>
                    <div class="dataTables_paginate paging_simple_numbers d-flex justify-content-center" id="example_paginate">
                      <?php echo $links; ?>
                    </div>
                    <?php if(!empty($this->uri->segment(2))): ?>
                      <small id="example_paginate" class="form-text text-muted d-flex justify-content-center">
                        Showing <?php echo $this->uri->segment(2).' to '.($this->uri->segment(2) + 500).' of '.$count.' query results.'; ?>
                      </small>
                    <?php else: ?>
                      <small id="example_paginate" class="form-text text-muted d-flex justify-content-center">
                        Showing <?php echo '1'.' to '.'500'.' of '.$count.' query results.'; ?>
                      </small>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>

              </div>
            </div>
          </section>


<script type="text/javascript">
$(document).ready(function() {
  $('#example').DataTable();
});

var checkboxes = $("input[type='checkbox']"), submitButt = $("button[type='submit']");
$("#checkAll").change(function () {
  $("input:checkbox").prop('checked', $(this).prop("checked"));
});
checkboxes.click(function() {
  submitButt.attr("disabled", !checkboxes.is(":checked"));
});

// Modal functions
function view_student_registration(tbl_id){
  $('#formviewStudentRegistration')[0].reset();                          //RESET FORM ON MODAL
  //LOAD DATA USING AJAX
  $.ajax({
      url: "<?php echo site_url('student/get_student_enrollment_registration_details/') ?>" + tbl_id,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $('[name="student_no"]').val(data.student_no);
        $('[name="arabic_name"]').val(data.arabic_name);
        $('[name="subject_title"]').val(data.subject_title);
        $('[name="subject_code"]').val(data.subject_code);
        $('[name="room_name"]').val(data.room_name);
        $('[name="day"]').val(data.day);
        $('[name="time"]').val(data.time);
        $('[name="voc_program_acronym"]').val(data.voc_program_acronym);
        //SHOW MODAL
        $('#viewStudentRegistration').modal('show');
        $('.modal-title').text('Student Registration');
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('ERROR POPULATING DATA');
      }
  });
}

function edit_student_registration(tbl_id) {
  $('#formeditStudentRegistration')[0].reset();                          //RESET FORM ON MODAL
  //LOAD DATA USING AJAX
  $.ajax({
      url: "<?php echo site_url('student/get_student_enrollment_registration_details/') ?>" + tbl_id,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $('[name="tbl_id"]').val(data.tbl_id);
        $('[name="batch_year"]').val(data.batch_year);
        $('[name="student_id"]').val(data.student_id);
        $('[name="student_no"]').val(data.student_no);
        $('[name="arabic_name"]').val(data.arabic_name);
        $('[name="subject"]').val(data.subject);
        $('[name="subject_code"]').val(data.subject_code);
        $('[name="room"]').val(data.room);
        $('[name="day"]').val(data.day);
        $('[name="time"]').val(data.time);
        $('[name="vocational_program"]').val(data.vocational_program);
        //SHOW MODAL
        $('#editStudentRegistration').modal('show');
        $('.modal-title').text('Edit Student Subject and Schedule');
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('ERROR POPULATING DATA');
      }
  });
}

function update_new_student_schedule() {
  var url;
  $('#editStudentRegistration').modal('hide');
  url = "<?php echo site_url('student/student_update_student_registration_schedule')?>";
  //AJAX ADDING DATA TO DATABASE
  $.ajax({
    url : url,
    type: "POST",
    data: $('#formeditStudentRegistration').serialize(),
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

function remove_student_registration(id){
  $('#formremoveStudentRegistration')[0].reset();
  $('[name="tbl_id"]').val(id);
  $('#removeStudentRegistration').modal('show');
  $('.modal-title').text('Remove Student');
}

function remove_student(){
  var url;
  $('#removeStudentRegistration').modal('hide');
  url = "<?php echo site_url('student/student_remove_registration')?>";
  //AJAX ADDING DATA TO DATABASE
  $.ajax({
    url : url,
    type: "POST",
    data: $('#formremoveStudentRegistration').serialize(),
    dataType: "JSON",
    success: function(data){
      location.reload();
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