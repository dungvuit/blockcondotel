<div class="faq">
    <h2 class="widget-title"><?php _e('HỎI ĐÁP <span>NHANH</span>', SHORT_NAME) ?></h2>
    <p><?php _e('Một số thắc mắc thường gặp?', SHORT_NAME) ?></p>
    <div id="accordion">
        <?php
        $loop = new WP_Query(array(
            'post_type' => 'qna',
            'showposts' => -1,
        ));
        while ($loop->have_posts()): $loop->the_post();
        ?>
        <h3 class="accordion-title">
            <a href="javascript://">
                <span><i class="fa fa-bookmark-o" aria-hidden="true"></i></span><?php the_title() ?>
            </a>
        </h3>
        <div style="display: none"><?php the_content() ?></div>
        <?php
        endwhile;
        wp_reset_query();
        ?>
    </div>
</div>