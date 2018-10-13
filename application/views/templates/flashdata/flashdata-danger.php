<?php if($this->session->flashdata('danger')): ?>
  <div class="alert alert-danger" role="alert">
    <strong><i class="fa fa-question-circle-o" aria-hidden="true"></i></strong> <?php echo $this->session->flashdata('danger'); ?>
  </div>
<?php endif; ?>