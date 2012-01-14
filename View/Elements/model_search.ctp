<?php echo $this->Html->script('/js/clear_search'); ?>
<div id="search_filter">
<?php
$model = isset($model) ? $model : false;

if($model){
	echo $this->Form->create($model, array('inputDefaults' => array('label' => false,'div' => false)));
	echo $this->Form->input('search_string', array('label' => false, 'value' => "$model Search", 'class' => 'search_box'));
	echo $this->Form->submit('Search', array('div' => false));
	echo $this->Form->end();
}
?>
</div>