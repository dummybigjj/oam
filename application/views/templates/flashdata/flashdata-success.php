<?php if($this->session->flashdata('success')): ?>
  <div class="alert alert-success" role="alert">
    <strong><i class="fa fa-question-circle-o" aria-hidden="true"></i></strong> <?php echo $this->session->flashdata('success'); ?>
  </div>
<?php endif; ?>