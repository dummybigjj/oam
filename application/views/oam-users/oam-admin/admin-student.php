          <section class="tables">   
            <div class="container-fluid">
              <div class="row">

                <div class="col-lg-12" style="margin: 0 auto">
                  <div class="card">

                    <form action="<?php echo site_url('student/student_activate_deactivate'); ?>" method="post" accept-charset="utf-8">
                    <div class="card-close d-flex align-items-center">
                      <?php if($this->session->userdata('designation')!='Program Head'): ?>
                      <div class="btn-group">
                        <input type="submit" name="activate" value="Activate" disabled="" class="btn btn-success">
                        <input type="submit" name="deactivate" value="Deactivate" disabled="" class="btn btn-danger">
                      </div>
                      <?php endif; ?>
                    </div>

                    <div class="card-header d-flex align-items-center">
                      <?php if($this->session->userdata('designation')!='Program Head'): ?>
                      <div class="dropdown">
                        <a href="<?php echo site_url('student_registration'); ?>" class="btn btn-primary"><i class="fa fa-plus-square-o"></i> Add </a>
                        <button type="button" class="btn btn-warning" onclick="import_student()"> <i class="fa fa-upload" aria-hidden="true"></i> Import </button>
                      </div>
                      <?php else: ?>
                        <div class="dropdown">
                          <p class="h4">Students Table</p>
                        </div>
                      <?php endif; ?>
                    </div>

                    <div class="card-body" style="overflow-y: auto;">
                      <table id="example" class="table table-striped bg-white table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <?php if($this->session->userdata('designation')!='Program Head'): ?>
                            <th><input type="checkbox" id="checkAll" class="checkbox-template" /></th>
                            <?php endif; ?>
                            <th>Active</th>
                            <th>Student No.</th>
                            <th>English Name</th>
                            <th>Arabic Name</th>
                            <?php if($this->session->userdata('designation')!='Program Head'): ?>
                            <th>Action</th>
                            <?php endif; ?>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($students)): ?>
                          <?php foreach($students as $value): ?>
                              <tr>
                                <?php if($this->session->userdata('designation')!='Program Head'): ?>
                                <td><input type="checkbox" class="checkbox-template" name="student_id[]" value="<?php echo $value['student_id'] ?>" /></td>
                                <?php endif; ?>
                                <td><?php echo ($value['status']=='1')?'TRUE':'FALSE'; ?></td>
                                <td><?php echo $value['student_no']; ?></td>
                                <td><?php echo $value['english_name']; ?></td>
                                <td><?php echo $value['arabic_name']; ?></td>
                                <?php if($this->session->userdata('designation')!='Program Head'): ?>
                                <td>
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-primary" onclick="view_student(<?php echo $value['student_id'];?>)"> <i class="fa fa-eye" aria-hidden="true"></i> </button>
                                    <button type="button" class="btn btn-warning" onclick="edit_student(<?php echo $value['student_id'];?>)"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button>
                                    <button type="button" class="btn btn-danger" onclick="delete_student(<?php echo $value['student_id'];?>)"> <i class="icon-close" aria-hidden="true"></i> </button>
                                  </div>
                                </td>
                                <?php endif; ?>
                              </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <?php if($this->session->userdata('designation')!='Program Head'): ?>
                            <th></th>
                            <?php endif; ?>
                            <th>Active</th>
                            <th>Student No.</th>
                            <th>English Name</th>
                            <th>Arabic Name</th>
                            <?php if($this->session->userdata('designation')!='Program Head'): ?>
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

// Modal functions
function import_student() {
  $('#formimportStudents')[0].reset();
  //SHOW MODAL
  $('#importStudents').modal('show');
  $('.modal-title').text('Import Students');
}
 
// view student info using modal
function view_student(id){
  $('#formviewStudent')[0].reset();
  //LOAD DATA USING AJAX
  $.ajax({
      url: "<?php echo site_url('student/get_student/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $('[name="student_no"]').val(data.student_no);
        $('[name="national_id"]').val(data.national_id);
        $('[name="email_address"]').val(data.email_address);
        $('[name="mobile_no"]').val(data.mobile_no);
        $('[name="english_name"]').val(data.english_name);
        $('[name="arabic_name"]').val(data.arabic_name);
        $('[name="nationality"]').val(data.nationality);
        $('[name="sign_contract"]').val(data.sign_contract);
        $('[name="remarks"]').val(data.remarks);
        // $('[name="batch_year_enrolled"]').val(data.batch_year_enrolled);
        $('[name="created_by"]').val(data.created_by);
        $('[name="updated_by"]').val(data.updated_by);
        $('[name="created"]').val(data.created);
        $('[name="modified"]').val(data.modified);
        //SHOW MODAL
        $('#viewStudent').modal('show');
        $('.modal-title').text('Student Information');
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('ERROR POPULATING DATA');
      }
  });
}

function edit_student(id){
  $('#formeditStudent')[0].reset();
  //LOAD DATA USING AJAX
  $.ajax({
      url: "<?php echo site_url('student/get_student/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $('[name="student_id"]').val(data.student_id);
        $('[name="student_no"]').val(data.student_no);
        $('[name="national_id"]').val(data.national_id);
        $('[name="email_address"]').val(data.email_address);
        $('[name="mobile_no"]').val(data.mobile_no);
        $('[name="english_name"]').val(data.english_name);
        $('[name="arabic_name"]').val(data.arabic_name);
        $('[name="nationality"]').val(data.nationality);
        $('[name="sign_contract"]').val(data.sign_contract);
        $('[name="remarks"]').val(data.remarks);
        //SHOW MODAL
        $('#editStudent').modal('show');
        $('.modal-title').text('Update Student Information');
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('ERROR POPULATING DATA');
      }
  });
}

function save_student(){
  var url;
  $('#editStudent').modal('hide');
  url = "<?php echo site_url('student/student_update')?>";
  //AJAX ADDING DATA TO DATABASE
  $.ajax({
    url : url,
    type: "POST",
    data: $('#formeditStudent').serialize(),
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

function delete_student(id){
  $('#formremoveStudentRegistration')[0].reset();
  $('[name="student_id"]').val(id);
  $('#removeStudentRegistration').modal('show');
  $('.modal-title').text('Remove Student');
}

function remove_student() {
  var url;
  $('#removeStudentRegistration').modal('hide');
  url = "<?php echo site_url('student/student_delete_permanently')?>";
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

</script>