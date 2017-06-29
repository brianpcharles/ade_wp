<? get_header(); ?>
<div class="col-md-9">
    <h2>Upcoming Gigs &amp; Shows</h2>
</div>

<div class="archive gig-container items">
    <?php

    if(have_posts()) : while(have_posts()) : the_post(); ?>
    <div class="gig item">
        <?php if(has_post_thumbnail()) : ?>
        <div class="col-md-3 hidden-sm hidden-xs">
            <div class="gig--thumbnail">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php the_post_thumbnail('ade-thumbnail'); ?>
                </a>
            </div>
        </div>
        <?php endif; ?>
        <div class="col-md-9">
            <div class="gig--title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
            <?php if($start_date = get_field('start_date_time')) : ?>
            <div class="gig--start-date"><?php echo date('M d, Y g:ia', strtotime(get_field('start_date_time'))); ?></div>
            <?php endif; ?>
            <div class="gig--excerpt"><?php echo substr(strip_tags($post->post_content), 0, 200); ?>...</div>
            <div class="gig--links">
                <ul>
                <?php if($location = get_field('location')) : ?>
                    <li><a href="https://www.google.com/maps/place/<?php echo $location['address']; ?>" title="View in Google Maps"><i class="fa fa-map-marker"></i></a></li>
                <?php endif; ?>
                <?php if($facebook_link = get_field('facebook_link')) : ?>
                    <li><a href="<?php echo $facebook_link; ?>" title="Facebook Event"><i class="fa fa-facebook"></i></a></li>
                <?php endif; ?>
                <?php if($ticket_link = get_field('purchase_tickets')) : ?>
                    <li><a href="<?php echo $ticket_link; ?>" title="Buy Tickets"><i class="fa fa-ticket"></i></a></li>
                <?php endif; ?>
                    <li><a href="<?php the_permalink(); ?>" title="Read More">Read More <i class="fa fa-long-arrow"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <?php endwhile; endif;?>
</div>


<? get_footer(); ?>
