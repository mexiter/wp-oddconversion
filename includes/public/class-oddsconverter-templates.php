<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The public-facing templates of the plugin.
 *
 * @package       OddsConverter
 * @subpackage    OddsConverter/public
 * @author        Merxhan Emini <https://symphony-solutions.eu>
 */

if( ! class_exists( 'OddsConverter_Templates' ) ) {

	class OddsConverter_Templates {

		/**
		 * The plugin variables container.
		 *
		 * @var    object    $plugin
		 */
		private $plugin;

		/**
		 * Construct the class.
		 *
		 * @param    object    $plugin    The plugin variables.
		 */
		public function __construct( $plugin ) {

			$this->plugin = $plugin;

		}

		/**
		 * Assign the single item template to the post type.
		 *
		 * @param     string    The default single template.
		 * @return    string    The proper single template.
		 */
		public function shortcode_template_item( $template ) {

				$name = 'single-item.php';
				if( locate_template( $name ) == '' ) {
					$template = $this->plugin['path'] . '/templates/' . $name;
				}


			return $template;

		}

		/**
		 * Assign the archive item template to the post type.
		 *
		 * @param     string    The default archive template.
		 * @return    string    The proper archive template.
		 */
		public function archive_template_item( $template ) {


				$name = 'archive-item.php';
				if( locate_template( array( $name ) ) == '' ) {
					$template = $this->plugin['path'] . '/templates/' . $name;
				}


			return $template;

		}

		public function oddsConverter_shortcode() {
	?>
		<!-- Here we create the modal shortcode
			The shortcode consists of button that triggers the modal and the modal itself-->

		<!--Modal Button .oc-btn-calc-->
		<button type="button" data-toggle="modal" data-target="#qbo-oddsConverter" class="btn btn-info btn-md oc-btn-calc"><?php _e('Odds Converter!', $this->plugin['id']);?></button>
		<!--end.oc-btn-calc-->

		<!--Modal-->
		<div class="modal fade" id="qbo-oddsConverter" role="dialog">
			<!--Modal dialog-->
			<div class="modal-dialog">
				<!--Modal Content-->
				<div class="modal-content">
					<div class="modal-header">
						<div class="modal-header-upper-row hidden-xs">
							<button type="button" class="close" data-dismiss="modal">
								<i class="fa fa-times-circle-o" aria-hidden="true"></i>
							</button>
						</div>
						<!--end .modal-header-upper-row-->
						<div class="clearfix"></div><!--end .clearfix-->
						<div class="modal-header-lower-row hidden-xs">
							<img src="<?php echo esc_url( plugins_url( '../../assets/public/img/cubes.png', __FILE__ ) ); ?>" alt="cubes" class="pull-left">
							<div class="clearfix"></div><!--end .clearfix-->
							<h4 class="modal-title text-center">
								<?php _e('Please enter your odds', $this->plugin['id']); ?>
							</h4>
						</div>
						<!--end .modal-header-lower-row-->
					</div>
					<!--end .modal-header-->
					<div class="modal-body">
						<p class="text-center qbo-label">
							<?php _e('Please use valid format only, ex: EU:1.65, UK:5/2, USA: +200 or -150', $this->plugin['id']); ?>
						</p><!--end p.text-center-->
						<form id="form-convert" role="form" class="form" >
							<div class="row">
								<div class="clearfix"></div><!--end .clearfix-->
								<div class="form-group">
									<label for="qbo-label-odds" class="col-sm-3 col-md-2 col-lg-2 qbo-label-control">
										<?php _e('Your Odds', $this->plugin['id']); ?>
									</label><!--end .qbp-label-control-->
									<div class="col-sm-9 col-md-10 col-lg-10">
                                <input id="qbo_user_odds" type="text" name="qbo_user_odds" class="form-control">
                                    </div>
                                </div><!--end .form-group-->
                                <div class="clearfix"></div><!--end .clearfix-->
                                <div class="form-group">
                                	<label for="qbo-label-odds" class="col-sm-3 col-md-2 col-lg-2 qbo-label-control">
										<?php _e('Odds Type', $this->plugin['id']); ?>
									</label><!--end .qbp-label-control-->
									<div class="col-sm-9 col-md-10 col-lg-10">
										<select name="odds_type" id="odds_type" class="form-control">
											<option value="eu"><?php _e('Decimal Odds (EU)',$this->plugin['id']);?></option>
											<option value="uk"><?php _e('Fractional Odds (UK)', $this->plugin['id']);?></option>
											<option value="usa"><?php _e('Moneyline Odds (USA)', $this->plugin['id']);?></option>
										</select>
									</div>
								</div><!--end .form-group-->
								<div class="clearfix"></div><!--end .clearfix-->
								<div class="form-group">
									<div class="col-sm-6 col-md-4 col-md-offset-2 col-lg-4 col-lg-offset-2 text-right">
										<button type="button" class="btn btn-success qb-btn-convert">
											<?php _e('Convert Odds', $this->plugin['id']); ?>
										</button>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-6 text-left">
										<button id="qb-reset" type="submit" class="btn btn-default qb-btn-reset">
											<?php _e('Reset', $this->plugin['id']);?>
										</button>
									</div>
								</div><!--end .form-group-->
							</div><!--end .row-->
						</form>
						<!--end #form-convert-->
						<div class="clearfix"></div><!--end .clearfix-->
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-12 text-center">
								<table id="qb-result" class="table table-responsive table-condensed table-striped hidden">
									<thead>
										<tr><?php _e('Decimal Odds (EU)',$this->plugin['id']);?></tr>
										<tr><?php _e('Fractional Odds (UK)',$this->plugin['id']);?></tr>
										<tr><?php _e('Moneyline Odds (USA)',$this->plugin['id']);?></tr>
									</thead>
									<tbody></tbody>
								</table>
							</div><!--.col-md-12-->
						</div><!--.row-->
						<div class="clearfix"></div><!--end .clearfix-->
						<div class="col-sm-12 col-md-12 col-lg-12 text-center qb-error-wrapper">
							<div id="qb-error-display" class="alert alert-danger">
							  <strong></strong>
							</div><!--end #qb-error-display-->
						</div><!--end .qb-error-wrapper-->
						<div class="clearfix"></div><!--end.clearfix-->
					</div>
					<!--end .modal-body-->
					<div class="modal-footer">
						<button class="btn btn-small btn-default qb-btn-close" type="button"><?php _e('Close',$this->plugin['id']);?></button>
					</div><!--end .modal-footer-->
				</div>
				<!--end .modal-content-->
			</div>
			<!--end .modal-dialog-->
		</div>
		<!--end#qbo-oddsConverter-->
	<?php

	}

		public function odds_make_shortcode() {
			add_shortcode( 'qbo-convert', array($this, 'oddsConverter_shortcode' ));
		}

	}

}
