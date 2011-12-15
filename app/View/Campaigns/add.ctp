<?php
echo $this->Html->script(strtolower($this->name).DS.$this->action,array('inline' => false));


?>




<?php echo $this->Form->create('Campaign', array('type' => 'file',
						 				'url' => array('controller' => 'campaigns', 'action' => 'add'),
						 				'inputDefaults' => array('label' => false,
																'div' => false)
));
?>
<?php echo $this->Form->hidden('Group.id', array(
	'value' => $groupId
));
?>

<div class="clear"></div>

<div id="campaign_name" class="row">
	<div class="field-label">
		<label for="CampaignName"><?php echo __('Name') ?> </label> <small
			class="right"><?php // echo __('(Explaination)') ?>
		</small>
	</div>
	<div class="field">
<?php echo $this->Form->input('name', array('type' => 'textarea',	'rows' => '1' , 'error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
		
	</div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>
<div class="clear"></div>



<div id="campaign_lead" class="row">
	<div class="field-label">
		<label for="CampaignLead"><?php echo __('Lead Paragraph') ?> </label> <small
			class="right"><?php // echo 'Explaination'; ?> </small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('lead', array('type' => 'textarea',	'rows' => '6' , 'error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>





<div id="campaign_body" class="row">
	<div class="field-label">
		<label for="CampaignBody"><?php echo __('Body text') ?> </label> <small
			class="right"><?php // echo 'Explaination' ?> </small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('body', array('type' => 'textarea',	'rows' => '20' , 'error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	
<div class="clear"></div>

<div id="campaign_start_time" class="row">
<div class="field-label">
<label for="CampaignStartTime"><?php echo __('Starting date') ?> </label> <small
			class="right"><?php // echo 'Explaination' ?> </small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('start_time'); ?>
	</div>
	
<div class="clear"></div>

<div id="campaign_end_time" class="row">
<div class="field-label">
<label for="CampaignEndTime"><?php echo __('Ending date') ?> </label> <small
			class="right"><?php // echo 'Explaination' ?> </small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('end_time'); ?>
	</div>
	
<div class="clear"></div>


<?php echo $this->Form->hidden('Group.id', array('value' => $groupId)); ?>


<?php echo $this->Form->end(array('div' => array('class' => 'row',
											'id' => 'campaign_send'),
							'value' => 'Send',
							'label' => __('Send',true),
							'after'	=> '</div><div class="clear">'
));
 ?>




</div>





