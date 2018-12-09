<div class="fooevents-calendar-list">
<?php foreach($events as $event) : ?>
    <?php if (is_array($event)) :?>
    <?php $thumbnail = get_the_post_thumbnail_url($event['post_id']); ?>
    <div class="fooevents-calendar-list-item">
        <h3 class="fooevents-shortcode-title"><a href="<?php $permalink = get_the_permalink($event['post_id']); echo $permalink; ?>"><?php echo $event['title']; ?></a></h3>
        <p class="fooevents-shortcode-date"><?php echo $event['unformated_date']; ?></p>
        <?php if(!empty($thumbnail)) :?>
        <img src="<?php echo $thumbnail; ?>" class="fooevents-calendar-list-thumb"/>
        <?php endif; ?>
        <?php if(!empty($event['desc'])) : ?>
        <p><?php echo $event['desc']; ?></p>
        <?php endif; ?>
        <p><a class="button" href="<?php echo $permalink; ?>" rel="nofollow"><?php echo $event['ticketTerm']; ?></a></p>
    </div>
    <div class="fooevents-calendar-clearfix"></div>
    <?php endif; ?>
<?php endforeach; ?>
</div>