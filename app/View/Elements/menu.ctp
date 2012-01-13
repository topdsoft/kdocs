<div class="actions">
	<h3><?php echo __('Menu'); ?></h3>
	<ul>
		<?php 
			echo $this->element('menufunction'); 
			if($this->Session->read('Auth.User.username')) {
				//user is logged in
				$user=ClassRegistry::init('User')->read(null,$this->Session->read('Auth.User.id'));
				#find new docs
				$ug=ClassRegistry::init('GroupsUser')->find('list',array('fields'=>'group_id','conditions'=>array('user_id'=>$this->Session->read('Auth.User.id'))));
				$docs=ClassRegistry::init('Doc')->find('all',array(
					'conditions'=>array('Doc.group_id'=>$ug),
					'limit'=>5,
					'order'=>'Doc.created desc'
				));
				$doclist=array();
				foreach($docs as $d) $doclist[]=array('label'=>$d['Doc']['name'].' ('.$d['Group']['name'].')','action'=>'view','id'=>$d['Doc']['id']);
				if(!empty($docs))menu($this,'Docs','Latest Docs',$doclist);
//debug($docs);exit;
				#find groups
				$groups=array();
				foreach($user['Group'] as $g) $groups[]=array('label'=>$g['name'],'action'=>'view','id'=>$g['id']);
				if(!empty($groups))menu($this,'Groups','Your Groups',$groups);
				unset($groups);
				#options menu
				menu($this,'Users','Options',array(
					array('label'=>'Create New Group','controller'=>'groups','action'=>'add'),
					array('label'=>'Create New Doc','controller'=>'docs','action'=>'add'),
				));
			}//endif
		?>
	</ul>
