<h2>
	<?php echo __('Recent posts'); ?>
	<a href="#">
		<?php echo $this->Html->image('icon_rss_28x28.png',array('alt' => 'RSS', 'class' => 'rsslogo')); ?>
	</a>
	<a href="#">
		<?php echo $this->Html->image('podcasts.png',array('alt' => 'RSS', 'class' => 'rsslogo')); ?>
	</a>
</h2>

<?php foreach($contents as $content): ?>
<div id="postid_<?php echo $content['Content']['id']; ?>" class="user_content_row ">
	<div class="user">
		<div class="photo <?php echo $content['Content']['class']; ?>">
			<a href="<?php echo $this->Html->url(array('controller' => 'contents', 'action' => 'view', $content['Content']['id'])); ?>"><?php echo $this->Html->image('no_profile_img_placeholder.png'); ?></a>
		</div>
		<div class="context">			
				<a class="username left" href="<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'view', $content['User']['username'])); ?>"><?php echo $content['User']['username']; ?> (<?php echo isset($contentCounts[$content['User']['id']]) ? $contentCounts[$content['User']['id']] : 0; ?>) &nbsp;</a>
			<h4>
				<a href="<?php echo $this->Html->url(array('controller' => 'contents', 'action' => 'view', $content['Content']['id'])); ?>"><?php echo $content['Content']['title']; ?></a>
			</h4>
			<p><?php echo $content['Content']['lead']; ?></p>
			<?php if($content['Content']['tags']):?>
			<p>
				<a href="#"><?php echo __('Tags') ?>: </a>
				<?php echo $content['Content']['tags']?>
			</p>
			<?php endif;?>
		</div>
	</div>
	<div class="clear"></div>
</div>
<? endforeach; ?>