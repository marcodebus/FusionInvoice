<div class="headerbar">
	<h1><?php echo lang('sales_by_client'); ?></h1>
</div>

<div class="content">

	<?php $this->layout->load_view('layout/alerts'); ?>

	<div id="report_options" class="widget">

		<div class="widget-title">
			<h5><i class="icon-print"></i> <?php echo lang('report_options'); ?></h5>
		</div>

		<div class="padded">

			<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="form-horizontal">
				<div class="control-group">
					<label><?php echo lang('from_date'); ?>: </label>
					<div class="controls input-append date datepicker">
						<input size="16" type="text" name="from_date" id="from_date" value="" readonly>
						<span class="add-on"><i class="icon-th"></i></span>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label"><?php echo lang('to_date'); ?>: </label>
					<div class="controls input-append date datepicker">
						<input size="16" type="text" name="to_date" id="to_date" value="" readonly>
						<span class="add-on"><i class="icon-th"></i></span>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<input type="submit" class="btn" name="btn_submit" value="<?php echo lang('run_report'); ?>">	
					</div>
				</div>

			</form>

		</div>

	</div>

</div>

</form>