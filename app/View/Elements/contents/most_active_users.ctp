<div id="users">
	<h2>Most active <a href="users/browse">users</a></h2>
	<ul class="users">
	<?php foreach ($activeUsers as $user) : ?>
	<li class="hover-link"><span>
	<?php echo $this->Html->link($user['User']['username']." (".$user['0']['total_contents'].")" . " | " . $userCities[$user['User']['id']], array('controller' => 'Users', 'action' => 'view', $user['User']['username'] ));?>
	</span>
	</li>
	<div class="clear">
	<?php endforeach;?>
	</ul>
</div>