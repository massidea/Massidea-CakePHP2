<?php 
$tabMenu = array(
	'Posts' => '#tabs-1',
	'Views' => '#tabs-2',
	'Favourites' => '#tabs-3',
	'Groups' => '#tabs-4',
	'Readers' => '#tabs-5',
);
?>

<div id="user-view-leftside" >
	<div id="profileimage">
		<?php echo $this->Html->image('/img/no_profile_img_placeholder.png'); ?>
	</div>
	<div id="metadata">
		<span class="data-label">Joined</span>
		<span class="data-value"><?php echo $this->Time->timeAgoInWords($joinedDate); ?></span>
		<span class="data-label">Last logged in</span>
		<span class="data-value"><?php echo $this->Time->timeAgoInWords($loggedDate); ?></span>
	</div>
</div>
<div id="user-view-rightside">
	<h2><?php echo $username;?></h2>
	<div id="profiledata">
		<?php foreach($profileData as $child => $array): ?>
		<span class="data-label"><?php echo ucfirst($array['key']); ?></span>
		<span class="data-value"><?php echo ucfirst($array['value']); ?></span>
		<?php endforeach; ?>
	</div>
</div>
<?php if($owner): ?>
<div id="user-view-editaccount">
	<?php echo $this->Html->link(__('Edit account', true), '/users/edit/'); ?>
</div>
<?php endif;?>



<div id="activities_tabs">
		<ul>
			<li><a href="#allPosts">All</a></li>
			<li><a href="#challenges">Challenges</a></li>
			<li><a href="#ideas">Ideas</a></li>
			<li><a href="#visions">Visions</a></li>

		</ul>
		<div id="allPosts">
			<table id="waiting_members_table" width="100%" class="fixed-table display">
				<thead>
					<tr>
						<th>Id</th>
						<th><?php echo __('Title') ?></th>
						<th><?php echo __('Lead') ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($userdata['Content'] as $content):?>
						<td><?php echo $content['id']?></td>
						<td><?php echo $content['title']?></td>
						<td><?php echo $content['lead']?></td>	
						<?php endforeach;?>					
				</tbody>
				<tfoot>
					<tr>
						<th>Id</th>
						<th><?php echo __('Name') ?></th>
						<th><?php echo __('Action') ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<div id="challenges">
		<table id="waiting_members_table" width="100%" class="fixed-table display">
				<thead>
					<tr>
						<th>Id</th>
						<th><?php echo __('Name') ?></th>
						<th><?php echo __('Action') ?></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
				<tfoot>
					<tr>
						<th>Id</th>
						<th><?php echo __('Name') ?></th>
						<th><?php echo __('Action') ?></th>
					</tr>
				</tfoot>
			</table>
		</div>		
	<div id="ideas">
		<table id="waiting_members_table" width="100%" class="fixed-table display">
				<thead>
					<tr>
						<th>Id</th>
						<th><?php echo __('Name') ?></th>
						<th><?php echo __('Action') ?></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
				<tfoot>
					<tr>
						<th>Id</th>
						<th><?php echo __('Name') ?></th>
						<th><?php echo __('Action') ?></th>
					</tr>
				</tfoot>
			</table>
		</div>		
	<div id="visions">
		<table id="waiting_members_table" width="100%" class="fixed-table display">
				<thead>
					<tr>
						<th>Id</th>
						<th><?php echo __('Name') ?></th>
						<th><?php echo __('Action') ?></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
				<tfoot>
					<tr>
						<th>Id</th>
						<th><?php echo __('Name') ?></th>
						<th><?php echo __('Action') ?></th>
					</tr>
				</tfoot>
			</table>
		</div>		
	</div>