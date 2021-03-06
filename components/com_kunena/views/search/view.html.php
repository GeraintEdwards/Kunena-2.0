<?php
/**
 * Kunena Component
 * @package Kunena.Site
 * @subpackage Views
 *
 * @copyright (C) 2008 - 2011 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

/**
 * Search View
 */
class KunenaViewSearch extends KunenaView {
	function displayDefault($tpl = null) {
		$this->assignRef ( 'message_ordering', $this->me->getMessageOrdering() );
//TODO: Need to move the select markup outside of view.  Otherwise difficult to stylize

		$this->searchwords = $this->get('SearchWords');

		$this->results = array ();
		$this->total = $this->get('Total');
		if ($this->total) {
			$this->results = $this->get('Results');
			$this->search_class = ' open';
			$this->search_style = ' style="display: none;"';
			$this->search_title = JText::_('COM_KUNENA_TOGGLER_EXPAND');
		} else {
			$this->search_class = ' close';
			$this->search_style = '';
			$this->search_title = JText::_('COM_KUNENA_TOGGLER_COLLAPSE');
		}

		$this->selected=' selected="selected"';
		$this->checked=' checked="checked"';
		$this->error = $this->get('Error');
		$this->display ();
	}

	function displaySearchResults() {
		if($this->results) {
			echo $this->loadTemplateFile('results');
		}
	}

	function displayModeList($id, $attributes = '') {
		$options	= array();
		$options[]	= JHTML::_('select.option',  '0', JText::_('COM_KUNENA_SEARCH_SEARCH_POSTS') );
		$options[]	= JHTML::_('select.option',  '1', JText::_('COM_KUNENA_SEARCH_SEARCH_TITLES') );
		echo JHTML::_('select.genericlist',  $options, 'titleonly', $attributes, 'value', 'text', $this->state->get('query.titleonly'), $id );
	}
	function displayDateList($id, $attributes = '') {
		$options	= array();
		$options[]	= JHTML::_('select.option',  'lastvisit', JText::_('COM_KUNENA_SEARCH_DATE_LASTVISIT') );
		$options[]	= JHTML::_('select.option',  '1', JText::_('COM_KUNENA_SEARCH_DATE_YESTERDAY') );
		$options[]	= JHTML::_('select.option',  '7', JText::_('COM_KUNENA_SEARCH_DATE_WEEK') );
		$options[]	= JHTML::_('select.option',  '14',  JText::_('COM_KUNENA_SEARCH_DATE_2WEEKS') );
		$options[]	= JHTML::_('select.option',  '30', JText::_('COM_KUNENA_SEARCH_DATE_MONTH') );
		$options[]	= JHTML::_('select.option',  '90', JText::_('COM_KUNENA_SEARCH_DATE_3MONTHS') );
		$options[]	= JHTML::_('select.option',  '180', JText::_('COM_KUNENA_SEARCH_DATE_6MONTHS') );
		$options[]	= JHTML::_('select.option',  '365', JText::_('COM_KUNENA_SEARCH_DATE_YEAR') );
		$options[]	= JHTML::_('select.option',  'all', JText::_('COM_KUNENA_SEARCH_DATE_ANY') );
		echo JHTML::_('select.genericlist',  $options, 'searchdate', $attributes, 'value', 'text', $this->state->get('query.searchdate'), $id );
	}
	function displayBeforeAfterList($id, $attributes = '') {
		$options	= array();
		$options[]	= JHTML::_('select.option',  'after', JText::_('COM_KUNENA_SEARCH_DATE_NEWER') );
		$options[]	= JHTML::_('select.option',  'before', JText::_('COM_KUNENA_SEARCH_DATE_OLDER') );
		echo JHTML::_('select.genericlist',  $options, 'beforeafter', $attributes, 'value', 'text', $this->state->get('query.beforeafter'), $id );
	}
	function displaySortByList($id, $attributes = '') {
		$options	= array();
		$options[]	= JHTML::_('select.option',  'title', JText::_('COM_KUNENA_SEARCH_SORTBY_TITLE') );
//		$options[]	= JHTML::_('select.option',  'replycount', JText::_('COM_KUNENA_SEARCH_SORTBY_POSTS') );
		$options[]	= JHTML::_('select.option',  'views', JText::_('COM_KUNENA_SEARCH_SORTBY_VIEWS') );
//		$options[]	= JHTML::_('select.option',  'threadstart', JText::_('COM_KUNENA_SEARCH_SORTBY_START') );
		$options[]	= JHTML::_('select.option',  'lastpost', JText::_('COM_KUNENA_SEARCH_SORTBY_POST') );
//		$options[]	= JHTML::_('select.option',  'postusername', JText::_('COM_KUNENA_SEARCH_SORTBY_USER') );
		$options[]	= JHTML::_('select.option',  'forum', JText::_('COM_KUNENA_SEARCH_SORTBY_FORUM') );
		echo JHTML::_('select.genericlist',  $options, 'sortby', $attributes, 'value', 'text', $this->state->get('query.sortby'), $id );
	}
	function displayOrderList($id, $attributes = '') {
		$options	= array();
		$options[]	= JHTML::_('select.option',  'inc', JText::_('COM_KUNENA_SEARCH_SORTBY_INC') );
		$options[]	= JHTML::_('select.option',  'dec', JText::_('COM_KUNENA_SEARCH_SORTBY_DEC') );
		echo JHTML::_('select.genericlist',  $options, 'order', $attributes, 'value', 'text', $this->state->get('query.order'), $id );
	}
	function displayLimitList($id, $attributes = '') {
		// Limit value list
		$options	= array();
		$options[]	= JHTML::_('select.option',  '5', JText::_('COM_KUNENA_SEARCH_LIMIT5') );
		$options[]	= JHTML::_('select.option',  '10', JText::_('COM_KUNENA_SEARCH_LIMIT10') );
		$options[]	= JHTML::_('select.option',  '15', JText::_('COM_KUNENA_SEARCH_LIMIT15') );
		$options[]	= JHTML::_('select.option',  '20', JText::_('COM_KUNENA_SEARCH_LIMIT20') );
		echo JHTML::_('select.genericlist',  $options, 'limit', $attributes, 'value', 'text',$this->state->get('list.limit'), $id );
	}
	function displayCategoryList($id, $attributes = '') {
		//category select list
		$options	= array ();
		$options[]	= JHTML::_ ( 'select.option', '0', JText::_('COM_KUNENA_SEARCH_SEARCHIN_ALLCATS') );

		$cat_params = array ('sections'=>true);
		echo JHTML::_('kunenaforum.categorylist', 'catids[]', 0, $options, $cat_params, $attributes, 'value', 'text', $this->state->get('query.catids'), $id);
	}

