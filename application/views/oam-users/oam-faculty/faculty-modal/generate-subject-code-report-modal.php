    <!-- View History Modal -->
    <div id="GenerateSubjectCodeAttendanceReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <form action="<?php echo site_url('admin/generate_subject_code_attendance_report'); ?>" id="formGenerateSubjectCodeAttendanceReport" method="post" accept-charset="utf-8">
            <div class="modal-body">
              <input type="hidden" name="batch_year_id" class="form-control" required="">
              
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Subject Code</div>
                <input type="text" name="subject_code" class="form-control" readonly="" required="">
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="fa fa-calendar"></i> Date Range</div>
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> From</div>
                <input type="text" name="date_range1" class="form-control datetimepicker3" required="" autocomplete="off">
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> To</div>
                <input type="text" name="date_range2" class="form-control datetimepicker4" required="" autocomplete="off">
              </div>

            </div>
            <div class="modal-footer col-md-12">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">&nbsp&nbsp Close &nbsp&nbsp</button>
              <div class="btn-group">
                <input type="submit" name="export_csv" value="&nbsp&nbsp CSV &nbsp&nbsp" class="btn btn-success" />
                <!-- <input type="submit" name="export_pdf" value="&nbsp&nbsp PDF &nbsp&nbsp" class="btn btn-danger" /> -->
              </div>
            </div>

          </form>

        </div>
      </div>
    </div>