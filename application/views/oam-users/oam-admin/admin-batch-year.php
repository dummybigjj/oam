          <section class="forms"> 
            <div class="container-fluid">
              <div class="row">

                <!-- Basic Form-->
                <div class="col-lg-6" style="margin: 0 auto">
                  <div class="card">

                    <div class="card-close">
                      <div class="dropdown">
                      </div>
                    </div>

                    <div class="card-header statistic d-flex align-items-center">
                      <div class="icon bg-green"><i class="fa fa-graduation-cap"></i></div>
                      <div class="text"><small class="h4">Batch Year</small></div>
                    </div>

                    <div class="card-body">

                      <form action="<?php echo site_url('batch_year/update_batch_year_status'); ?>" method="post" accept-charset="utf-8">
                        <div class="form-group col-md-12">
                          <div class="alert alert-primary" role="alert">
                            <i class="fa fa-question-circle-o" aria-hidden="true"></i> Make sure Batch Year is 'Enabled' prior to student registration
                          </div>
                        </div>

                        <div class="form-group col-md-12">
                          <label class="form-control-label"><font style="color: red">*</font> Current Batch Year Opened</label>
                          <input type="text" name="batch_name" readonly="" value="<?php echo $batch_year['batch_name']; ?>" class="form-control" required="">
                        </div>

                        <div class="form-group col-md-12">
                          <label class="form-control-label">Enable/Disable</label><br>
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info <?php echo ($batch_year['is_active']=='TRUE')?'active':''; ?>">
                            <input type="radio" name="batchyear_on_of" value="TRUE" id="option1" autocomplete="off" <?php echo ($batch_year['is_active']==='TRUE')?'checked':''; ?>><i class="fa fa-check"></i> Enable
                            </label>

                            <label class="btn btn-danger <?php echo ($batch_year['is_active']=='FALSE')?'active':''; ?>">
                            <input type="radio" name="batchyear_on_of" value="FALSE" id="option2" autocomplete="off" <?php echo ($batch_year['is_active']=='FALSE')?'checked':''; ?>><i class="icon-close"></i> Disable
                            </label>
                          </div>
                        </div>

                        <div class="line"></div>
                        <div class="line"></div>

                        <div class="form-footer">
                          <div class="form-group col-md-12">
                            <button id="addButton" type="button" class="btn btn-success" onclick="new_batch_year()"><i class="fa fa-plus-square-o"></i> New Batch Year</button>
                            <button type="submit" class="btn btn-primary" style="float: right;"><i class="fa fa-floppy-o"></i> Save</button>
                          </div>
                        </div>
                      </form>

                    </div>

                  </div>
                </div>

              </div>
            </div>
          </section>


<script type="text/javascript">

// Modal functions
function new_batch_year(){
  $('#formNewBatchYear')[0].reset();
  $('#NewBatchYear').modal('show');
  $('.modal-title').text('New Batch Year');
}

function save_batch_year(){
  var url;
  $('#NewBatchYear').modal('hide');
  url = "<?php echo site_url('batch_year/set_batch_year')?>";
  //AJAX ADDING DATA TO DATABASE
  $.ajax({
    url : url,
    type: "POST",
    data: $('#formNewBatchYear').serialize(),
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

function closeModal(){
  location.reload();
}

</script>