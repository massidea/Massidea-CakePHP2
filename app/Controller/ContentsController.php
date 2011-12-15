<?php
App::uses('AppController', 'Controller');
/**
 * Contents Controller
 *
 */
class ContentsController extends AppController {	
	public $components = array('Cookie', 'CookieValidation', 'Content_', 'DataHandler', 'Tag_', 'Company_', 'Search.Prg');
	public $validContentTypes = array('challenge','idea','vision');	
	public $uses = array('Language', 'Content', 'Campaign', 'Group', 'Profile');
	var $helpers = array('Tags.TagCloud');
	public $presetVars = array(
		array('field' => 'title', 'type' => 'value'),
	);
	
	/**
	* Browse action - method
	* Generates browse menu for contents
	*
	*
	* @author	Manu Bamba
	*/
	public function browse($contentType = 'all') {		
		$conditions = null;
		if($contentType = $this->Content_->validateContentType($contentType)) {
			$conditions = array(
				'class' => $contentType
			);		
		}
		else {			
			$contentType = 'all';
		}
		$contents = $this->Content->find('all',
			array(
				'contain' => array(
					'User' => array(
						'fields' => array(
							'id',
							'username'
						)
					),
					'Tag'					
				),
				'fields' => array(
					'id',
					'class',
					'title',
					'lead'
				),
				'limit' => 20,
				'order' => 'Content.created DESC',
				'conditions' => $conditions					
		));
		$userIdsAndCounts = array();	
		$recentCampaigns = $this->Campaign->find('all', array(
			'limit' => 5,
			'order' => 'created desc',
			'recursive' => 0,
			'fields' => array(
				'name',
				'id'
			)
		));
		$recentGroups = $this->Group->find('all', array(
			'limit' => 5,
			'order' => 'created desc',
			'recursive' => 0,
			'fields' => array(
				'name',
				'id'
			)
		));
		$activeUsers = $this->Content->find('all', array(
			'fields' => array(
				'count(Content.id) as total_contents',
				'User.username',
				'User.id'
			),
			'group' => 'user_id',
			'order' => 'total_contents desc',
			'limit' => 5,
			'recursive' => 0
			
		));
		$citiesOfUsers = $this->Profile->find('all', array(
			'fields' => array(
				'value',
				'user_id'
			),
			'conditions' => array(
				'key' => 'city',
				'user_id' => array(
					$activeUsers[0]['User']['id'],
					$activeUsers[1]['User']['id'],
					$activeUsers[2]['User']['id'],
					$activeUsers[3]['User']['id'],
					$activeUsers[4]['User']['id'],
				)
				
			)			
		));
		$userCities = array();
		foreach ($citiesOfUsers as $city) {			
			if($city['Profile']['value']) {
				$userCities[$city['Profile']['user_id']] = $city['Profile']['value'];
			} else {
				$userCities[$city['Profile']['user_id']] = 'Not defined';
			}
			
		}
		foreach($contents as $content) {
			if(isset($content['User']['id']) && !isset($userIdsAndCounts[$content['User']['id']])) {
				$userIdsAndCounts[$content['User']['id']] = $this->Content->find('count',
					array(
						'conditions' => array(
							'user_id' => $content['User']['id']
						)
					)
				);
			}
		}
		$this->set('tags', $this->Content->Tagged->find('cloud', array('limit' => 20)));
		$this->set('contentCounts',$userIdsAndCounts);
		$this->set('content_type',$contentType);
		$this->set('contents',$contents);
		$this->set(compact('recentCampaigns', 'recentGroups', 'activeUsers', 'userCities'));
	}
	/**
	* add action - method
	* Adds content
	*
	* Routes that direct to this action are:
	* Router::connect('/contents/add/*', array('controller' => 'contents', 'action' => 'add'));
	*
	* @author	Manu Bamba
	* @param	enum $content_type Accepted values: 'all', 'challenge', 'idea', 'vision'
	* @param	int	$related To what content this content will be linked to
	* @todo		Publishing
	*/
	public function add($contentType = 'challenge', $related = 0) {	
		if(isset($this->userId)) {
			if (!empty($this->request->data)) {				
				$this->request->data['Content']['user_id'] = $this->userId;
				$this->request->data['Content']['class'] = $contentType;
// 				$this->Company_->setCompaniesForSave($this->data['Companies']['companies']);
				$this->Content_->setAllContentDataForSave($this->request->data);
				if($this->Content_->saveContent()) { //If saving the content was successfull then...
					//TODO: This area is missing a method to link the $related content to this content. Should be done when the link method is ready.
					//$this->Company_->linkCompaniesToObject($this->Content_->getContentId());	
					$this->Session->setFlash('Your content has been successfully saved.', 'flash'.DS.'successfull_operation');
					if($this->Content_->getContentPublishedStatus() === "1") {
						$this->redirect(array('controller' => 'contents', 'action' => 'view', $this->Content_->getContentId()));
					} else {
						$this->redirect(array('controller' => 'contents', 'action' => 'edit', $this->Content_->getContentId()));
					}
				} else {
					$this->Session->setFlash('Your content has NOT been successfully saved.');
				}
			} else {
				$this->set('content_type', $contentType);
				$this->set('language_list',$this->Language->find('list',array('order' => array('Language.name' => 'ASC'))));
			}			
		} else {
			$this->redirect(array(
					'controller' => 'Users',
					'action' => 'login'
				)
			);
		}
	}
	
