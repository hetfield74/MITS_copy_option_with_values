<?php
/**
 * --------------------------------------------------------------
 * File: mits_copy_option_with_values.php
 * Date: 19.10.2019
 * Time: 13:04
 *
 * Author: Hetfield
 * Copyright: (c) 2019 - MerZ IT-SerVice
 * Web: https://www.merz-it-service.de
 * Contact: info@merz-it-service.de
 * --------------------------------------------------------------
 */

if (basename($PHP_SELF) == FILENAME_PRODUCTS_ATTRIBUTES && is_object($oInfo)) {
  $MITS_CopyOptionAndValues = '<table class="contentTable"><tbody><tr class="infoBoxHeading"><td class="infoBoxHeading" style="text-align:center"><a class="button" id="copy_option_and_values" onclick="this.blur();" href="' . xtc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, xtc_get_all_get_params(array('action', 'search', 'oID')) . 'action=copy_option_and_values&oID=' . $oInfo->products_options_id) . '">Option inkl. der Werte kopieren</a></td></tr></tbody></table>';
  ?>
  <script>
    $(document).ready(function () {
      $('.boxRight .contentTable:last').after('<?php echo $MITS_CopyOptionAndValues;?>');
    });
  </script>
  <style>
    #copy_option_and_values{text-align:center;margin:0 auto}
  </style>
  <?php
}