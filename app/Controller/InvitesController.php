<?php
App::uses('AppController', 'Controller');
/**
 * Invites Controller
 *
 * @property Invite $Invite
 */
class InvitesController extends AppController {


/**
 * index method
 *
 * @return void
	public function index() {
		$this->Invite->recursive = 0;
		$this->set('invites', $this->paginate());
	}
 */

/**
 * view method
 *
 * @param string $id
 * @return void
	public function view($id = null) {
		$this->Invite->id = $id;
		if (!$this->Invite->exists()) {
			throw new NotFoundException(__('Invalid invite'));
		}
		$this->set('invite', $this->Invite->read(null, $id));
	}
 */

/**
 * add method
 *
 * @return void
 */
	public function add($group_id=NULL) {
		if ($this->request->is('post')) {
			$this->Invite->create();
//debug($this->request->data);exit;
			if ($this->Invite->save($this->request->data)) {
				//send email
				$this->_sendNewUserMail($this->Invite->getInsertId());
				$this->Session->setFlash(__('The Invitation has been Sent'));
				$this->redirect(array('controller'=>'groups','action' => 'view',$this->request->data['Invite']['group_id']));
			} else {
				$this->Session->setFlash(__('The invite could not be saved. Please, try again.'));
			}
		} else {
			//get group info
			$group=$this->Invite->Group->read(null,$group_id);
			if(!$group) {
				//invalid group
				$this->Session->setFlash(__('Invalid Group'));
				$this->redirect('/');
			}
			$admin=$this->Invite->Group->GroupsUser->field('admin',array('group_id'=>$group_id,'user_id'=>$this->Auth->user('id')));
			if(!$admin) {
				//not admin for this group
				$this->Session->setFlash(__('You are not an administrator for this group'));
				$this->redirect('/');
			}
			$this->request->data['Invite']['group_id']=$group_id;
			$this->request->data['Invite']['hash']=md5(uniqid(rand(),true));
			$this->set('group',$group);
		}
	}

	function _sendNewUserMail($id) {
		//sends email for a new user
		App::uses('CakeEmail', 'Network/Email');
		$invite=$this->Invite->read(null,$id);//debug($id);debug($user);
		if ($invite) {
			//found ok
			$mail=new CakeEmail('smtp');
			$mail->to($invite['Invite']['email']);
			$mail->subject('Sign up to use kDocs');
			$mail->replyTo($this->Auth->user('email'));
			$mail->from($this->Auth->user('email'));
//			$mail->from(array('kurtlakin@gmail.com'=>'My Site'));
			$mail->template('confirm_message');
			$mail->emailFormat('both');
			$mail->viewVars(array('invite'=>$invite));
			//mail options
/*			$mail->smtpOptions(array(
			    'port'=>'25',
			    'timeout'=>'30',
			    'host'=>'smtp.emailsrvr.com'
			));//*/
			$x=$mail->send();
//debug($x);exit;
		}
	}

	
/**
 * edit method
 *
 * @param string $id
 * @return void
	public function edit($id = null) {
		$this->Invite->id = $id;
		if (!$this->Invite->exists()) {
			throw new NotFoundException(__('Invalid invite'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Invite->save($this->request->data)) {
				$this->Session->setFlash(__('The invite has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The invite could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Invite->read(null, $id);
		}
		$groups = $this->Invite->Group->find('list');
		$users = $this->Invite->User->find('list');
		$this->set(compact('groups', 'users'));
	}
 */

/**
 * delete method
 *
 * @param string $id
 * @return void
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Invite->id = $id;
		if (!$this->Invite->exists()) {
			throw new NotFoundException(__('Invalid invite'));
		}
		if ($this->Invite->delete()) {
			$this->Session->setFlash(__('Invite deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Invite was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
 */
}
