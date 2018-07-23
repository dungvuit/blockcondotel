<div class="row item_product">
    <a class="col-sm-4 thumbnail" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
        <img alt="<?php the_title(); ?>" src="<?php the_post_thumbnail_url('170x115'); ?>"/>
    </a>
    <div class="row-pro col-sm-8">
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
        <div class="share-pro">
            <div class="pull-left"></div>
            <div class="pull-right">
                <span class="price">
                    <?php echo get_post_meta(get_the_ID(), "project_price", true); ?>
                </span>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>