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
			if ($this->Doc->save($this->request->data)) {
				$this->Session->setFlash(__('The doc has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doc could not be saved. Please, try again.'));
			}
		}
		$users = $this->Doc->User->find('list');
		$groups = $this->Doc->Group->find('list');
		$editors = $this->Doc->Editor->find('list');
		$uploadedfiles = $this->Doc->Uploadedfile->find('list');
		$users = $this->Doc->User->find('list');
		$this->set(compact('users', 'groups', 'editors', 'uploadedfiles', 'users'));
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
				$this->redirect(array('action' => 'index'));
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
