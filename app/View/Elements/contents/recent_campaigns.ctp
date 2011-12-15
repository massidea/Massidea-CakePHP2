<div id="campaigns">
	<h2>Recent <a href="campaigns/browse">campaigns</a></h2>
	<ul class="campaigns">
	<?php foreach ($recentCampaigns as $campaign) : ?>
	<li class="cmp hover-link"><span>
	<?php echo $this->Html->link($campaign['Campaign']['name'], array('controller' => 'Campaings', 'action' => 'view', $campaign['Campaign']['id'] ));?>
	</span>
	</li>
	<div class="clear">
	<?php endforeach;?>
	</ul>
</div>