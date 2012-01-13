<?php
App::uses('AppController', 'Controller');
/**
 * Docs Controller
 *
 * @property Doc $Doc
 */
class DocsController extends AppController {


/**
 * index method
 *
 * @return void
	public function index() {
		$this->Doc->recursive = 0;
		$this->set('docs', $this->paginate());
	}
 */

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Doc->id = $id;
		if (!$this->Doc->exists()) {
			throw new NotFoundException(__('Invalid doc'));
		}
		$doc=$this->Doc->read(null, $id);
		//check if user has rights to view
		$gu=$this->Doc->Group->GroupsUser->find('first',array('conditions'=>array('group_id'=>$doc['Doc']['group_id'],'user_id'=>$this->Auth->user('id'))));
		if (!$gu) {
			throw new NotFoundException(__('Invalid doc'));
		}
//debug($gu);exit;
		//check for comments
		if ($this->request->is('post') && !empty($this->request->data['Doc']['comment'])) {
			//add comments
			$this->Doc->Comment->save(array('user_id'=>$this->Auth->user('id'),'doc_id'=>$id,'text'=>$this->request->data['Doc']['comment']));
//debug($this->request->data);exit;
		}
		$this->set('doc', $doc);
		$users=$this->Doc->User->find('list');
		$this->set(compact('users'));
		//find out if user can edit doc
		$canedit=false;
		if($doc['Doc']['editor_id']==3) $canedit=true;
		elseif($doc['Doc']['editor_id']==2 && $gu['GroupsUser']['admin']) $canedit=true;
		elseif($doc['Doc']['editor_id']==1 && $doc['Doc']['user_id']==$this->Auth->user('id')) $canedit=true;
		$this->set('canedit',$canedit);
	}

/**
 * print method
 *
 * @param string $id
 * @return void
 */
	public function dprint($id = null) {
		$this->Doc->id = $id;
		if (!$this->Doc->exists()) {
			throw new NotFoundException(__('Invalid doc'));
		}
		$doc=$this->Doc->read(null, $id);
		//check if user has rights to view
		$gu=$this->Doc->Group->GroupsUser->find('first',array('conditions'=>array('group_id'=>$doc['Doc']['group_id'],'user_id'=>$this->Auth->user('id'))));
		if (!$gu) {
			throw new NotFoundException(__('Invalid doc'));
		}
		$this->set('doc', $doc);
		$this->layout='print';
		$this->set('title_for_layout',$doc['Doc']['name']);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Doc->create();
			$this->request->data['Doc']['user_id']=$this->Auth->user('id');
			if ($this->Doc->save($this->request->data)) {
				$this->Session->setFlash(__('Your doc has been created'));
				$this->redirect(array('action' => 'edit',$this->Doc->getInsertId()));
			} else {
				$this->Session->setFlash(__('Your doc could not be saved. Please, try again.'));
			}
		} else {
			//figure out default group
			$ref=explode('/',$this->referer());
			$cnt=count($ref);
			if($cnt>4 && $ref[$cnt-3]=='Groups' && $ref[$cnt-2]=='view') {
				//get group
				$this->request->data['Doc']['group_id']=$ref[$cnt-1];
//debug($ref);exit;
			}
		}
		$ug=$this->Doc->User->GroupsUser->find('list',array('fields'=>'group_id','conditions'=>array('user_id'=>$this->Auth->user('id'))));
//debug($ug);exit;
		$groups = $this->Doc->Group->find('list',array('conditions'=>array('id'=>$ug)));
		$editors = $this->Doc->Editor->find('list');
		$this->set(compact('groups', 'editors'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Doc->id = $id;
		if (!$this->Doc->exists()) {
			throw new NotFoundException(__('Invalid doc'));
		}
		//check if user has rights to view
		$gu=$this->Doc->Group->GroupsUser->find('first',array('conditions'=>array('group_id'=>$this->Doc->field('group_id',array('id'=>$id)),
			'user_id'=>$this->Auth->user('id'))));
		if (!$gu) {
			throw new NotFoundException(__('Invalid doc'));
		}
		//check for edit permission
		$canedit=false;
		$policy=$this->Doc->field('editor_id',array('id'=>$id));
		if($policy==3) $canedit=true;
		elseif($policy==2 && $gu['GroupsUser']['admin']) $canedit=true;
		elseif($policy==1 && $this->Doc->field('user_id',array('id'=>$id))==$this->Auth->user('id')) $canedit=true;
		if(!$canedit) {
			$this->Session->setFlash(__('Sorry, you do not have permission to edit this doc'));
			$this->redirect(array('action' => 'view',$id));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Doc->save($this->request->data)) {
				$this->Session->setFlash(__('The doc has been saved'));
				$this->redirect(array('action' => 'view',$id));
			} else {
				$this->Session->setFlash(__('The doc could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Doc->read(null, $id);
		}
		$users = $this->Doc->User->find('list');
		$groups = $this->Doc->Group->find('list');
		$editors = $this->Doc->Editor->find('list');
		$uploadedfiles = $this->Doc->Uploadedfile->find('list');
		$users = $this->Doc->User->find('list');
		$this->set(compact('users', 'groups', 'editors', 'uploadedfiles', 'users'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Doc->id = $id;
		if (!$this->Doc->exists()) {
			throw new NotFoundException(__('Invalid doc'));
		}
		if ($this->Doc->delete()) {
			$this->Session->setFlash(__('Doc deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Doc was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
