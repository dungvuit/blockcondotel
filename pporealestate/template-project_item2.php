<div class="item">
    <a class="thumbnail" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
        <img alt="<?php the_title(); ?>" src="<?php the_post_thumbnail_url('400x250'); ?>"/>
        <span class="share-pro">
            <span class="pull-right">
                <span class="price">
                    <?php echo get_post_meta(get_the_ID(), "project_price", true); ?>
                </span>
            </span>
            <span class="clearfix"></span>
        </span>
    </a>
    <div class="row-pro">
        <h4>
            <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h4>
        <div class="date"><span class="glyphicon glyphicon-calendar"></span> <?php the_time('d/m/Y'); ?> </div>
        <div class="location">
            <label>Khu vực: </label>
            <?php echo get_post_meta(get_the_ID(), "khu_vuc", true); ?>
        </div>
        <div class="info-pro">
            <div class="supplier">
                <i class="fa fa-building" aria-hidden="true"></i> 
                <label>Nhà cung cấp: </label>
                <?php
                $supplier_id = get_post_meta(get_the_ID(), "supplier", true);
                if($supplier_id){
                    echo '<a href="' . get_permalink($supplier_id) . '" target="_blank">' . get_the_title($supplier_id) . '</a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>