	/**
	 * edit action - method
	 * Edits content
	 *
	 * Routes that direct to this action are:
	 * Router::connect('/contents/edit/*', array('controller' => 'contents', 'action' => 'edit'));
	 *
	 * @author	Jari Korpela
	 * @param	int $contentId
	 */
	public function edit($contentId = -1) {
		if(isset($this->userId)) {				
			if (!empty($this->request->data)) {
				// If form has been posted	
				//check that the content id is owned by the user
				$content = $this->Content->find('first',
					array(
						'conditions' => array(
							'User.id' => $this->userId,
							'Content.id' => $contentId
						)
				));
				if($content) {
					$this->request->data['Content']['class'] =$content['Content']['class'];
					$this->request->data['Content']['id'] =$contentId;
					$this->Content_->setAllContentDataForSave($this->data);
					if($this->Content_->saveContent() !== false) {
						$this->Session->setFlash('Your content has been successfully saved.', 'flash'.DS.'successfull_operation');
						if($this->Content_->getContentPublishedStatus() === "1") {
							$this->redirect(array('controller' => 'contents', 'action' => 'view', $this->Content_->getContentId()));
						} else {
							$this->redirect(array('controller' => 'contents', 'action' => 'edit',$contentId));
						}
					} else {
						$this->Session->setFlash('Your content has NOT been successfully saved.');
						$this->redirect('Contents/edit/'.$contentId);
					}					
				} else {
					$this->Session->setFlash('You dont own that content so go away!');
					$this->redirect('/');
				}
			} else {				
				$content = $this->Content->find('first',
					array(
						'conditions' => array(
							'User.id' => $this->userId,
							'Content.id' => $contentId
						)
				));
				if(empty($content)) {
					$this->Session->setFlash('Invalid content ID');
					$this->redirect('/');
				} else {
					$this->Content_->setAllContentDataForEdit($content);
					$editData = $this->Content_->getContentDataForEdit();
					$this->data = $editData;

					$this->set('language_list',$this->Language->find('list',array('order' => array('Language.name' => 'ASC'))));
					$this->set('content_type',$content['Content']['class']);
					$this->set('content',$content);
				}
				
			}
		} else {
			$this->redirect('/');
		}
	}
	
	/**
	 * view action - method
	 * Views content
	 *
	 * @author	Jari Korpela
	 * @param	int $contentId
	 */
	public function view($contentId = -1) {
		if($contentId == -1) {
			$this->redirect('/');
		}
		$this->set('content_class','contentWithTopAndSidebar');
		$content = $this->Content->find('first',
			array(
				'conditions'=>array(
					'Content.id' => $contentId
				)
			)
		);
		if(empty($content)) {
			$this->Session->setFlash('Invalid content ID');
			$this->redirect('/');
		}
// 		debug($content);
		$contentUserId = $content['User']['id'];
		$isOwner = $contentUserId == $this->userId;
	
		$contentUsername = $content['User']['username'];
	
		$contentSpecificData = $this->DataHandler->parseExternals($content['Content']['data']);
		$tags = array();
		$relatedCompanies = array();
		if(isset($content['Child'])) {
			foreach($content['Child'] as $child) {
				if($child['type'] == 'Tag') {
					$tags[] = $child;
				} elseif ($child['type'] == 'RelatedCompany') {
					$relatedCompanies[] = $child;
				}
			}
		}
		
		$linkedContents = $content['LinkedContents'];
		$linkedContentsCount = sizeof($linkedContents);
	
// 		debug($linkedContents);die;
	
	
		$cookies = $this->CookieValidation->getAndValidateCookies('expandStatus');
		$this->set('cookies',$cookies);
		$this->set('isOwner',$isOwner);
		$this->set('contentId',$contentId);
		$this->set('content',$content['Content']);
		$this->set('contentUserId',$contentUserId);
		$this->set('contentUsername',$contentUsername);
		$this->set('language',$content['Language']);
		$this->set('tags',$tags);
		$this->set('relatedCompanies',$relatedCompanies);
		$this->set('specific',$contentSpecificData);
		$this->set('linkedContents',$linkedContents);
		$this->set('linkedContentsCount',$linkedContentsCount);
	
	}
	public function search($keyword) {
		$this->autoRender = false;
		$this->Prg->commonProcess();
		
	}
	
	
}
