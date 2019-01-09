          <section class="tables">   
            <div class="container-fluid">
              <div class="row">

                <div class="col-lg-12" style="margin: 0 auto">

                  <div class="alert alert-danger" role="alert">
                    <i class="fa fa-question-circle-o"></i> IMPORTANT NOTE: Deletion/Removal of Company will affect other related data such as Students company records.
                  </div>

                  <div class="card">

                    <form action="<?php echo site_url('company/company_activate_deactivate'); ?>" method="post" accept-charset="utf-8">
                    <div class="card-close d-flex align-items-center">
                      <div class="btn-group">
                        <input type="submit" name="activate" value=" Activate " disabled="" class="btn btn-success">
                        <input type="submit" name="deactivate" value="Deactivate" disabled="" class="btn btn-danger">
                      </div>&nbsp
                      <input type="submit" name="delete" value="Delete" disabled="" class="btn btn-danger">
                    </div>

                    <div class="card-header d-flex align-items-center">
                      <div class="dropdown">
                        <a href="<?php echo site_url('new_company'); ?>" class="btn btn-primary"><i class="fa fa-plus-square-o"></i> Add </a>
                      </div>
                    </div>

                    <div class="card-body" style="overflow-y: auto;">
                      <table id="example" class="table table-striped bg-white table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th><input type="checkbox" id="checkAll" class="checkbox-template" /></th>
                            <th>Active</th>
                            <th>Company Name</th>
                            <th>Created by</th>
                            <th>Updated By</th>
                            <th>Created</th>
                            <th>Modified</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($company)): ?>
                          <?php foreach($company as $value): ?>
                              <tr>
                                <td><input type="checkbox" class="checkbox-template" name="company_id[]" value="<?php echo $value['company_id'] ?>" /></td>
                                <td><?php echo ($value['status']=='1')?'TRUE':'FALSE'; ?></td>
                                <td><?php echo $value['company_name']; ?></td>
                                <td><?php echo $value['created_by']; ?></td>
                                <td><?php echo $value['updated_by']; ?></td>
                                <td><?php echo $value['created']; ?></td>
                                <td><?php echo $value['modified']; ?></td>
                                <td>
                                  <button type="button" class="btn btn-warning" onclick="edit_company(<?php echo $value['company_id'];?>)"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th></th>
                            <th>Active</th>
                            <th>Company Name</th>
                            <th>Created by</th>
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

function edit_company(id){
  $('#formeditCompany')[0].reset();                          //RESET FORM ON MODAL
  //LOAD DATA USING AJAX
  $.ajax({
      url: "<?php echo site_url('company/get_company/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $('[name="company_id"]').val(data.company_id);
        $('[name="company_name"]').val(data.company_name);
        //SHOW MODAL
        $('#editCompany').modal('show');
        $('.modal-title').text('Edit Company');
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('ERROR POPULATING DATA');
      }
  });
}

function save_company(){
  var url;
  $('#editCompany').modal('hide');
  url = "<?php echo site_url('company/company_update')?>";
  //AJAX ADDING DATA TO DATABASE
  $.ajax({
    url : url,
    type: "POST",
    data: $('#formeditCompany').serialize(),
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

</script>