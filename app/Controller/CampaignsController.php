<?php

class CampaignsController extends AppController
{



	function beforeFilter() {
		parent::beforeFilter();
	}
	function browse() {
		
	}
	
	function getRecentActive() {
		$this->autoLayout = false;
		$now  = date("Y-m-d");
		$activeCampaigns = $this->Campaign->find('all',	array(
					'limit' => 10,
					'order' => 'Campaign.created DESC',
					'fields' => array('name', 'lead','end_time', 'start_time', 'id'),
					'conditions' => array(
						 "AND" => array (
							'start_time <=' => $now,
							'end_time >=' => $now
		)
		)
		));
		$this->set(compact("activeCampaigns")) ;
	}
	
	function getRecentForthcoming(){
		$this->autoLayout = false;
		$now  = date("Y-m-d");
		$forthcomingCampaigns = $this->Campaign->find('all', array(
					'limit' => 10,
					'order' => 'Campaign.created DESC',
					'fields' => array('name', 'lead','end_time', 'start_time', 'id'),
					'conditions' => array(
						'start_time >' => $now,
		)
		));
		
		$this->set(compact("forthcomingCampaigns")) ;
		
	}
	
	
	function getRecentEnded() {
		$this->autoLayout = false;
		$now  = date("Y-m-d");
		$endedCampaigns = $this->Campaign->find('all', array(
					'limit' => 10,
					'order' => 'Campaign.created DESC',
					'recursive' => 0,
					'fields' => array(
						'name', 
						'lead',
						'end_time', 
						'start_time', 
						'id'
		),
					'conditions' => array(			
						'end_time <' => $now
		)
		));
		
		$this->set(compact("endedCampaigns")) ;
	}
	
	function add($groupId = null) {
		if($this->userId) {			
			if($this->getUserRole($groupId) == 'Admin') {
				
			}
			if(!empty($this->data)) {
				if ($this->request->is('post')) {	// post(not get) method is used from the view of this function and the data is passed from form in html.
					if($this->Campaign->saveAll($this->data)) {
						$campaignId = $this->Campaign->id;
						$this->Session->setFlash('The campaign has been successfully added');
						$this->redirect(array(
															'controller' => 'Campaigns',
															'action' => 'view', $campaignId
						));
					}
						
				} else {
					$this->redirect('/');
				}
			}
		} else {
			$this->redirect(array(
					'controller' => 'Users',
					'action' => 'login'
			));
		}
		$this->set(compact('groupId')) ;
	}
	
	function edit($campaignId = null) {
		$campaign = $this->Campaign->find('first', array(
			'conditions' => array(
				'id' => $campaignId
			)			
		));
	
		$groupId = $campaign['Group'][0]['id'];
		if($this->getUserRole($groupId) == 'Admin') {
			if($this->request->data) {
				if($this->Campaign->save($this->request->data)) {
					
				}
			} else {
				$this->data = $campaign;
			}
		} else {
			$this->redirect('/');
		}	
	}
	function getUserRole($groupId, $userId = null) {
		$userId = ($userId == null) ? $this->userId : $userId;
		$userIsAdmin = $this->Campaign->Group->GroupsUser->find('first', array(
			'conditions' => array(
				'User.id' => $userId,
				'Group.id' => $groupId
			),
			'recursive' => 2					
		));
		return $userIsAdmin['UserRole']['name'];
	}	
	
		
	
}
?>