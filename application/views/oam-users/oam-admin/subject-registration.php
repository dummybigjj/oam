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
                      <div class="icon bg-red"><i class="icon-list-1"></i></div>
                      <div class="text"><small class="h4">Create New Subject</small></div>
                    </div>

                    <div class="card-body">

                      <p class="col-md-12">Fields with (<font style="color: red">*</font>) are required.</p>
                      <form action="<?php echo site_url('subject/subject_save_registration'); ?>" method="post" accept-charset="utf-8">
                        <div class="form-group col-md-12">
                          <label class="form-control-label"><font style="color: red">*</font> Subject Title</label>
                          <input type="text" name="subject_title[]" maxlength="60" placeholder="Subject Title" required="" class="form-control">
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
        
    var new_subject = $(document.createElement('div')).attr("id", 'new_subject' + counter);
    new_subject.after().html(

      '<div class="form-group col-md-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> Subject Title</label>'  +
        '<input type="text" name="subject_title[]" maxlength="60" placeholder="Subject Title" required="" class="form-control">'+
      '</div>'+

      '<div class="line"></div>'+
      '<div class="line"></div>'

    );

    new_subject.appendTo("#TextBoxesGroup");
    counter++;
  });

  $("#removeButton").click(function (){
    if(counter==1){
      alert("No more forms to remove");
      return false;
    }
    counter--;
    $("#new_subject" + counter).remove();
  });

});

</script>