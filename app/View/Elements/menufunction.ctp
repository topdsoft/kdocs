<?php
function menu($obj,$controller,$contLabel,$items,$only=true) {
	/**
	$obj is $this from the view
	$controller is the default controller: block will be active if any view in this controller is active, and links with no controller passed default here
	$contLabel shows up on the menu heading
	$items is an array of :
		'label' (optional) what to show on the menu.  leave empty to have an active menu block for views that you down want a link for
		'controller' (optional) if the link is for a controller not default to the block
		'action' action for this menu item
	$only set to true to include all actions for this controller
	**/
	$activeController=false;//debug($obj->request->params);exit;
	if($only) $activeController=($controller==$obj->request->params['controller']);
	//look for an active item
	foreach($items as $i=>$item) {
		//loop for all lines passed in and find if they are active
		if(!isset($item['controller'])) {
			//if not set then use default ($controller)
			$items[$i]['controller']=$controller;
			$item['controller']=$controller;
		}//endif
		//check for action or page displayed
		if($obj->request->params['action']=='display') $action=$obj->request->params['pass'][0];
		else $action=$obj->request->params['action'];
		//check if active
		if ($action==$item['action'] && $obj->request->params['controller']==$item['controller']) {
			//is active
			$activeController=true;
			$items[$i]['active']=true;
			//check for view
			if($action=='view' && $obj->request->params['pass'][0]!=$item['id']) {
				//not the active id
//				$activeController=false;
				$items[$i]['active']=false;
			}
		} else $items[$i]['active']=false;
	}//end foreach 
	if ($activeController) echo '<div style="border:1px solid #ccc;">';
	else echo '<div style="padding: 1px;">';
	echo "<strong>$contLabel</strong>";
	foreach($items as $i) {
		//loop for all links in menu block
		if($i['active']) $div='style="background: #ccc;"';
		else $div='';
		if(isset($i['label'])){
			if(isset($i['id']))echo "<li $div>".$obj->Html->link(__($i['label']), array('controller' => $i['controller'], 'action' => $i['action'],$i['id'])).'</li>';
			else echo "<li $div>".$obj->Html->link(__($i['label']), array('controller' => $i['controller'], 'action' => $i['action'])).'</li>';
		}
	}
	echo '</div>';
}
?>
