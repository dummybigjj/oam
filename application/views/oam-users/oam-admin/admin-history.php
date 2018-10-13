          <section class="tables">   
            <div class="container-fluid">
              <div class="row">

                <div class="col-lg-12" style="margin: 0 auto">
                  <div class="card">

                    <div class="card-close d-flex align-items-center">
                    </div>

                    <div class="card-header d-flex align-items-center">
                      <div class="dropdown"> 
                        <div class="statistic d-flex align-items-center no-padding-top no-padding-bottom">
                          <div class="icon bg-red"><i class="fa fa-table" aria-hidden="true"></i></div>
                          <div class="text"><small class="h5">History Logs Table</small></div>
                        </div>
                      </div>
                    </div>

                    <div class="card-body" style="overflow-y: auto;">
                      <table id="example" class="table table-striped bg-white table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Activity</th>
                            <th>Created by</th>
                            <th>Email</th>
                            <th>Designation</th>
                            <th>Created</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($history)): ?>
                          <?php foreach($history as $value): ?>
                              <tr>
                                <td><?php echo $value['activity']; ?></td>
                                <td><?php echo $value['u_full_name']; ?></td>
                                <td><?php echo $value['u_email_address']; ?></td>
                                <td><?php echo $value['designation']; ?></td>
                                <td><?php echo $value['created']; ?></td>
                                <td>
                                  <button type="button" class="btn btn-primary" onclick="view_history(<?php echo $value['tbl_id'];?>)"> <i class="fa fa-eye" aria-hidden="true"></i> View </button>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Activity</th>
                            <th>Created by</th>
                            <th>Email</th>
                            <th>Designation</th>
                            <th>Created</th>
                            <th>Action</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
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
function view_history(id){
  $('#formviewHistory')[0].reset();                          //RESET FORM ON MODAL
  //LOAD DATA USING AJAX
  $.ajax({
      url: "<?php echo site_url('admin/get_history/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data){
        $('[name="activity"]').val(data.activity);
        $('[name="name"]').val(data.u_full_name);
        $('[name="email"]').val(data.u_email_address);
        $('[name="designation"]').val(data.designation);
        $('[name="device_use"]').val(data.device_use);
        $('[name="device_name"]').val(data.device_name);
        $('[name="device_ip"]').val(data.device_ip_address);
        $('[name="created"]').val(data.created);
        //SHOW MODAL
        $('#viewHistory').modal('show');
        $('.modal-title').text('History Logs');
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('ERROR POPULATING DATA');
      }
  });
}

</script>