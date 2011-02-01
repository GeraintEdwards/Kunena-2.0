<?php
/**
 * @version		$Id$
 * Kunena Component
 * @package Kunena
 *
 * @Copyright (C) 2008 - 2010 Kunena Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 */
defined ( '_JEXEC' ) or die ();

jimport ( 'joomla.application.component.model' );

/**
 * Trash Model for Kunena
 *
 * @package		Kunena
 * @subpackage	com_kunena
 * @since		1.6
 */
class KunenaAdminModelTrash extends JModel {
	protected $__state_set = false;
	protected $_items = false;
	protected $_items_order = false;
	protected $_object = false;


	/**
	 * Overridden method to get model state variables.
	 *
	 * @param	string	Optional parameter name.
	 * @param	mixed	Optional default value.
	 * @return	mixed	The property where specified, the state object where omitted.
	 * @since	1.6
	 */
	public function getState($property = null) {
		if (! $this->__state_set) {
			$this->__state_set = true;
		}
		return parent::getState ( $property );
	}

	/**
	 * Method to get all deleted items.
	 *
	 * @return	Array
	 * @since	1.6
	 */
	 public function getItems() {
	 	kimport('kunena.error');
		$kunena_db = &JFactory::getDBO ();
		// FIXME: use library
		// FYI: we have now topics and messages
		// Both topics and messages can be either deleted or unapproved
		// Visible topics can have deleted messages in them
		// In deleted topics there can be messages that have been deleted individually (which should remain deleted when topic gets restored)
		// So having just one trash manager isn't enough
		// We need to be able restore both topics (with all deleted messages) and individual messages
		// For that we need to have views for both topics and messages
		// Talk with Matias

		$where 	= ' WHERE hold=3 ';
		$query = 'SELECT a.*, b.name AS cats_name, c.username FROM #__kunena_messages AS a
		INNER JOIN #__kunena_categories AS b ON a.catid=b.id
		LEFT JOIN #__users AS c ON a.userid=c.id'
		.$where;

		$kunena_db->setQuery ( $query );
		$trashitems = $kunena_db->loadObjectList ();
		if (KunenaError::checkDatabaseError()) return;

		return $trashitems;
	}

	/**
	 * Method to get cids from session.
	 *
	 * @return	Array
	 * @since	1.6
	 */
	protected function _getCids() {
		// FIXME: this should be in state
		$app = JFactory::getApplication ();
		$ids = $app->getUserState('com_kunena.purge');

		return $ids;
	}

	/**
	 * Method to get details on selected items.
	 *
	 * @return	Array
	 * @since	1.6
	 */
	public function getPurgeItems() {
		kimport('kunena.error');
		$kunena_db = &JFactory::getDBO ();
		$ids = $this->_getCids();

		$ids = implode ( ',', $ids );
		// FIXME: new logic needed
		$kunena_db->setQuery ( "SELECT * FROM #__kunena_messages WHERE hold=2 AND id IN ($ids)");
		$items = $kunena_db->loadObjectList ();
		if (KunenaError::checkDatabaseError()) return;

		return $items;
	}

	/**
	 * Method to hash datas.
	 *
	 * @return	hash
	 * @since	1.6
	 */
	public function getMd5() {
		$ids = $this->_getCids();

		return md5(serialize($ids));
	}

	public function getNavigation() {
		jimport ( 'joomla.html.pagination' );
		$navigation = new JPagination ($this->getState ( 'list.total'), $this->getState ( 'list.start'), $this->getState ( 'list.limit') );
		return $navigation;
	}
}