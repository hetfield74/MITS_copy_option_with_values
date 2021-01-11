<?php
/**
 * --------------------------------------------------------------
 * File: mits_copy_option_with_values.php
 * Date: 11.01.2021
 * Time: 15:24
 *
 * Author: Hetfield
 * Copyright: (c) 2021 - MerZ IT-SerVice
 * Web: https://www.merz-it-service.de
 * Contact: info@merz-it-service.de
 * --------------------------------------------------------------
 */

function mits_copy_option_with_values($oID) {

  $next_options_id_query = xtc_db_query("SELECT max(products_options_id) as products_options_id FROM " . TABLE_PRODUCTS_OPTIONS);
  $next_options_id = xtc_db_fetch_array($next_options_id_query);
  $options_id = $next_options_id['products_options_id'] + 1;

  $options_query = xtc_db_query("SELECT * FROM " . TABLE_PRODUCTS_OPTIONS . " WHERE products_options_id = " . xtc_db_prepare_input((int)$oID));
  while ($options = xtc_db_fetch_array($options_query)) {
    $sql_data_array = array('products_options_id' => $options_id,
                            'products_options_name' => $options['products_options_name'],
                            'language_id' => $options['language_id'],
                            'products_options_sortorder' => $options['products_options_sortorder'],
    );
    xtc_db_perform(TABLE_PRODUCTS_OPTIONS, $sql_data_array);
  }

  $values_query_raw = "SELECT pov.*
                         FROM " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov
                         JOIN " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " pov2po
                              ON pov2po.products_options_values_id = pov.products_options_values_id
                        WHERE pov2po.products_options_id = " . xtc_db_prepare_input((int)$oID);
  $values_query = xtc_db_query($values_query_raw);
  while ($values = xtc_db_fetch_array($values_query)) {
    if (isset($last_values_id) && $last_values_id == $values['products_options_values_id']) {

    } else {
      $next_values_id_query = xtc_db_query("SELECT max(products_options_values_id) as products_options_values_id FROM " . TABLE_PRODUCTS_OPTIONS_VALUES);
      $next_values_id = xtc_db_fetch_array($next_values_id_query);
      $values_id = $next_values_id['products_options_values_id'] + 1;

      $sql_data_array = array('products_options_id' => $options_id,
                              'products_options_values_id' => $values_id,
      );
      xtc_db_perform(TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS, $sql_data_array);
    }

    $sql_data_array = array('products_options_values_id' => $values_id,
                            'products_options_values_name' => $values['products_options_values_name'],
                            'language_id' => $values['language_id'],
                            'products_options_values_sortorder' => $values['products_options_values_sortorder'],
    );
    xtc_db_perform(TABLE_PRODUCTS_OPTIONS_VALUES, $sql_data_array);

    $last_values_id = $values['products_options_values_id'];
  }

}

if (basename($PHP_SELF) == FILENAME_PRODUCTS_ATTRIBUTES
  && isset($_GET['action']) && $_GET['action'] == 'copy_option_and_values'
  && isset($_GET['oID']) && !empty($_GET['oID'])
) {
  mits_copy_option_with_values($_GET['oID']);
  $messageStack->add_session('Die Option mit der ID ' . $_GET['oID'] . ' inkl. der zugeh&ouml;rigen Werte wurde kopiert', 'success');
  xtc_redirect(xtc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, xtc_get_all_get_params(array('action', 'oID'))));
}