<?php

	/* -------- */
	if(!empty($this->user_model->dYearMonth()) && $this->user_model->dYearMonth()==date('Y-m')){
		redirect('err');
	}
	/* -------- */

?>