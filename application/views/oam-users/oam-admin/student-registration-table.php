          <section class="tables">   
            <div class="container-fluid">
              <div class="row">

                <div class="col-lg-12" style="margin: 0 auto">
                  <div class="card">

                    <form action="<?php echo site_url('student/set_students'); ?>" method="post" accept-charset="utf-8">
                      <div class="card-close d-flex align-items-center">
                        <button type="submit" class="btn btn-primary" style="float: right;"><i class="fa fa-floppy-o"></i> Save</button>
                      </div>

                      <div class="card-header d-flex align-items-center">
                        <div class="dropdown"> 
                          <div class="btn-group">
                            <button id="addButton" type="button" class="btn btn-success">&nbsp&nbsp&nbsp<i class="fa fa-plus-square-o"></i> Add&nbsp&nbsp&nbsp</button>
                            <button id="removeButton" type="button" class="btn btn-danger"><i class="icon-close"></i> Remove</button>  
                          </div>
                        </div>
                      </div>

                      <div class="card-body" style="overflow-y: auto;">
                        <table id="example" class="table table-striped bg-white table-bordered" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Student No.</th>
                              <th>National ID</th>
                              <th>Company</th>
                              <th>Email</th>
                              <th>Mobile No.</th>
                              <th>English Name</th>
                              <th>Arabic Name</th>
                              <th>Nationality</th>
                              <th>Sign Contract</th>
                              <th>Pref. Course</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>
                                <input type="text" name="student_no[]" maxlength="6" onkeypress="validate(event)" placeholder="Student Number" required="" class="form-control">
                              </td>
                              <td>
                                <input type="text" name="national_id[]" maxlength="10" placeholder="National ID" class="form-control">
                              </td>
                              <td>
                                <select name="company[]" class="form-control">
                                  <?php if(!empty($company)): ?>
                                    <?php foreach ($company as $value): ?>
                                      <option value="<?php echo $value['company_name']; ?>"><?php echo $value['company_name']; ?></option>
                                    <?php endforeach; ?>
                                  <?php endif; ?>
                                </select>
                              </td>
                              <td>
                                <input type="email" name="email_address[]" maxlength="60" placeholder="Email Address" class="form-control">
                              </td>
                              <td>
                                <input type="text" data-mask="(999) 999-9999" name="mobile_no[]" maxlength="11" onkeypress="validate(event)" placeholder="Mobile No." class="form-control"><small class="help-block-none">(999) 999-9999</small>
                              </td>
                              <td>
                                <input type="text" name="english_name[]" maxlength="100" placeholder="English Name" required="" class="form-control">
                              </td>
                              <td>
                                <input type="text" name="arabic_name[]" maxlength="100" placeholder="Arabic Name" class="form-control">
                              </td>
                              <td>
                                <input type="text" name="nationality[]" maxlength="60" placeholder="Nationality" class="form-control">
                              </td>
                              <td>
                                <input type="text" name="sign_contract[]" placeholder="Sign Contract" data-mask="9999-99-99" placeholder="Sign Contract" class="form-control"><small class="help-block-none">YYYY-MM-DD</small>
                              </td>
                              <td>
                                <input type="text" name="remarks[]" maxlength="60" placeholder="Preferred Course" class="form-control">
                              </td>
                            </tr>
                            <div id="TextBoxesGroup"></div>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>Student No.</th>
                              <th>National ID</th>
                              <th>Company</th>
                              <th>Email</th>
                              <th>Mobile No.</th>
                              <th>English Name</th>
                              <th>Arabic Name</th>
                              <th>Nationality</th>
                              <th>Sign Contract</th>
                              <th>Pref. Course</th>
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

$(document).ready(function(){
  var counter = 1;
  $("#addButton").click(function () {
    if(counter>100){
        alert("Only 100 forms are allowed");
        return false;
    }
        
    var new_student = $(document.createElement('tbody')).attr("id", 'new_student' + counter);
    new_student.after().html(
      '<tr>'+
        '<td>'+
          '<input type="text" name="student_no[]" maxlength="6" onkeypress="validate(event)" placeholder="Student Number" required="" class="form-control">'+
        '</td>'+
        '<td>'+
          '<input type="text" name="national_id[]" maxlength="10" placeholder="National ID" class="form-control">'+
        '</td>'+
        '<td>'+
          '<select name="company[]" class="form-control">'+
            '<?php foreach ($company as $value): ?>'+
              '<option value="<?php echo $value['company_name']; ?>"><?php echo $value['company_name']; ?></option>'+
            '<?php endforeach; ?>'+
          '</select>'+
        '</td>'+
        '<td>'+
          '<input type="email" name="email_address[]" maxlength="60" placeholder="Email Address" class="form-control">'+
        '</td>'+
        '<td>'+
          '<input type="text" name="mobile_no[]" data-mask="(999) 999-9999" onkeypress="validate(event)" placeholder="Mobile No." class="form-control"><small class="help-block-none">(999) 999-9999</small>'+
        '</td>'+
        '<td>'+
          '<input type="text" name="english_name[]" maxlength="100" placeholder="English Name" required="" class="form-control">'+
        '</td>'+
        '<td>'+
          '<input type="text" name="arabic_name[]" maxlength="100" placeholder="Arabic Name" class="form-control">'+
        '</td>'+
        '<td>'+
          '<input type="text" name="nationality[]" maxlength="60" placeholder="Nationality" class="form-control">'+
        '</td>'+
        '<td>'+
          '<input type="text" name="sign_contract[]" placeholder="Sign Contract" data-mask="9999-99-99" placeholder="Sign Contract" class="form-control"><small class="help-block-none">YYYY-MM-DD</small>'+
        '</td>'+
        '<td>'+
          '<input type="text" name="remarks[]" maxlength="60" placeholder="Remarks" class="form-control">'+
        '</td>'+
      '</tr>'
    );

    new_student.appendTo("table");
    counter++;
  });

  $("#removeButton").click(function (){
    if(counter==1){
      alert("No more forms to remove");
      return false;
    }
    counter--;
    $("#new_student" + counter).remove();
  });

});
</script>