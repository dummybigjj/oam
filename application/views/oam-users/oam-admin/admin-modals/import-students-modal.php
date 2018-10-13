    <!-- Edit Vocational Program Modal -->
    <div id="importStudents" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formimportStudents" method="post" action="<?php echo site_url('student/import_students'); ?>" enctype="multipart/form-data">
              
              <div class="form-group col-md-12">
                <label for="exampleFormControlFile1"><font style="color: red">*</font> Import Students</label>
                <input type="file" name="file" class="form-control-file" aria-describedby="Help" id="exampleFormControlFile1" required accept=".xls, .xlsx">
                <small id="Help" class="form-text text-muted">
                  Accepted File formats are .xls or .xlsx<br>
                  Put "Student Number" at column "A"<br> Put "English Name" at column "B"<br> Put "Arabic Name" at column "C".<br>Data should start at row 2
                </small>
              </div>
            
              <div class="modal-footer col-md-12">
                <div class="btn-group">
                  <button type="button" data-dismiss="modal" class="btn btn-secondary">&nbsp&nbsp Close &nbsp&nbsp</button>
                  <button type="submit" class="btn btn-success">&nbsp&nbsp Save &nbsp&nbsp</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>