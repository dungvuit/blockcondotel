<?php
$catID = intval(getRequest('category'));
$list_city = get_province();
$directions = direction_list();
$rooms = room_list();
// Can ban
$categories = get_terms(array(
    'taxonomy' => 'product_category',
    'hide_empty' => 0,
    'parent' => intval(get_option(SHORT_NAME . "_cat_sell")),
));
// Cho thue
$categories2 = get_terms(array(
    'taxonomy' => 'product_category',
    'hide_empty' => 0,
    'parent' => intval(get_option(SHORT_NAME . "_cat_rent")),
));
// Cho thue
$categories3 = get_terms(array(
    'taxonomy' => 'product_category',
    'hide_empty' => 0,
    'parent' => intval(get_option(SHORT_NAME . "_cat_invest")),
));
$areas = get_categories(array(
    'type' => 'product',
    'taxonomy' => 'product_acreage',
));
$prices = get_categories(array(
    'type' => 'product',
    'taxonomy' => 'product_price',
));
$projects = new WP_Query(array(
    'post_type' => 'project',
    'showposts' => -1,
    'post_status' => 'publish',
));
$purposes = get_categories(array(
    'type' => 'product',
    'taxonomy' => 'product_purpose',
));
$specials = get_categories(array(
    'type' => 'product',
    'taxonomy' => 'product_special',
));
?>
<div class="hide hidden" id="categories-sales">
    <option value="<?php echo get_option(SHORT_NAME . "_cat_sell") ?>">- Loại nhà đất -</option>
    <?php
    foreach ($categories as $category) :
        if ($catID == $category->term_id) {
            echo "<option value=\"{$category->term_id}\" selected>{$category->name}</option>";
        } else {
            echo "<option value=\"{$category->term_id}\">{$category->name}</option>";
        }
    endforeach;
    ?>
</div>
<div class="hide hidden" id="categories-rent">
    <option value="<?php echo get_option(SHORT_NAME . "_cat_rent") ?>">- Loại nhà đất -</option>
    <?php
    foreach ($categories2 as $category) :
        if ($catID == $category->term_id) {
            echo "<option value=\"{$category->term_id}\" selected>{$category->name}</option>";
        } else {
            echo "<option value=\"{$category->term_id}\">{$category->name}</option>";
        }
    endforeach;
    ?>
</div>
<div class="hide hidden" id="categories-invest">
    <option value="<?php echo get_option(SHORT_NAME . "_cat_invest") ?>">- Loại nhà đất -</option>
    <?php
    foreach ($categories3 as $category) :
        if ($catID == $category->term_id) {
            echo "<option value=\"{$category->term_id}\" selected>{$category->name}</option>";
        } else {
            echo "<option value=\"{$category->term_id}\">{$category->name}</option>";
        }
    endforeach;
    ?>
</div>
<div class="widget box-search pb10">
    <ul class="nav nav-tabs responsive" id="boxTab">
        <li class="test-class active"><a data-id="sales" href="#tab1">Cần Bán</a></li>
        <li class="test-class"><a data-id="rent" href="#tab2">Cho Thuê</a></li>
        <li class="test-class"><a data-id="invest" href="#tab3">Đầu Tư</a></li>
    </ul>
    <div class="tab-content box-content responsive">
        <div class="tab-pane active">
            <form method="get" action="<?php bloginfo('siteurl') ?>">
                <ul class="tab_select">
                    <li>
                        <select name="category" id="category" >
                            <option value="<?php echo get_option(SHORT_NAME . "_cat_sell") ?>">- Loại nhà đất -</option>
                            <?php
                            foreach ($categories as $category) :
                                if ($catID == $category->term_id) {
                                    echo "<option value=\"{$category->term_id}\" selected>{$category->name}</option>";
                                } else {
                                    echo "<option value=\"{$category->term_id}\">{$category->name}</option>";
                                }
                            endforeach;
                            ?>
                        </select>
                    </li>
                    <li>
                        <select name="city" id="ddlCity" >
                            <option value="">- Thành phố -</option>
                            <?php
                            foreach ($list_city as $c) {
                                echo '<option value="' . $c->provinceid . '">' . $c->name . '</option>';
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <select name="district" id="ddlDistrict" >
                            <option value="">- Quận/ Huyện -</option>
                        </select>
                    </li>
                    <li>
                        <select name="ward" id="ddlWard" >
                            <option value="">- Phường/ Xã -</option>
                        </select>
                    </li>
                    <li>
                        <select name="street" id="street" >
                            <option value="">- Đường phố -</option>
                        </select>
                    </li>
                    <li>
                        <select name="area" id="area" >
                            <option value="">- Diện tích -</option>
                            <?php
                            $areaID = intval(getRequest('area'));
                            foreach ($areas as $area) :
                                if ($areaID == $area->term_id) {
                                    echo "<option value=\"{$area->term_id}\" selected>{$area->name}</option>";
                                } else {
                                    echo "<option value=\"{$area->term_id}\">{$area->name}</option>";
                                }
                            endforeach;
                            ?>
                        </select>
                    </li>
                    <li>
                        <select name="price" id="price" >
                            <option value="">- Giá -</option>
                            <?php
                            $priceID = intval(getRequest('price'));
                            foreach ($prices as $price) :
                                if ($priceID == $price->term_id) {
                                    echo "<option value=\"{$price->term_id}\" selected>{$price->name}</option>";
                                } else {
                                    echo "<option value=\"{$price->term_id}\">{$price->name}</option>";
                                }
                            endforeach;
                            ?>
                        </select>
                    </li>
                    <li>
                        <select name="room" id="room" >
                            <option value="">- Số phòng ngủ -</option>
                            <?php
                            foreach ($rooms as $key => $value) {
                                echo '<option value="' . $key . '">' . $value . '</option>';
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <select name="direction" id="direction" >
                            <option value="">- Hướng -</option>
                            <?php
                            foreach ($directions as $key => $value) {
                                echo '<option value="' . $key . '">' . $value . '</option>';
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <select name="project" id="project" >
                            <option value="">- Dự án -</option>
                            <?php
                            while($projects->have_posts()): $projects->the_post();
                                echo '<option value="'. get_the_ID().'">'. get_the_title().'</option>';
                            endwhile;
                            wp_reset_query();
                            ?>
                        </select>
                    </li>
                    <li>
                        <select name="special" id="special" >
                            <option value="">- Đặc điểm -</option>
                            <?php
                            $specialID = intval(getRequest('special'));
                            foreach ($specials as $special) :
                                if ($specialID == $special->term_id) {
                                    echo "<option value=\"{$special->term_id}\" selected>{$special->name}</option>";
                                } else {
                                    echo "<option value=\"{$special->term_id}\">{$special->name}</option>";
                                }
                            endforeach;
                            ?>
                        </select>
                    </li>
                    <li class="btnsearch">
                        <input type="hidden" name="s" value="" />
                        <input type="submit" value="Tìm kiếm" class="btnSearch"/>
                        <div class="clear"></div>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>