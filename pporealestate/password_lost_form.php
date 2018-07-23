<div class="password-lost-form">
    <div class="description">
        <?php
        if(isset($_REQUEST['errors'])){
            switch ($_REQUEST['errors']) {
                case 'empty_username':
                    _e( 'Vui lòng nhập một tài khoản email hợp lệ.', SHORT_NAME );
                    break;
                case 'invalid_username':
                    _e( 'Tài khoản không tồn tại hoặc không hợp lệ. Vui lòng thử lại.', SHORT_NAME );
                    break;
                case 'empty_email':
                    _e( 'Vui lòng nhập một địa chỉ email hợp lệ.', SHORT_NAME );
                    break;
                case 'invalid_email':
                    _e( 'Địa chỉ email không tồn tại hoặc không hợp lệ. Vui lòng thử lại.', SHORT_NAME );
                    break;
                case 'invalidcombo':
                    _e( 'Tài khoản hoặc địa chỉ email không hợp lệ. Vui lòng thử lại.', SHORT_NAME );
                    break;
                default:
                    _e( 'Xảy ra lỗi. Vui lòng thử lại.', SHORT_NAME );
                    break;
            }
        } else {
            _e(
                "Vui lòng điền địa chỉ email đã đăng ký. Bạn sẽ nhận được thư có liên kết để tạo mật khẩu mới.",
                SHORT_NAME
            );
        }
        ?>
    </div>
    <form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
        <div class="form-group" style="min-width: calc(100% - 10px)">
            <label for="user_login" class="control-label"><?php _e( 'Địa chỉ E-mail', SHORT_NAME ); ?></label>
            <input type="text" name="user_login" id="user_login" class="form-control" />
        </div>
        <div class="login-submit">
            <input type="submit" name="submit" class="button-primary" value="<?php _e( 'Lấy mật khẩu mới', SHORT_NAME ); ?>"/>
        </div>
    </form>
</div>