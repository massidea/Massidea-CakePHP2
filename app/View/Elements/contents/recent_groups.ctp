<div id="groups">
	<h2>Recent <a href="groups/browse">groups</a></h2>
	<ul class="groups">
		<?php foreach ($recentGroups as $group) : ?>
	<li class="grp hover-link"><span>
	<?php echo $this->Html->link($group['Group']['name'], array('controller' => 'Groups', 'action' => 'view', $group['Group']['id'] ));?>
	</span>
	</li>
	<div class="clear">
	<?php endforeach;?>
	</ul>
</div>