<?php
$list_city = get_province();
$directions = direction_list();
$rooms = room_list();
// Can ban
$termchildren = get_terms(array(
    'hide_empty' => 0,
    'post_type' => 'product',
    'taxonomy' => 'product_category',
    'parent' => intval(get_option(SHORT_NAME . "_cat_sell"))
));
// Cho thue
$termchildren2 = get_terms(array(
    'hide_empty' => 0,
    'post_type' => 'product',
    'taxonomy' => 'product_category',
    'parent' => intval(get_option(SHORT_NAME . "_cat_rent"))
));
// Dau tu
$termchildren3 = get_terms(array(
    'hide_empty' => 0,
    'post_type' => 'product',
    'taxonomy' => 'product_category',
    'parent' => intval(get_option(SHORT_NAME . "_cat_invest"))
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
$areas = get_categories(array(
    'type' => 'product',
    'taxonomy' => 'product_acreage',
));
$specials = get_categories(array(
    'type' => 'product',
    'taxonomy' => 'product_special',
));
?>
<h2 class="form-title">Tìm bất động sản</h2>
<ul class="nav nav-tabs responsive" id="myTab">
    <li class="test-class"><a data-id="invest" href="#tab3"><span>Đầu tư</span></a></li>
    <li class="test-class"><a data-id="rent" href="#tab2"><span>Cho thuê</span></a></li>
    <li class="test-class active"><a data-id="sales" href="#tab1"><span>Cần bán</span></a></li>
</ul>
<div class="hide hidden" id="categories-sales">
    <option value="<?php echo get_option(SHORT_NAME . "_cat_sell") ?>">- Loại nhà đất -</option>
    <?php
    foreach ($termchildren as $child) :
        echo "<option value=\"{$child->term_id}\">{$child->name}</option>";
    endforeach;
    ?>
</div>
<div class="hide hidden" id="categories-rent">
    <option value="<?php echo get_option(SHORT_NAME . "_cat_rent") ?>">- Loại nhà đất -</option>
    <?php
    foreach ($termchildren2 as $child) :
        echo "<option value=\"{$child->term_id}\">{$child->name}</option>";
    endforeach;
    ?>
</div>
<div class="hide hidden" id="categories-invest">
    <option value="<?php echo get_option(SHORT_NAME . "_cat_invest") ?>">- Loại nhà đất -</option>
    <?php
    foreach ($termchildren3 as $child) :
        echo "<option value=\"{$child->term_id}\">{$child->name}</option>";
    endforeach;
    ?>
</div>
<div class="tab-content top-content-search responsive">
    <div class="tab-pane active">
        <form method="get" action="<?php bloginfo('siteurl') ?>">
            <div class="row">
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="tab_select">
                        <li>
                            <select name="category" id="category" >
                                <option value="<?php echo get_option(SHORT_NAME . "_cat_sell") ?>">- Loại nhà đất -</option>
                                <?php
                                foreach ($termchildren as $child) :
                                    echo "<option value=\"{$child->term_id}\">{$child->name}</option>";
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
                    </ul>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="tab_select">
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
                            <select name="room" id="room" >
                                <option value="">- Số phòng ngủ -</option>
                                <?php
                                foreach ($rooms as $key => $value) {
                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                }
                                ?>
                            </select>
                        </li>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="tab_select">
                        <li>
                            <select name="district" id="ddlDistrict" >
                                <option value="">- Quận/ Huyện -</option>
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
                    </ul>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="tab_select">
                        <li>
                            <select name="ward" id="ddlWard" >
                                <option value="">- Phường/ Xã -</option>
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
                    </ul>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="tab_select">
                        <li>
                            <select name="street" id="street" >
                                <option value="">- Đường phố -</option>
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
                    </ul>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="tab_select">
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
                            <input type="submit" value="Tìm kiếm" class="btnSearch"/>
                            <input type="hidden" name="s" value="" />
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>