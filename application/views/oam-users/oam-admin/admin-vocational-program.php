          <section class="tables">   
            <div class="container-fluid">
              <div class="row">

                <div class="col-lg-12" style="margin: 0 auto">
                  <div class="card">

                    <form action="<?php echo site_url('vocational_program/vocational_program_activate_deactivate'); ?>" method="post" accept-charset="utf-8">
                    <div class="card-close d-flex align-items-center">
                      <div class="btn-group">
                        <input type="submit" name="activate" value="&nbsp Activate &nbsp" disabled="" class="btn btn-success">
                        <input type="submit" name="deactivate" value=" Deactivate " disabled="" class="btn btn-danger">
                      </div>
                    </div>

                    <div class="card-header d-flex align-items-center">
                      <div class="dropdown">
                        <a href="<?php echo site_url('vocational_program_create'); ?>" class="btn btn-primary"><i class="fa fa-plus-square-o"></i> New Vocational Program </a>
                      </div>
                    </div>

                    <div class="card-body" style="overflow-y: auto;">
                      <table id="example" class="table table-striped bg-white table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th><input type="checkbox" id="checkAll" class="checkbox-template" /></th>
                            <th>Active</th>
                            <th>Voc. Acronym</th>
                            <th>Voc. Name</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Created</th>
                            <th>Modified</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($voc_program)): ?>
                          <?php foreach($voc_program as $value): ?>
                              <tr>
                                <td><input type="checkbox" class="checkbox-template" name="voc_program_id[]" value="<?php echo $value['voc_program_id'] ?>" /></td>
                                <td><?php echo ($value['status']=='1')?'TRUE':'FALSE'; ?></td>
                                <td><?php echo $value['voc_program_acronym']; ?></td>
                                <td><?php echo $value['voc_program']; ?></td>
                                <td><?php echo $value['created_by']; ?></td>
                                <td><?php echo $value['updated_by']; ?></td>
                                <td><?php echo $value['created']; ?></td>
                                <td><?php echo $value['modified']; ?></td>
                                <td>
                                  <button type="button" class="btn btn-warning" onclick="edit_vocational_program(<?php echo $value['voc_program_id'];?>)"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th></th>
                            <th>Active</th>
                            <th>Voc. Acronym</th>
                            <th>Voc. Name</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Created</th>
                            <th>Modified</th>
                            <th>Action</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    </form>

                  </div>
                </div>

              </div>
            </div>
          </section>


<script type="text/javascript">
$(document).ready(function() {
  $('#example').DataTable();
});

var checkboxes = $("input[type='checkbox']"), submitButt = $("input[type='submit']");
$("#checkAll").change(function () {
  $("input:checkbox").prop('checked', $(this).prop("checked"));
});
checkboxes.click(function() {
  submitButt.attr("disabled", !checkboxes.is(":checked"));
});

// Modal functions

function edit_vocational_program(id){
  $('#formeditVocProgram')[0].reset();                          //RESET FORM ON MODAL
  //LOAD DATA USING AJAX
  $.ajax({
      url: "<?php echo site_url('vocational_program/get_vocational_program/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $('[name="voc_program_id"]').val(data.voc_program_id);
        $('[name="voc_program"]').val(data.voc_program);
        $('[name="voc_program_acronym"]').val(data.voc_program_acronym);
        //SHOW MODAL
        $('#editVocProgram').modal('show');
        $('.modal-title').text('Update Vocational Program');
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('ERROR POPULATING DATA');
      }
  });
}

function save_voc_program(){
  var url;
  $('#editVocProgram').modal('hide');
  url = "<?php echo site_url('vocational_program/vocational_program_update')?>";
  //AJAX ADDING DATA TO DATABASE
  $.ajax({
    url : url,
    type: "POST",
    data: $('#formeditVocProgram').serialize(),
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