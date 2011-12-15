<?php echo $this->Form->create('headerSearchForm', array('url' => array('controller' => 'GlobalSearches',
													'action'	 => 'listResult'),
									'type' => 'post')); ?>


<div id="search-field">
<?php echo $this->Form->text(null, array('class' => 'top_search_field',
											'id' 	 => 'globalSearch',
											'name' 	 => 'search')); ?>
</div>
	
<?php echo $this->Form->end(array('name' 	=> 'submitsearch',
							'label' => 'Search',
							'class' => 'submit-button',
							'id'	=> 'submitsearch',
							'alt'	=> 'Search',
							'div' 	=> array('id' 	=> 'search-submit',
											'class' => null))); ?>