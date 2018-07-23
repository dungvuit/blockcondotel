<?php 
/*
  Template Name: Thành viên
 */
get_header(); 
?>
<div class="container main_content">
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="products">
        <div class="section-header">
            <div class="list-header">
                <h1 class="span-title">Thành viên nổi bật</h1>
            </div>
        </div>
        <div class="user_list mb30">
            <div class="row">
                <?php 
                $authors = get_users( array(
                    'role'         => 'author',
                    'orderby'      => 'post_count',
                    'order'        => 'DESC',
                    'number'       => '',
                    'fields'       => 'all',
                    'offset'       => 0,
                ) );
                if(count($authors) > 0){
                    show_member_list($authors);
                } else {
                    echo '<div class="col-sm-12">Không có thành viên nào!</div>';
                }
                ?>
            </div>
        </div>
        
        <div class="section-header">
            <div class="list-header">
                <h1 class="span-title">Thành viên tích cực</h1>
            </div>
        </div>
        <div class="user_list">
            <div class="row">
                <?php 
                $number = 16;
                $count_users = count_users();
                $total_users = $count_users['avail_roles']['contributor'];
                $paged = get_query_var('paged');
                $users = get_users( array(
                    'role'         => 'contributor',
                    'orderby'      => 'post_count',
                    'order'        => 'DESC',
                    'number'       => $number,
                    'fields'       => 'all',
                    'offset'       => $paged ? ($paged - 1) * $number : 0,
                ) );
                show_member_list($users);
                ?>
            </div>
            <div class="paging">
                <?php
                // Pagination
                if ($total_users > $number) {
                    $pl_args = array(
                        'base' => add_query_arg('paged', '%#%'),
                        'format' => '',
                        'total' => ceil($total_users / $number),
                        'current' => max(1, $paged),
                    );

                    // for ".../page/n"
                    if ($GLOBALS['wp_rewrite']->using_permalinks())
                        $pl_args['base'] = user_trailingslashit(trailingslashit(get_pagenum_link(1)) . 'page/%#%/', 'paged');

                    echo paginate_links($pl_args);
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
