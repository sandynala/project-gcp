<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

class Xcs_Dyno_Item_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Term List widget name.
	 *
	 * @since 0.1
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'csx-dyno-item';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Term List widget title.
	 *
	 * @since 0.1
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Dyno Item', 'csx-dyno' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Term List widget icon.
	 *
	 * @since 0.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-info-box';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Term List widget belongs to.
	 *
	 * @since 0.1
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
    return [ 'ele-custom-grid'];
	}
  
	/**
	 * Register Term List widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 0.1
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ele-term-list' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		    
    $this->add_control(
			'important_note',
			[
				'label' => __( 'Dyno Item Place Holder', 'ele-term-list' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __( 'Place this widget where the Dyno Item you want to show in Dyno Skin.', 'ele-term-list' ),
				'content_classes' => 'your-class',
        'selector'=>'{{wrapper}} .csx-dyno-preview'
			]
		);
    
    
    $this->end_controls_section();


	}

	/**
	 * Render Term List widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 0.1
	 * @access protected
	 */
	protected function render() {

    if ( $this->show_nice() ) {
     $this->content_template();
    } else {
       echo "{{csx-article}}";
    }

	}
    
    protected function show_nice(){
      $is_preview=false;
      $document = kekcsx_get_document( get_the_ID() );
  
      if($document) if('custom_grid' == $document->get_location()){
        if (isset($_GET['action'])) $is_preview = $_GET['action'] == 'elementor' ? true : false;
      }
      return $is_preview;
    }
  
  protected function content_template() {
    
  ?>
    <div class="csx-dyno-preview">
      <div class="csx-image-holder">=^_^=</div>
      <h3>
        Sample Template
      </h3>
      <span>Sample template text for Dyno. You can provide your real text here.</span>
    </div>
<?php
  }

}
