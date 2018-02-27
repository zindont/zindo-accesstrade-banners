<?php
/**
 * Auto generate Accesstrade promotions using API
 */
class Zindo_Accesstrade_Banners extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'zindo_accesstrade_banner', // Base ID
            esc_html__( 'Tự tạo banner từ Accesstrade by Ân', 'zindo-accesstrade-banners' ), // Name
            array(
                'description' => esc_html__( 'Tự lấy banner ngẫu nhiên từ Accesstrade bằng API', 'zindo-accesstrade-banners' ),
                'classname' => 'zindo-accesstrade-banners'
            )

        );
        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));
    }

    public function form( $instance ) {

        $offer_id  =  array(
            'lazada' => esc_html__( 'Lazada', 'zindo-accesstrade-banners' ),
            'vienthonga' => esc_html__( 'VienthongA', 'zindo-accesstrade-banners' ),
            'fptshop' => esc_html__( 'FPT Shop', 'zindo-accesstrade-banners' ),
        );

        $instance =  wp_parse_args( $instance, array(
            'title'     => '',
            'access_key'    => '',
            'offer_id'  =>  $offer_id,
        ) );

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>

        <div>
            <label for="<?php echo $this->get_field_id( 'access_key' ); ?>"><?php esc_html_e( 'Access Key: ', 'zindo-accesstrade-banners' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'access_key' ); ?>" name="<?php echo $this->get_field_name( 'access_key' ); ?>" type="text" value="<?php echo esc_attr( $instance['access_key'] ); ?>">
            <p class="description">
                Access key lấy tại: <a href="https://pub.accesstrade.vn/accounts/profile" target="_blank">https://pub.accesstrade.vn/accounts/profile</a>
            </p>
        </div>

        <p>
            <label ><?php esc_html_e( 'Cửa hàng hiển thị banner:', 'zindo-accesstrade-banners' ); ?></label>
            <select name="<?php echo $this->get_field_name( 'offer_id' ); ?>">
                <?php

                foreach ( $offer_id as $k => $v ) {
                    echo '<option value="'.$k.'" '.selected( $instance['offer_id'], $k, false ).' >'.$v.'</option>';
                } ?>
            </select>
        </p>

        <?php
    }


    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        // Sidebar
        $instance =  wp_parse_args( $instance, array(
            'title'     => '',
            'access_key'    => '',
            'offer_id'  =>  array(),
        ) );


        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        
        ?>
        <div class="zindo-accesstrade-banners">
            <div class="promotion promotion-<?php echo $instance['offer_id'] ?>" 
                id="promotion-<?php echo $this->id ?>" 
                data-widget-name="<?php echo $this->id_base ?>"
                data-widget-id="<?php echo $this->number ?>"
                data-offer-id="<?php echo $instance['offer_id'] ?>">
            </div>
        </div><!-- END .masoffer-auto-banner -->
        <?php
        echo $args['after_widget'];
    }

    public function load_scripts()
    {
        wp_enqueue_script( 'zindo-accesstrade-banners', plugin_dir_url( __FILE__ ) . 'js/zindo_accesstrade_banners.js', array('jquery'), false, true );
        wp_localize_script( 'zindo-accesstrade-banners', 'zindo_accesstrade_banners_ajax', array(
           'ajaxurl' => admin_url('admin-ajax.php')
        )); 
    }
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

}