<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	function beforeFilter() {        
		$this->Auth->allow('register','PWlost');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$docs = $this->User->Doc->find('list');
		$groups = $this->User->Group->find('list');
		$this->set(compact('docs', 'groups'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$docs = $this->User->Doc->find('list');
		$groups = $this->User->Group->find('list');
		$this->set(compact('docs', 'groups'));
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
			}
		}
	}
	
	public function logout() {
		$this->redirect($this->Auth->logout());
	}
	
	public function register($hash=null) {
		//validate hash
		$invite=$this->User->Invite->find('first',array('conditions'=>array('Invite.hash'=>$hash)));
		if(!$invite) {
			$this->Session->setFlash(__('Invalid Invite'));
			$this->redirect('/');
		}
		if ($this->request->is('post')) {
			$this->User->create();
			$this->request->data['Group']['Group']=array($invite['Invite']['group_id']);
			if($this->request->data['User']['password']!=$this->request->data['User']['password2']) {
				$this->Session->setFlash(__('Your passwords do not match. Please, try again.'));
				$this->request->data['User']['password']=$this->request->data['User']['password2']='';
			} else {
//debug($this->request->data);exit;
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('Your kDocs Account has been Activated'));
					$this->Auth->login();
					//update invite
					$this->User->Invite->save(array('id'=>$invite['Invite']['id'],'hash'=>null,'user_id'=>$this->User->getInsertId()));
					$this->redirect(array('controller'=>'groups','action' => 'view',$invite['Invite']['group_id']));
				} else {
					$this->Session->setFlash(__('Your profile could not be saved. Please, try again.'));
				}
			}//endif
		} else $this->request->data['User']['email']=$invite['Invite']['email'];
		$this->set('invite',$invite);
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
//		$this->request->data['in']['group_id']=array($invite['Invite']['group_id']);
//debug($invite);exit;
	}
	
	public function makeadmin($user_id,$group_id) {
		//validate
		$this->User->id = $user_id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->User->Group->id=$group_id;
		if (!$this->User->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		$gu=$this->User->GroupsUser->find('first',array('conditions'=>array('user_id'=>$user_id,'group_id'=>$group_id)));
		if (!$gu) {
			throw new NotFoundException(__('User is not a member of this group'));
		}
		if($gu['GroupsUser']['admin']) {
			$this->Session->setFlash(__('User is already an admin for this group'));
			$this->redirect(array('controller'=>'groups','action'=>'view',$group_id));
		}
		$gu['GroupsUser']['admin']=true;
		if($this->User->GroupsUser->save($gu)) {
			$this->Session->setFlash(__('User is now an admin for this group'));
			$this->redirect(array('controller'=>'groups','action'=>'view',$group_id));
		} else throw new NotFoundException(__('Failed to save admin request'));
	}
	
	public function removeadmin($user_id,$group_id) {
		//validate
		$this->User->id = $user_id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->User->Group->id=$group_id;
		if (!$this->User->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		$gu=$this->User->GroupsUser->find('first',array('conditions'=>array('user_id'=>$user_id,'group_id'=>$group_id)));
		if (!$gu) {
			throw new NotFoundException(__('User is not a member of this group'));
		}
		if(!$gu['GroupsUser']['admin']) {
			$this->Session->setFlash(__('User is already NOT an admin for this group'));
			$this->redirect(array('controller'=>'groups','action'=>'view',$group_id));
		}
		$gu['GroupsUser']['admin']=false;
		if($this->User->GroupsUser->save($gu)) {
			$this->Session->setFlash(__('User is no longer an admin for this group'));
			$this->redirect(array('controller'=>'groups','action'=>'view',$group_id));
		} else throw new NotFoundException(__('Failed to save admin request'));
	}
	
	public function removefromgroup($user_id,$group_id) {
		//validate
		$this->User->id = $user_id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->User->Group->id=$group_id;
		if (!$this->User->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		$gu=$this->User->GroupsUser->find('first',array('conditions'=>array('user_id'=>$user_id,'group_id'=>$group_id)));
		if (!$gu) {
			throw new NotFoundException(__('User is not a member of this group'));
		}
		if($this->User->GroupsUser->delete($gu['GroupsUser']['id'])) {
			$this->Session->setFlash(__('User has been removed from this group'));
			$this->redirect(array('controller'=>'groups','action'=>'view',$group_id));
		} else throw new NotFoundException(__('Failed to remove user'));
	}
}
