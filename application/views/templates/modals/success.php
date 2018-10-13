<!-- Success Modal-->
    <div id="success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Message</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          <form id="formSuccess">
            <input type="hidden" value="" name="id">
            <div class="modal-body">
              <div id="msg_alert" class="">
                <i class="fa fa-question-circle-o" aria-hidden="true"></i>&nbsp <strong id="msg"></strong>
              </div>
            </div>
          </form>
          <div class="modal-footer">
            <button type="button" onclick="closeModal()" class="btn btn-secondary">Close</button>
          </div>
        </div>
      </div>
    </div>