<?php
/**
 * Kunena Component
 * @package Kunena.Template.Mirage
 * @subpackage Topics
 *
 * @copyright (C) 2008 - 2012 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();
?>
<div class="kmodule topics_default_list">
	<form action="<?php echo KunenaRoute::_('index.php?option=com_kunena&view=topics') ?>" method="post">
		<?php echo JHTML::_( 'form.token' ); ?>

		<div class="kbox-wrapper kbox-full">
			<div class="topics-default_list-kbox kbox kbox-full kbox-color kbox-border kbox-border_radius kbox-border_radius-vchild kbox-shadow">
				<div class="headerbox-wrapper kbox-full">
					<div class="header">
						<h2 class="header"><a class="section link-header2" rel="topic-detailsbox"><?php echo $this->headerText ?></a> (<strong><?php echo intval($this->total) ?></strong>
						<?php echo JText::_('COM_KUNENA_DISCUSSIONS')?>)</h2>
					</div>
				</div>
				<div class="detailsbox-wrapper innerspacer kbox-full">
					<div class="topics-default_list-detailsbox detailsbox kbox-full kbox-border kbox-border_radius kbox-shadow">
						<ul class="list-unstyled topic-list">
							<li class="header kbox-hover_header-row kbox-full">
								<dl class="list-unstyled list-unstyled">
									<!--<dd class="topic-icon">
									</dd>-->
									<dd class="topic-subject">
										<div class="innerspacer-header">
											<?php //FIXME: Translate ?>
											<span class="bold"><?php echo JText::_('Subject') ?></span>
										</div>
									</dd>
									<dd class="topic-replies">
										<div class="innerspacer-header">
											<span class="bold"><?php echo JText::_('COM_KUNENA_GEN_REPLIES') ?></span>
										</div>
									</dd>
									<dd class="topic-views">
										<div class="innerspacer-header">
											<span class="bold"><?php echo JText::_('COM_KUNENA_GEN_HITS') ?></span>
										</div>
									</dd>
									<dd class="topic-lastpost">
										<div class="innerspacer-header">
											<?php //FIXME: Translate ?>
											<span class="bold"><?php echo JText::_('Last Post') ?></span>
										</div>
									</dd>
									<?php if ($this->topicActions) : ?>
										<dd class="topic-checkbox">
											<div class="innerspacer-header">
												<span><input id="kcheckbox-all" type="checkbox" value="" name="toggle" class="kcheckall" /></span>
											</div>
										</dd>
									<?php endif; ?>
								</dl>
							</li>
						</ul>
						<ul class="list-unstyled topic-list">
							<?php if (empty($this->topics )) : ?>
								<li class="topic-row">
									<dl class="list-unstyled">
										<dd class="topic-none">
											<div class="innerspacer-column">
												<?php echo JText::_('COM_KUNENA_VIEW_RECENT_NO_TOPICS'); ?>
											</div>
										</dd>
									</dl>
								</li>
							<?php else : $this->displayRows(); endif ?>
						</ul>
					</div>
				</div>
				<?php if ($this->topicActions) : ?>
					<div class="modbox-wrapper innerspacer-bottom">
						<div class="modbox">
							<button class="kbutton button-type-standard fr" type="submit"><span><?php echo JText::_('COM_KUNENA_TOPICS_MODERATION_PERFORM'); ?></span></button>
							<?php echo JHTML::_('select.genericlist', $this->topicActions, 'task', 'class="form-horizontal fr" size="1"', 'value', 'text', 0, 'kmoderate-select');
							$options = array (JHTML::_ ( 'select.option', '0', JText::_('COM_KUNENA_BULK_CHOOSE_DESTINATION') ));
							echo JHTML::_('kunenaforum.categorylist', 'target', 0, $options, array(), 'class="form-horizontal" size="1" style="display:none;"', 'value', 'text', 0, 'kcategorytarget'); ?>
						</div>
					</div>
				<?php endif ?>
			</div>
		</div>
	</form>
</div>

