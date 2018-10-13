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
                      <div class="icon bg-green"><i class="fa fa-user-o"></i></div>
                      <div class="text"><small class="h4">New Students</small></div>
                    </div>

                    <div class="card-body">

                      <p class="col-md-12">Fields with (<font style="color: red">*</font>) are required.</p>
                      <form action="<?php echo site_url('student/set_students'); ?>" method="post" accept-charset="utf-8">
                        <div class="form-group col-md-12">
                          <label class="form-control-label"><font style="color: red">*</font> Student No.</label>
                          <input type="text" name="student_no[]" maxlength="5" onkeypress="validate(event)" placeholder="Student Number" required="" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                          <label class="form-control-label"><font style="color: red">*</font> National ID</label>
                          <input type="text" name="national_id[]" maxlength="10" placeholder="National ID" required="" class="form-control">
                        </div>
                        <div class="form-group col-md-12">       
                          <label class="form-control-label"><font style="color: red">*</font> Email</label>
                          <input type="email" name="email_address[]" maxlength="60" placeholder="Email Address" required="" class="form-control">
                        </div>
                        <div class="form-group col-md-12">       
                          <label class="form-control-label"><font style="color: red">*</font> Mobile No.</label>
                          <input type="text" data-mask="(999) 999-9999" name="mobile_no[]" maxlength="11" onkeypress="validate(event)" placeholder="Mobile No." required="" class="form-control"><small class="help-block-none">(999) 999-9999</small>
                        </div>
                        <div class="form-group col-md-12">       
                          <label class="form-control-label"><font style="color: red">*</font> English Name</label>
                          <input type="text" name="english_name[]" maxlength="100" placeholder="English Name" required="" class="form-control">
                        </div>
                        <div class="form-group col-md-12">       
                          <label class="form-control-label"><font style="color: red">*</font> Arabic Name</label>
                          <input type="text" name="arabic_name[]" maxlength="100" placeholder="Arabic Name" required="" class="form-control">
                        </div>
                        <div class="form-group col-md-12">       
                          <label class="form-control-label"><font style="color: red">*</font> Nationality</label>
                          <input type="text" name="nationality[]" maxlength="60" placeholder="Nationality" required="" class="form-control">
                        </div>

                        <div class="line"></div>
                        <div class="line"></div>
                        <div id="TextBoxesGroup"></div>

                        <div class="form-footer">
                          <div class="form-group col-md-12">  
                            <div class="btn-group">
                              <button id="addButton" type="button" class="btn btn-success">&nbsp&nbsp&nbsp<i class="fa fa-plus-square-o"></i> Add&nbsp&nbsp&nbsp</button>
                              <button id="removeButton" type="button" class="btn btn-danger"><i class="icon-close"></i> Remove</button>  
                            </div>
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
  
$(document).ready(function(){
  var counter = 1;
  $("#addButton").click(function () {
    if(counter>10){
        alert("Only 10 forms are allowed");
        return false;
    }
        
    var new_student = $(document.createElement('div')).attr("id", 'new_student' + counter);
    new_student.after().html(

      '<div class="form-group col-md-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> Student No.</label>'+
        '<input type="text" name="student_no[]" maxlength="5" onkeypress="validate(event)" placeholder="Student Number" required="" class="form-control">'+
      '</div>'+
      '<div class="form-group col-md-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> National ID</label>'+
        '<input type="text" name="national_id[]" maxlength="10" onkeypress="validate(event)" placeholder="National ID" required="" class="form-control">'+
      '</div>'+
      '<div class="form-group col-md-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> Email</label>'+
        '<input type="email" name="email_address[]" maxlength="60" placeholder="Email Address" required="" class="form-control">'+
      '</div>'+
      '<div class="form-group col-md-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> Mobile No.</label>'+
        '<input type="text" name="mobile_no[]" maxlength="11" onkeypress="validate(event)" placeholder="Mobile No." required="" class="form-control">'+
      '</div>'+
      '<div class="form-group col-md-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> English Name</label>'+
        '<input type="text" name="english_name[]" maxlength="100" placeholder="English Name" required="" class="form-control">'+
      '</div>'+
      '<div class="form-group col-md-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> Arabic Name</label>'+
        '<input type="text" name="arabic_name[]" maxlength="100" placeholder="Arabic Name" required="" class="form-control">'+
      '</div>'+
      '<div class="form-group col-md-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> Nationality</label>'+
        '<input type="text" name="nationality[]" maxlength="60" placeholder="Nationality" required="" class="form-control">'+
      '</div>'+

      '<div class="line"></div>'+
      '<div class="line"></div>'

    );

    new_student.appendTo("#TextBoxesGroup");
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