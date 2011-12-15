<div id="tags">
	<h2>Most popular <a href="#">tags</a></h2>
	<ul id="tagcloud" class="tags">
	<?php 
		echo $this->TagCloud->display($tags, array(
			'before' => '<li size="%size%" class="tag">',
			'after' => '</li>'));
	?>
	</ul>	
</div>
<div class="clear"></div>