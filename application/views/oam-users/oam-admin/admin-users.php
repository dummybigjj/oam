          <section class="tables">   
            <div class="container-fluid">
              <div class="row">

                <div class="col-lg-12" style="margin: 0 auto">
                  <div class="card">

                    <form action="<?php echo site_url('user/user_activate_deactivate'); ?>" method="post" accept-charset="utf-8">
                    <div class="card-close d-flex align-items-center">
                      <div class="btn-group">
                        <input type="submit" name="activate" value="&nbsp Activate &nbsp" disabled="" class="btn btn-success">
                        <input type="submit" name="deactivate" value=" Deactivate " disabled="" class="btn btn-danger">
                      </div>
                    </div>

                    <div class="card-header d-flex align-items-center">
                      <div class="dropdown">
                        <a href="<?php echo site_url('user_registration'); ?>" class="btn btn-primary"><i class="fa fa-plus-square-o"></i> New Users </a>
                      </div>
                    </div>

                    <div class="card-body" style="overflow-y: auto;">
                      <table id="example" class="table table-striped bg-white table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th><input type="checkbox" id="checkAll" class="checkbox-template" /></th>
                            <th>Active</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Designation</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($users)): ?>
                          <?php foreach($users as $value): ?>
                              <tr>
                                <td><input type="checkbox" class="checkbox-template" name="user_id[]" value="<?php echo $value['user_id'] ?>" /></td>
                                <td><?php echo ($value['status']=='1')?'TRUE':'FALSE'; ?></td>
                                <td><?php echo $value['u_full_name']; ?></td>
                                <td><?php echo $value['u_email_address']; ?></td>
                                <td><?php echo $value['designation']; ?></td>
                                <td>
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-primary" onclick="view_user(<?php echo $value['user_id'];?>)"> <i class="fa fa-eye" aria-hidden="true"></i> </button>
                                    <button type="button" class="btn btn-warning" onclick="edit_user(<?php echo $value['user_id'];?>)"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button>
                                    <?php if($value['designation']=='Faculty'): ?>
                                      <a target="_blank" class="btn btn-danger" href="<?php echo site_url('faculty_schedule_outline/'.$value['user_id']); ?>"><i class="fa fa-calendar"></i> </a>
                                    <?php endif; ?>
                                  </div>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th></th>
                            <th>Active</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Designation</th>
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
  function view_user(id){
  $('#formviewUser')[0].reset();                          //RESET FORM ON MODAL
  //LOAD DATA USING AJAX
  $.ajax({
      url: "<?php echo site_url('user/get_user/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $('[name="name"]').val(data.u_full_name);
        $('[name="email"]').val(data.u_email_address);
        $('[name="designation"]').val(data.designation);
        $('[name="recent_login"]').val(data.recent_login);
        $('[name="device_name"]').val(data.device_name);
        $('[name="device_ip_address"]').val(data.device_ip_address);
        $('[name="password_reset_date"]').val(data.password_reset_date);
        $('[name="created_by"]').val(data.created_by);
        $('[name="updated_by"]').val(data.updated_by);
        $('[name="created"]').val(data.created);
        $('[name="modified"]').val(data.modified);
        //SHOW MODAL
        $('#viewUser').modal('show');
        $('.modal-title').text('User Information');
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('ERROR POPULATING DATA');
      }
  });
}

function edit_user(id){
  $('#formeditUser')[0].reset();                          //RESET FORM ON MODAL
  //LOAD DATA USING AJAX
  $.ajax({
      url: "<?php echo site_url('user/get_user/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $('[name="user_id"]').val(data.user_id);
        $('[name="name"]').val(data.u_full_name);
        $('[name="email"]').val(data.u_email_address);
        $('[name="designation"]').val(data.designation);
        //SHOW MODAL
        $('#editUser').modal('show');
        $('.modal-title').text('Update User Information');
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('ERROR POPULATING DATA');
      }
  });
}

function save_user(){
  var url;
  $('#editUser').modal('hide');
  url = "<?php echo site_url('user/user_update')?>";
  //AJAX ADDING DATA TO DATABASE
  $.ajax({
    url : url,
    type: "POST",
    data: $('#formeditUser').serialize(),
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