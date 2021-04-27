<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://carlos-bucheli.com
 * @since      1.0.0
 *
 * @package    CABP_Resource_List
 * @subpackage CABP_Resource_List/public/partials
 */
?>

<table>
  <thead>
  <tr>
    <th>ID</th>
    <th>Title</th>
  </tr>
  </thead>
  {{#items}}
  <tr>
    <td>{{id}}</td>
    <td>{{title}}</td>
  </tr>
  {{/items}}
  <tbody>
  </tbody>
</table>
