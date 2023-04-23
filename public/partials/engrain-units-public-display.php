<?php

/**
 * Provide a public-facing view for the plugin
 *
 * In our case, only used as a snippet for a shortcode contents.
 *
 * @link       https://github.com/buynyakov/engrain-units
 * @since      1.0.0
 *
 * @package    Engrain_Units
 * @subpackage Engrain_Units/public/partials
 */

?>
<p>
<div class="X">
<?php foreach($posts as $section_title => $section_posts): ?>
    <h3><?php echo $section_title?></h3>
    <ul class="SG">
    <?php foreach($section_posts as $post): ?>
        <li class="sgLi">
            <div class="box">
            <div><b>unit_number: <?php echo $post->post_title?></b></div>
            <ul>
                <?php foreach( array('area', 'asset_id', 'building_id', 'floor_id', 'floor_plan_id') as $meta_key): ?>
                    <li><b><?php echo $meta_key; ?>:</b> <?php echo get_post_meta($post->ID, $meta_key, true)?></li>
                <?php endforeach;?>
            </ul>
            </div>
        </li> 
    <?php endforeach; ?>
    </ul>
<?php endforeach; ?>
</div>
</p>