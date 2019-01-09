    <!-- View History Modal -->
    <div id="editCompany" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formeditCompany">
              <input type="hidden" name="core_item_id" class="form-control" required="">
              <div class="form-group col-lg-12">
                <input class="form-control" name="company_id" type="hidden">
                <div class="control-label" ><font style="color: red">*</font> Company Name</div>
                <input class="form-control" name="company_name" maxlength="100" type="text">
              </div>
            </form>
            
          </div>
          <div class="modal-footer col-md-12">
            <div class="btn-group">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">&nbsp&nbsp Close &nbsp&nbsp</button>
              <button class="btn btn-info" type="button"  onclick="save_company()">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>