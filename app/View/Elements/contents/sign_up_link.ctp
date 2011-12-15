<div id="signuplink">
	<p> 
	<?php 
		if(!$userId) {
			echo $this->Html->link('Sign up now!', array('controller' => 'Users', 'action' => 'signup'));
		} 
	?></p>
</div>