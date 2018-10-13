          <section class="tables">   
            <div class="container-fluid">
              <div class="row">

                <div class="col-lg-12" style="margin: 0 auto">
                  <div class="card">

                    <div class="card-close d-flex align-items-center"></div>

                    <div class="card-header d-flex align-items-center">
                      <div class="dropdown"> 
                        <div class="statistic d-flex align-items-center no-padding-top no-padding-bottom">
                          <div class="icon bg-red"><i class="fa fa-table" aria-hidden="true"></i></div>
                          <div class="text"><small class="h5">Opened Batch Year's</small></div>
                        </div>
                      </div>
                    </div>

                    <div class="card-body" style="overflow-y: auto;">
                      <table id="example" class="table table-striped bg-white table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>                            
                            <th>Batch Name</th>
                            <th>Attendance Report</th>
                            <th>Attendance Report</th>
                            <th>Enlistment Report</th>
                            <th>Enlistment Report</th>
                            <th>Remarks Report</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($batch_year)): ?>
                          <?php foreach($batch_year as $value): ?>
                              <tr>
                                <td><?php echo $value['batch_name']; ?></td>
                                <td>
                                  <?php if($this->session->userdata('designation')!='Program Head'): ?>
                                    <button type="button" class="btn btn-info" onclick="generate_voc_program_attendance_report(<?php echo $value['batch_year_id'];?>)"> <i class="icon-bill" aria-hidden="true"></i> Voc. Program </button>
                                  <?php else: ?>
                                  <div class="alert alert-danger" role="alert" style="margin: 0 auto">
                                    <i class="fa fa-ban fa-lg"></i>
                                  </div>
                                  <?php endif; ?>
                                </td>
                                <td>
                                  <?php if($this->session->userdata('designation')!='Program Head'): ?>
                                    <button type="button" class="btn btn-info" onclick="generate_subject_code_attendance_report(<?php echo $value['batch_year_id'];?>)"> <i class="icon-bill" aria-hidden="true"></i> Subject Code </button>
                                  <?php else: ?>
                                  <div class="alert alert-danger" role="alert" style="margin: 0 auto">
                                    <i class="fa fa-ban fa-lg"></i>
                                  </div>
                                  <?php endif; ?>
                                </td>
                                <td>
                                  <?php if($this->session->userdata('designation')!='Program Head'): ?>                                  
                                    <button type="button" class="btn btn-warning" onclick="generate_voc_program_enlistment_report(<?php echo $value['batch_year_id'];?>)"> <i class="icon-list" aria-hidden="true"></i> Voc. Program </button>
                                  <?php else: ?>
                                    <div class="alert alert-danger" role="alert" style="margin: 0 auto">
                                      <i class="fa fa-ban fa-lg"></i>
                                    </div>
                                  <?php endif; ?>
                                </td>
                                <td>
                                  <?php if($this->session->userdata('designation')!='Program Head'): ?>
                                    <button type="button" class="btn btn-warning" onclick="generate_subject_code_enlistment_report(<?php echo $value['batch_year_id'];?>)"> <i class="icon-list" aria-hidden="true"></i> Subject Code </button>
                                  <?php else: ?>
                                    <div class="alert alert-danger" role="alert" style="margin: 0 auto">
                                      <i class="fa fa-ban fa-lg"></i>
                                    </div>
                                  <?php endif; ?>
                                </td>
                                <td>
                                  <?php if($this->session->userdata('designation')!='Program Head'): ?>
                                    <button type="button" class="btn btn-danger" onclick="generate_subject_code_remarks_report(<?php echo $value['batch_year_id'];?>)"> <i class="icon-list" aria-hidden="true"></i> Subject Code </button>
                                  <?php else: ?>
                                    <div class="alert alert-danger" role="alert" style="margin: 0 auto">
                                      <i class="fa fa-ban fa-lg"></i>
                                    </div>
                                  <?php endif; ?>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Batch Name</th>
                            <th>Attendance Report</th>
                            <th>Attendance Report</th>
                            <th>Enlistment Report</th>
                            <th>Enlistment Report</th>
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

// Modal functions
function generate_voc_program_attendance_report(id){
  $('#formGenerateVocProgramAttendanceReport')[0].reset();
  $('[name="batch_year_id"]').val(id);
  $('#GenerateVocProgramAttendanceReport').modal('show');
  $('.modal-title').text('Generate Vocational Program Attendance Report');
}

function generate_voc_program_enlistment_report(id){
  $('#formGenerateVocProgramEnlistmentReport')[0].reset();
  $('[name="batch_year_id"]').val(id);
  $('#GenerateVocProgramEnlistmentReport').modal('show');
  $('.modal-title').text('Generate Vocational Program Enlistment Report');
}

function generate_subject_code_remarks_report(id) {
  $('#formGenerateRemarksReport')[0].reset();
  $('[name="batch_year_id"]').val(id);
  // LOAD DATA USING AJAX
  $.ajax({
      url: "<?php echo site_url('subject/get_batch_year_subject_code/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $.each(data, function (i, item) {
          $('#subject_code2').append($('<option>', { 
              value: item.subject_code,
              text : item.subject_code 
          }));
        });
        //SHOW MODAL
        $('#GenerateRemarksReport').modal('show');
        $('.modal-title').text('Generate Subject Code Remarks Report');
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('ERROR POPULATING DATA');
      }
  });
}

function generate_subject_code_attendance_report(id) {
  $('#formGenerateSubjectCodeAttendanceReport')[0].reset();
  $('[name="batch_year_id"]').val(id);
  // LOAD DATA USING AJAX
  $.ajax({
      url: "<?php echo site_url('subject/get_batch_year_subject_code/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $.each(data, function (i, item) {
          $('#subject_code').append($('<option>', { 
              value: item.subject_code,
              text : item.subject_code 
          }));
        });
        //SHOW MODAL
        $('#GenerateSubjectCodeAttendanceReport').modal('show');
        $('.modal-title').text('Generate Subject Code Attendance Report');
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('ERROR POPULATING DATA');
      }
  });
}

function generate_subject_code_enlistment_report(id) {
  $('#formGenerateSubjectCodeEnlistmentReport')[0].reset();
  $('[name="batch_year_id"]').val(id);
  // LOAD DATA USING AJAX
  $.ajax({
      url: "<?php echo site_url('subject/get_batch_year_subject_code/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $.each(data, function (i, item) {
          $('#subject_code1').append($('<option>', { 
              value: item.subject_code,
              text : item.subject_code 
          }));
        });
        //SHOW MODAL
        $('#GenerateSubjectCodeEnlistmentReport').modal('show');
        $('.modal-title').text('Generate Subject Code Enlistment Report');
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('ERROR POPULATING DATA');
      }
  });
}

</script>