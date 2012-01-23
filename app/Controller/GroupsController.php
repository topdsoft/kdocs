<?php
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 */
class GroupsController extends AppController {


/**
 * index method
 *
 * @return void
	public function index() {
		$this->Group->recursive = 0;
		$this->set('groups', $this->paginate());
	}
 */

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		$group=$this->Group->read(null, $id);
		//find out if user is member of this group
		$gu=$this->Group->GroupsUser->find('first',array('conditions'=>array('group_id'=>$id,'user_id'=>$this->Auth->user('id'))));
		if(!$gu) throw new NotFoundException(__('You are not a member of this group'));
		$this->set('group', $group);
		$this->set('isadmin', $gu['GroupsUser']['admin']);
		$this->set('isowner', ($group['Group']['owner_id']==$this->Auth->user('id')));
		//get lists
		$users=$this->Group->User->find('list');
		$editors=$this->Group->Doc->Editor->find('list');
		$editors[1]='Only Owner';
		$this->set(compact(array('users','editors')));
		//get docs in correct order
		$this->paginate=array('Doc'=>array('recursive'=>-1));
		$this->set('docs',$this->paginate('Doc',array('group_id'=>$id)));
		//get list of docs that this user has viewed
		$this->set('viewed',$this->Group->Doc->DocsUser->find('list',array('conditions'=>array('user_id'=>$this->Auth->user('id')),'fields'=>'doc_id')));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Group->create();
			$uid=$this->Auth->user('id');
			$this->request->data['Group']['owner_id']=$uid;
//debug($this->request->data);exit;
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('Your group has been created'));
				//setup user as admin member of group
				$this->Group->GroupsUser->save(array('user_id'=>$uid,'admin'=>true,'group_id'=>$this->Group->getInsertId()));
				$this->redirect(array('action' => 'view',$this->Group->getInsertId()));
			} else {
				$this->Session->setFlash(__('Your group could not be saved. Please, try again.'));
			}
		}
		$owners = $this->Group->Owner->find('list');
		$users = $this->Group->User->find('list');
		$this->set(compact('owners', 'users'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		if($this->Group->field('owner_id',array('id'=>$id))!=$this->Auth->user('id')) {
			$this->Session->setFlash(__('You are not the owner of this group'));
			$this->redirect(array('action' => 'view',$id));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The group has been saved'));
				$this->redirect(array('action' => 'view',$id));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Group->read(null, $id);
		}
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
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		if($this->Group->field('owner_id',array('id'=>$id))!=$this->Auth->user('id')) {
			$this->Session->setFlash(__('You are not the owner of this group'));
			$this->redirect(array('action' => 'view',$id));
		}
		if ($this->Group->delete()) {
			$this->Session->setFlash(__('Group deleted'));
			$this->redirect('/');
		}
		$this->Session->setFlash(__('Group was not deleted'));
		$this->redirect(array('action' => 'view',$id));
	}
}
