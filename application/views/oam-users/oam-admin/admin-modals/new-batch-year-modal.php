    <!-- View History Modal -->
    <div id="NewBatchYear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formNewBatchYear">
              <div class="form-group col-md-12">
                <div class="alert alert-primary" role="alert">
                  <i class="fa fa-question-circle-o" aria-hidden="true"></i> Batch Year should be opened and properly set prior to registration of student.
                </div>
              </div>
              <div class="form-group col-md-12">
                <label class="form-control-label"><font style="color: red">*</font> Batch Name</label>
                <input type="text" readonly="" name="batch_name" value="<?php echo 'Batch '.date('Y F Y'); ?>" class="form-control" required="">
              </div>
            </form>
            
          </div>
          <div class="modal-footer col-md-12">
            <div class="btn-group">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">&nbsp&nbsp Close &nbsp&nbsp</button>
              <button type="submit" onclick="save_batch_year()" class="btn btn-success">&nbsp&nbsp Save &nbsp&nbsp</button>
            </div>
          </div>
        </div>
      </div>
    </div>