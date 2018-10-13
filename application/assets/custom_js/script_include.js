function countChars(countfrom,displayto) {
  var len = document.getElementById(countfrom).value.length;
  document.getElementById(displayto).innerHTML = 100-len;
}

function handleInput(e) {
  var ss = e.target.selectionStart;
  var se = e.target.selectionEnd;
  e.target.value = e.target.value.toUpperCase();
  e.target.selectionStart = ss;
  e.target.selectionEnd = se;
}

function validate(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}

function save(){
    var url = "<?php echo site_url('courses/update_course')?>";
    //AJAX ADDING DATA TO DATABASE
    $.ajax({
      url : url,
      type: "POST",
      data: $('#formCourseInfo').serialize(),
      dataType: "JSON",
      success: function(data){
          location.reload();                // RELOAD PAGE
      },
      error: function (jqXHR, textStatus, errorThrown){
        alert('ERROR UPDATING DATA');
      }
    });
}

//FUNCTION TO SHOW MODAL
function new_course(){
  save_method = 'add';
  $('#formNewCourse')[0].reset();

  $('#newCourse').modal('show');
  $('.modal-title').text('New Course');
}
  
function save_course(){
    var url = "<?php echo site_url('courses/new_course')?>";
    $('#newCourse').modal('hide');
    //AJAX ADDING DATA TO DATABASE
    $.ajax({
      url : url,
      type: "POST",
      data: $('#formNewCourse').serialize(),
      dataType: "JSON",
      success: function(data){
        $('#success').modal('show');
        $('.modal-title').text('Message');
        $('#msg_alert').addClass(data.class_add);
        $('#msg').html(data.msg);
      },
      error: function (jqXHR, textStatus, errorThrown){
        alert('ERROR CREATING DATA');
      }
    });
}

function closeModal(){
  location.reload();
}