<div class="fooevents-calendar-list">
    <?php if(!empty($events)) :?>    
    <?php foreach($events as $event) : ?>
        <?php if (is_array($event)) :?>
        <?php $thumbnail = get_the_post_thumbnail_url($event['post_id']); ?>
        <div class="fooevents-calendar-list-item">
            <h3 class="fooevents-shortcode-title"><a href="<?php $permalink = get_the_permalink($event['post_id']); echo $permalink; ?>"><?php echo esc_html($event['title']); ?></a></h3>
            <p class="fooevents-shortcode-date"><?php echo $event['unformated_date']; ?></p>
            <?php if(!empty($thumbnail)) :?>
            <img src="<?php echo $thumbnail; ?>" class="fooevents-calendar-list-thumb"/>
            <?php endif; ?>
            <?php if(!empty($event['desc'])) : ?>
            <p><?php echo wp_kses_post($event['desc']); ?></p>
            <?php endif; ?>
            <p><a class="button" href="<?php echo $permalink; ?>" rel="nofollow"><?php echo esc_html($event['ticketTerm']); ?></a></p>
            <div class="foo-clear"></div>
        </div>
        <div class="fooevents-calendar-clearfix"></div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else : ?>
    <?php _e('No upcoming events.', 'fooevents-calendar'); ?>
<?php endif; ?>    
</div>