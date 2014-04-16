<?php
App::uses('PollsAppController', 'Polls.Controller');
/**
 * Polls Controller
 *
 * @property Poll $Poll
 */
class PollsController extends PollsAppController {
	public $components = array(
        "RequestHandler", "Cookie",
        'Security'
        );
/**
 * Name
 *
 * @var string
 */
	public $name = 'Polls';

/**
 * Uses model
 *
 * @var string
 */
	public $uses = 'Polls.Poll';


/**
 * beforeFilter callback
 *
 */
	public function beforeFilter(){
		$this->Security->unlockedActions = array('admin_edit', 'admin_add', 'submit_poll');
		parent::beforeFilter();
	}
/**
 * check IP & save poller to list
 *
 * @param string $id
 * @return void
 */

	private function checkExistIP($id, $saveIP = false){
		App::import('Vendor', 'Polls.Flatfile', array('file'=>'flatfile.php'));
		//initial flatfile database
		$ff = new Flatfile();
		$ff->datadir = TMP.DS.'cache'.DS;
		$ip_file = $id.'.txt';

		//check ip already access this page?
		$ip_result = $ff->selectUnique($ip_file, 0, $_SERVER['REMOTE_ADDR']);
		//if the first time visit this page -> save in the list
		if (empty($ip_result)) {
			if($saveIP){
			    $ip[0] = $_SERVER['REMOTE_ADDR'];
			    $ff->insert($ip_file, $ip);
			}
	    	return false;
		}

		return true;
	}
/*
* Ajax get answers by question id
* Type: Json
*/
    public function get_answers($questionId) {
    	$this->autoRender = false;

    	if(!$questionId){
    		return '[]';
    	}

        $answers = $this->Poll->PollOption->find('all', array(
        				'conditions'=>array('PollOption.poll_id'=>$questionId),
        				'order'=>array('PollOption.ordered'=>'ASC')
        			));
        $answersList = array();
        foreach ($answers as $answer) {
        	$answersList[] = array('id'=>$answer['PollOption']['id'],'text'=>$answer['PollOption']['option'], 'ordered'=>$answer['PollOption']['ordered']);
        }
        echo json_encode($answersList);
    }
/**
 * submit_poll method
 *
 * @return boolean
 */
	public function submit_poll(){
		$this->autoRender = false;

		if ($this->request->is('post') || $this->request->is('put')) {
			$id = $this->request->data['PollVote']['poll_id'];
			if($this->Poll->PollVote->save($this->request->data)){
				//save IP
				$this->checkExistIP($id, true);
				//save cookie
				$this->Cookie->write('YouPoll_'.$id, true);
				return true;
			}

		}
		return false;
	}


/**
 * get_poll method
 *
 * @param string $id
 * @return void
 */
	public function get_poll($id = null) {
		$this->autoRender = false;

		$poll_data = array();
		$conditions = array();
		if($id){
			$conditions = array('Poll.id' => $id);
		}

		$poll = $this->Poll->find('first', array(
				'conditions' => $conditions,
				'order' => array('Poll.created' => 'DESC'),
				'contain' => array(
					'PollOption'=>array('order'=>array('PollOption.ordered'=>'ASC'))
				)
		));

		if(!empty($poll)){
			$id = $poll['Poll']['id'];
		}

		//check IP and cookie of poller
		$alreadyVoted = $this->checkExistIP($id);

		if($alreadyVoted && $this->Cookie->read('YouPoll_'.$id)){
			$poll_data['graph'] = 1;
			$poll_data['poll_id'] = $poll['Poll']['id'];
			$poll_data['question'] = $poll['Poll']['question'];
			$poll_data['description'] = $poll['Poll']['description'];

			$totalVote = 0;
			foreach ($poll['PollOption'] as $p) {
				$totalVote += $p['vote_count'];
			}

			foreach ($poll['PollOption'] as $p) {
				$percent = round(( $p['vote_count']/$totalVote)*100);
				$poll_data['answers'][] = array('id'=>$p['id'], 'answer' => $p['option'], 'percent'=>$percent);
			}
			$poll_data['total_votes'] = $totalVote;

		}else{
			$poll_data['graph'] = 0;
			$poll_data['poll_id'] = $poll['Poll']['id'];
			$poll_data['question'] = $poll['Poll']['question'];
			$poll_data['description'] = $poll['Poll']['description'];

			$poll_data['answers'] = array();
			foreach ($poll['PollOption'] as $p) {
				$poll_data['answers'][] = array('id'=>$p['id'], 'answer' => $p['option']);
			}
		}

		return json_encode($poll_data);
	}
/**
 * view poll method
 *
 * @param string $id
 * @return void
 */
	public function index($id = null) {
		$this->Poll->id = $id;
		if (!$this->Poll->exists()) {
			throw new NotFoundException(__d('polls','Invalid poll'));
		}

		$poll = $this->Poll->find('first', array(
				'conditions' => array('Poll.id'=>$id),
				'order' => array('Poll.created' => 'DESC'),
				'contain' => array(
						'PollOption'=>array('order'=>array('PollOption.ordered'=>'ASC')),
						'PollVote'
					)
		));

		$this->set(compact('id', 'poll'));
	}

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Poll->recursive = 0;
		$this->paginate = array(
		    'order' => array('Poll.created'=>'DESC')
		);
		$this->set('polls', $this->paginate());
	}



/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Poll->id = $id;
		if (!$this->Poll->exists()) {
			throw new NotFoundException(__d('polls','Invalid poll'));
		}

		$poll = $this->Poll->find('first', array(
				'conditions' => array('Poll.id'=>$id),
				'order' => array('Poll.created' => 'DESC'),
				'contain' => array(
						'PollOption'=>array('order'=>array('PollOption.ordered'=>'ASC')),
						'PollVote'
					)
		));

		$this->set(compact('id', 'poll'));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Poll->create();
			//pr($this->request->data);exit;
			if ($this->Poll->saveAll($this->request->data)) {
				$this->Session->setFlash(__d('polls','The poll has been saved', 'flash/success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('polls','The poll could not be saved. Please, try again.', 'flash/error'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Poll->id = $id;
		if (!$this->Poll->exists()) {
			throw new NotFoundException(__d('polls','Invalid poll'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			//pr($this->request->data);exit;
			//$this->Poll->PollOption->deleteAll(array('PollOption.poll_id'=>$id));
			if ($this->Poll->saveAll($this->request->data)) {
				$this->Session->setFlash(__d('polls','The poll has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('polls','The poll could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$this->request->data = $this->Poll->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Poll->id = $id;
		if (!$this->Poll->exists()) {
			throw new NotFoundException(__d('polls','Invalid poll'));
		}
		if ($this->Poll->delete()) {
			$this->Poll->PollOption->deleteAll(array('PollOption.poll_id'=>$id));
			$this->Poll->PollVote->deleteAll(array('PollOption.poll_id'=>$id));
			$this->Session->setFlash(__d('polls','Poll deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('polls','Poll was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
