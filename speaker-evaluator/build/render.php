<?php 
global $post;
$columns = (isset($attributes['columns'])) ? intval($attributes['columns']) : 5;
$agenda = wpt_get_agendadata($post->ID);
$backup = null;
foreach($agenda['blocksdata'] as $block) {
	if('wp4toastmasters/role' == $block['blockName'])
	{
		if('Speaker' == $block['attrs']['role']) {
			$speaker_assignments = $block['assignments'];
			if(!empty($block['attrs']['backup']))
				$backup = array_pop($speaker_assignments);	
		}
		if('Evaluator' == $block['attrs']['role'])
			$evaluator_assignments = $block['assignments'];
	}
}
if(empty($speaker_assignments) || empty($evaluator_assignments))
	return;
	$notime = (bool) get_option('wp4t_disable_timeblock');
$table_style = ($notime || is_agenda_context()) ? '' : 'margin-left: -150px;';
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
<table class="speaker-evaluator-table" style="<?php echo $table_style; ?>">
<?php
if(5 == $columns)
	echo '<tr style="background-color: #F0F0F0"><th class="speakernumber" style="width: 1em;">#</th><th class="speaker-column" style="width: 150px; font-weight: bold;">Speaker</th><th class="path-column" style="width: 150px; font-weight: bold;">Path</th><th class="project-column" style="width: 150px; font-weight: bold;">Project</th><th class="title-column" style="width: 150px; font-weight: bold;">Title</th><th class="evaluator-column" style="width: 150px; font-weight: bold;">Evaluator</th></tr>';
else
	echo '<tr style="background-color: #F0F0F0"><th class="speakernumber" style="width: 1em;">#</th><th class="speaker-column-plus" style="width: 350px; font-weight: bold;">Speaker</th><th class="evaluator-column" style="width: 150px; font-weight: bold;">Evaluator</th></tr>';
foreach($speaker_assignments as $index => $sa) {
	$ea = $evaluator_assignments[$index];
	if(5 == $columns) {
		if(!empty($sa['project_text']))
		{
			$project = $sa['project_text'] . '<br />'.$sa['display_time'];
			if(is_numeric($sa['ID']) && $sa['ID'] > 0)
			$project .= '<br /><a target="_blank" href="'.add_query_arg('evalme',$sa['ID'],get_permalink($post->ID)).'">Evaluation Form</a>';
		}
		else
			$project = '';
		printf('<tr><td class="speakernumber">%d</td><td class="speaker-column" style="width: 150px;">%s</td><td class="path-column" style="width: 150px;">%s</td><td class="project-column" style="width: 150px;">%s</td><td class="title-column" style="width: 150px;"><em>%s</em></td><td class="evaluator-column" style="width: 150px;">%s</td></tr>',$index+1,$sa['name'],$sa['manual'],$project,$sa['title'],$ea['name']);
	}
	else {
		$sa_text = '<strong>'.$sa['name'].'</strong>';
		if(!empty($sa['title']))
			$sa_text .= '<br /><em>'.$sa['title'].'</em>';
		if(!empty($sa['manual']))
			$sa_text .= '<br />'.$sa['manual'];
		if(!empty($sa['project_text']))
			$sa_text .= '<br />'.$sa['project_text'];
		if(!empty($sa['display_time']))
			$sa_text .= '<br />'.$sa['display_time'];
		if(!empty($sa['project_text']) && is_numeric($sa['ID']) && $sa['ID'] > 0)
		{
			$sa_text .= '<br /><a target="_blank" href="'.add_query_arg('evalme',$sa['ID'],get_permalink($post->ID)).'">Evaluation Form</a>';
		}
		printf('<tr><td>%d</td><td>%s</td><td><strong>%s</strong></td></tr>',$index+1,$sa_text,$ea['name']);	
	}
}
?>
</table>
<?php
if($backup && $backup['name'])
printf('<p>Backup Speaker: %s</p>',$backup['name']);
?>
</div>
