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
 */
	public function index() {
		$this->Doc->recursive = 0;
		$this->set('docs', $this->paginate());
	}

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
		$this->set('doc', $this->Doc->read(null, $id));
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
