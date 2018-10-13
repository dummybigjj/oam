<?php if($this->session->flashdata('warning')): ?>
  <div class="alert alert-warning" role="alert">
    <strong><i class="fa fa-question-circle-o" aria-hidden="true"></i></strong> <?php echo $this->session->flashdata('warning'); ?>
  </div>
<?php endif; ?>