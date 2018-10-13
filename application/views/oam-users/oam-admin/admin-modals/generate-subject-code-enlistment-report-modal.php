    <!-- View History Modal -->
    <div id="GenerateSubjectCodeEnlistmentReport" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <form action="<?php echo site_url('admin/admin_generate_subject_code_enlistment_report'); ?>" id="formGenerateSubjectCodeEnlistmentReport" method="post" accept-charset="utf-8">
            <div class="modal-body">
              <input type="hidden" name="batch_year_id" class="form-control" required="">
              
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font><i class="icon-list-1"></i> Subject Code</div>
                <select name="subject_code" id="subject_code1" required="" class="form-control select_search" style="width: 100%"></select>
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