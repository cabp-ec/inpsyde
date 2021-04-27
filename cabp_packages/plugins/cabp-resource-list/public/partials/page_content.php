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

<div id="cabp_rlist_dialog" title="Resource Details"></div>

<table>
  <thead>
  <tr>
    <th>ID</th>
    <th>NAME</th>
    <th>USERNAME</th>
  </tr>
  </thead>

  <tbody>
  <?php foreach ($items as $item) { ?>
    <tr>
      <td>
        <a href="#"
           data-item="<?=$item['id']?>"
           class="rlist_detail"><?=$item['id']?></a>
      </td>
      <td>
        <a href="#"
           data-item="<?=$item['id']?>"
           class="rlist_detail"><?=$item['name']?></a>
      </td>
      <td>
        <a href="#"
           data-item="<?=$item['id']?>"
           class="rlist_detail"><?=$item['username']?></a>
      </td>
    </tr>
  <?php } ?>
  </tbody>
</table>
