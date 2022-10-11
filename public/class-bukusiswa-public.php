<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://bukusiswa
 * @since      1.0.0
 *
 * @package    Bukusiswa
 * @subpackage Bukusiswa/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bukusiswa
 * @subpackage Bukusiswa/public
 * @author     bukusiswa <bukusiswa@luqman.com>
 */
class Bukusiswa_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bukusiswa_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bukusiswa_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bukusiswa-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bukusiswa_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bukusiswa_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bukusiswa-public.js', array( 'jquery' ), $this->version, false );

	}

	public function buku_woocommerce_account_menu_items( $items ) {
		$items['dashboard'] = "Personal Detail" ;
		$items['edit-account'] = "Settings" ;
		unset($items['orders']);
		unset($items['downloads']);
		unset($items['edit-address']);
		$items = array_slice( $items, 0, 1, true ) 
		+ array( 'myproduct' => 'My Products' )
		+ array( 'watchlist' => 'Watchlist' )
		+ array_slice( $items, 1, NULL, true );

		return $items;
	}

	public function buku_add_watchlist() {

		add_rewrite_endpoint( 'watchlist', EP_PAGES );
		add_rewrite_endpoint( 'myproduct', EP_PAGES );

	}

	public function buku_woocommerce_account_watchlist_endpoint() {

			// of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
			echo do_shortcode( "[yith_wcwl_wishlist]");

		}

	public function buku_woocommerce_account_myproduct_endpoint() {
		global $wp ; 
		
		
		if($wp->query_vars['myproduct'] && $wp->query_vars['myproduct'] === "add"){
			include_once dirname( __FILE__ ) . '/partials/addmyproduct.php';
		}else{
			include_once dirname( __FILE__ ) . '/partials/myproduct.php';
		}

		

	}

		public function buku_woocommerce_account_dashboard(){
			$current_user = wp_get_current_user();
			?>


				<script>

					window.addEventListener('load', function(event) {
						document.querySelector("div.woocommerce-MyAccount-content p:nth-child(3)").innerHTML = "" ;
    
					}); 

					
				</script>
				
				
					Username : <?php echo $current_user->user_login ; ?>
					<br>
					First Name : <?php echo $current_user->user_firstname ; ?>
					<br>
					Last Name : <?php echo $current_user->user_lastname ; ?>
					<br>
					Email : <?php echo $current_user->user_email ; ?>
					<br>
					Matric No : <?php echo get_user_meta( $current_user->ID, 'matricno', true ); ?>
					<br>
					Jabatan : <?php echo get_user_meta( $current_user->ID, 'jabatan', true );  ?>


					
				
				

			<?php
			
			
		}


		public function buku_woocommerce_edit_account_form(){
			$user = wp_get_current_user();
			
			?>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="matricno"><?php _e( 'Matric No', 'woocommerce' ); ?></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="matricno" id="matricno" value="<?php echo esc_attr( $user->matricno ); ?>" />
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="jabatan"><?php _e( 'Jabatan', 'woocommerce' ); ?></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="jabatan" id="jabatan" value="<?php echo esc_attr( $user->jabatan ); ?>" />
			</p>

			<?php

		}

		public function buku_woocommerce_save_account_details($user_id ){
			
				if( isset( $_POST['matricno'] ) )
					update_user_meta( $user_id, 'matricno', sanitize_text_field( $_POST['matricno'] ) );

				if( isset( $_POST['jabatan'] ) )
					update_user_meta( $user_id, 'jabatan', sanitize_text_field( $_POST['jabatan'] ) );
			
		}

}
