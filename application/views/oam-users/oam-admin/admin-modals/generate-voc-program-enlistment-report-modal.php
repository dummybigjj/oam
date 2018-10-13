    <!-- View History Modal -->
    <div id="GenerateVocProgramEnlistmentReport" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <form action="<?php echo site_url('admin/admin_generate_voc_program_enlistment_report'); ?>" id="formGenerateVocProgramEnlistmentReport" method="post" accept-charset="utf-8">
            <div class="modal-body">
              <input type="hidden" name="batch_year_id" class="form-control" required="">
              
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font><i class="icon-bill"></i> Vocational Program</div>
                <select name="vocational_program" required="" class="form-control select_search" style="width: 100%">                  
                  <?php if(!empty($voc_program)): ?>
                    <?php foreach ($voc_program as $value): ?>
                      <option value="<?php echo $value['voc_program_id'] ?>"><?php echo $value['voc_program_acronym']; ?></option>
                    <?php endforeach ?>
                  <?php endif; ?>
                </select>
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