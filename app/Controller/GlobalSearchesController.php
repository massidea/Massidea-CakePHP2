<?php
/**
 *  GlobalSearchController
 *
 *  This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 *  warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 *  more details.
 *
 *  You should have received a copy of the GNU General Public License along with this program; if not, write to the Free
 *  Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 *  License text found in /license/
 */

/**
 *  GlobalSearchController - class
 *  For Search Results
 *	TODO: -
 *  @package        Controllers
 *  @author         Manu Bamba
 *  @copyright      Manu Bamba
 *  @license        GPL v2
 *  @version        1.0
 */

class GlobalSearchesController extends AppController {
	public $uses = array('Content');
	function beforeFilter() {
		parent::beforeFilter();		
	}
	
	public function listResult() {
		$contents = $this->requestAction(
		    array('controller' => 'Contents', 'action' => 'search'),
		    array('pass' => array(5))
		);
		$this->set(compact('contents'));
	}
}