<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>

<?php if (\CommerceLabShop\Config\ConfigFactory::getAvailableUpdate()) : ?>
   <a href="index.php?option=com_installer&view=update"
      target="_blank"
      data-uk-tooltip="title:Available Update; pos: bottom;"
      class="uk-margin-small-top uk-text-xsmall uk-text-danger uk-display-block uk-text-center"
      title="" aria-expanded="false"> <?= \CommerceLabShop\Config\ConfigFactory::getAvailableUpdate(); ?>
   </a>
   <h6 class="uk-margin-remove">Update Available</h6>
<?php endif; ?>
