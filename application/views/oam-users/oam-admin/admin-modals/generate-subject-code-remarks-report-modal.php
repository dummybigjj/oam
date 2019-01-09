    <!-- View History Modal -->
    <div id="GenerateRemarksReport" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <form action="<?php echo site_url('admin/generate_subject_code_remarks_report'); ?>" id="formGenerateRemarksReport" method="post" accept-charset="utf-8">
            <div class="modal-body">
              <input type="hidden" name="batch_year_id" class="form-control" required="">
              
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Subject Code</div>
                <select name="subject_code" id="subject_code2" required="" class="form-control select_search" style="width: 100%"></select>
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label">Company (Optional)</div>
                <select name="company" class="form-control">
                  <option value=""></option>
                  <?php if(!empty($company)): ?>
                    <?php foreach ($company as $value): ?>
                      <option value="<?php echo $value['company_name']; ?>"><?php echo $value['company_name']; ?></option>
                    <?php endforeach; ?>
                  <?php endif ?>
                </select>
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="fa fa-calendar"></i> Date Range</div>
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> From</div>
                <input type="text" name="date_range1" class="form-control datetimepicker1" required="" autocomplete="off">
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> To</div>
                <input type="text" name="date_range2" class="form-control datetimepicker1" required="" autocomplete="off">
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

<script type="text/javascript">
 
var startTime = $('.datetimepicker1');
$('.datetimepicker1').datetimepicker({
  format:'Y-m-d',
  timepicker:false
});
$( ".select_search" ).select2({
  width: 'resolve',
  theme: "classic"
});
</script>