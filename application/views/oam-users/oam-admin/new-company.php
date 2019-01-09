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
                      <div class="icon bg-red"><i class="icon-home"></i></div>
                      <div class="text"><small class="h4">Create New Company</small></div>
                    </div>

                    <div class="card-body">

                      <p class="col-md-12">Fields with (<font style="color: red">*</font>) are required.</p>
                      <form action="<?php echo site_url('company/company_save_registration'); ?>" method="post" accept-charset="utf-8">
                        
                        <div class="form-group col-lg-12">
                          <label class="form-control-label"><font style="color: red">*</font> Company Name</label>
                          <input type="text" name="company_name[]" class="form-control" maxlength="100" required="">
                        </div>
                        
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
        
    var new_company = $(document.createElement('div')).attr("id", 'new_company' + counter);
    new_company.after().html(

      '<hr/><br>'+
      '<div class="form-group col-lg-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> Company Name</label>'+
        '<input type="text" name="company_name[]" class="form-control" maxlength="100" required="">'+
      '</div>'+
      '<br>'

    );

    new_company.appendTo("#TextBoxesGroup");
    counter++;
  });

  $("#removeButton").click(function (){
    if(counter==1){
      alert("No more forms to remove");
      return false;
    }
    counter--;
    $("#new_company" + counter).remove();
  });

});

</script>