<?php
/**
 * Tag_Component - class for tag managing
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied  
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for  
 * more details.
 * 
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the Free 
 * Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * License text found in /license/
 */

/**
 *  Tag_ -  class
 *
 *  @package    Components
 *  @author     Jari Korpela
 *  @copyright  2011 Jari Korpela
 *  @license    GPL v2
 *  @version    1.0
 */ 

class Tag_Component extends Component {
	var $components = array('DataHandler');
	
	private $__type = 'Tag';
	protected $_tags = array();
	protected $_tagList = array();
	protected $_newTags = array();
	protected $_newTagList = array();
	protected $_existingTags = array();
	protected $_privileges = array('privileges' => 555, 'creator' => NULL);
		
	public function linkTagsToContent($objectId = -1) {
		if($objectId != -1) {
			
		} else {
			return false;
		}
	}
	
	/**
	 * setTagsForSave
	 * @param string $tags
	 * @return Object Tag_Component
	 */
	public function setTagsForSave($tags) {
		$tags = explode(',',$tags); // Get tags to array
		$tagList = $this->DataHandler->striptagsAndTrimArrayValues($tags); // Trims of whitespaces etc.	
		$this->extractNewTags($tagList);
		$this->_tagList = $tagList;
		$this->_tags = $tags;
// 		$this->_newTags = $newTags;
// 		$this->_existingTags = $existingTags;
		
		return $this;
	}
	
	public function removeLinksToObject($objectId = -1) {
		if($objectId != -1) {
			$this->DataHandler->removeLinkBetween($objectId,$this->_existingTags); //Luomatta
		} else {
			return false;
		}
	}	
	
	public function getTags() {
		return $this->_tags;
	}
	public function getNewTags() {
		return $this->_newTags;
	}
	
	public function getNewAndExistingTags() {
		//var_dump($this->_newTags);
		//var_dump($this->_existingTags);die;
		return array_merge($this->_newTags,$this->_existingTags);
	}

	public function extractNewTags($tagList) {
		$Tag = ClassRegistry::init('Tag');
		foreach ($tagList as $tag) {
			$tagExists = $Tag->find('count', array(
				'conditions' => array(
					'Tag.name' => $tag
				)
			));
			if(!$tagExists) {
				$this->_newTags[] = $tag;
			}
		}
		return $this;
	}
	
}