	function displayRows() {
		$this->row(true);

		// Run events
		$params = new JParameter( '' );
		$params->set('ksource', 'kunena');
		$params->set('kunena_view', 'search');
		$params->set('kunena_layout', 'default');

		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('kunena');

		$dispatcher->trigger('onKunenaPrepare', array ('kunena.messages', &$this->results, &$params, 0));

		foreach ($this->results as $this->message) {
			$this->topic = $this->message->getTopic();
			$this->category = $this->message->getCategory();
			$this->categoryLink = $this->getCategoryLink($this->category->getParent()) . ' / ' . $this->getCategoryLink($this->category);
			$ressubject = KunenaHtmlParser::parseText ($this->message->subject);
			$resmessage = $this->parse ($this->message->message, 500);

			foreach ( $this->searchwords as $searchword ) {
				if (empty ( $searchword )) continue;
				$ressubject = preg_replace ( "/" . preg_quote ( $searchword, '/' ) . "/iu", '<span  class="searchword" >' . $searchword . '</span>', $ressubject );
				// FIXME: enable highlighting, but only after we can be sure that we do not break html
				//$resmessage = preg_replace ( "/" . preg_quote ( $searchword, '/' ) . "/iu", '<span  class="searchword" >' . $searchword . '</span>', $resmessage );
			}
			$this->author = $this->message->getAuthor();
			$this->topicAuthor = $this->topic->getAuthor();
			$this->topicTime = $this->topic->first_post_time;
			$this->subjectHtml = $ressubject;
			$this->messageHtml = $resmessage;

			$contents = $this->loadTemplateFile('row');
			$contents = preg_replace_callback('|\[K=(\w+)(?:\:([\w-_]+))?\]|', array($this, 'fillTopicInfo'), $contents);
			echo $contents;
		}
	}

	function fillTopicInfo($matches) {
		switch ($matches[1]) {
			case 'ROW':
				return $matches[2].$this->row().($this->topic->ordering ? " {$matches[2]}sticky" : '');
			case 'TOPIC_ICON':
				return $this->topic->getIcon();
			case 'DATE':
				$date = new KunenaDate($matches[2]);
				return $date->toSpan('config_post_dateformat', 'config_post_dateformat_hover');
		}
	}

	function getPagination($maxpages) {
		$pagination = new KunenaHtmlPagination ( $this->total, $this->state->get('list.start'), $this->state->get('list.limit') );
		$pagination->setDisplay($maxpages);
		return $pagination->getPagesLinks();
	}
}