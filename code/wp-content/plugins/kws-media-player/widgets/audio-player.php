<?php
namespace ElementorAudioPlayer\Widgets;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit; 


use Elementor\Widget_Base;
use Elementor\Controls_Manager as Controls_Manager;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Utils as Utils;
use Elementor\Scheme_Color as Scheme_Color;

/**
 * @since 1.1.0
 */
class AudioPlayer extends Widget_Base {

  public function get_name() {
    return 'MediaPlayer_Audio_Player';
  }

  public function get_title() {
    return esc_html__( 'Audio Player', 'kws-media-player' );
  }

  public function get_icon() {
    return 'fas fa-headphones-alt';
  }

  public function get_categories() {
    return [ 'kws-widgets' ];
  }

  protected function _register_controls() {
    //general controls (ex content)
    $this->start_controls_section(
      'general_content',
      [
        'label' => esc_html__( 'General Settings', 'kws-media-player' ),
      ]
    );
    $this->add_control(
			'skin',
			[
				'label' => __( 'Skin Name', 'kws-media-player' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'type_a'  => __( 'Type A', 'kws-media-player' ),
					'type_b' => __( 'Type B', 'kws-media-player' ),
				],
        'default' => 'type_a',
			]
		);
    $this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Loop Playlist', 'kws-media-player' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'kws-media-player' ),
				'label_off' => esc_html__( 'No', 'kws-media-player' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
    $this->add_control(
			'autoPlay',
			[
				'label' => esc_html__( 'Auto Play', 'kws-media-player' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'kws-media-player' ),
				'label_off' => esc_html__( 'No', 'kws-media-player' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
    $this->add_control(
			'stickyx',
			[
				'label' => esc_html__( 'Sticky', 'kws-media-player' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'kws-media-player' ),
				'label_off' => esc_html__( 'No', 'kws-media-player' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
    $this->add_control(
      'initialVolume',
      [
        'label' => esc_html__( 'Initial Volume Value', 'kws-media-player' ),
        'type' => Controls_Manager::NUMBER,
        'min' => 0,
        'max' => 1,
        'step' => 0.1,
        'default' => 1,
      ]
    );
    $this->add_control(
      'playerBgHex',
      [
        'label' => esc_html__( 'Player Background Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#000000',
      ]
    );
    $this->add_control(
    'playerBg',
    [
      'label' => esc_html__( 'Player Background - Image', 'kws-media-player' ),
      'type' => Controls_Manager::MEDIA,
      'default' => [
        'url' => Utils::get_placeholder_image_src(),
      ],
      'description' => esc_html__( 'if defined, it will be used instead of the Background Color', 'kws-media-player' ),
      'dynamic' => [
        'active' => true,
      ],
  ]
    );
    $this->add_control(
      'bufferEmptyColor',
      [
        'label' => esc_html__( 'Empty Buffer Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#929292',
      ]
    );
    $this->add_control(
      'bufferFullColor',
      [
        'label' => esc_html__( 'Full Buffer Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#454545',
      ]
    );
    $this->add_control(
      'seekbarColor',
      [
        'label' => esc_html__( 'SeekBar Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
      'volumeOffColor',
      [
        'label' => esc_html__( 'Volume Off State Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#454545',
      ]
    );
    $this->add_control(
      'volumeOnColor',
      [
        'label' => esc_html__( 'Volume On State Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
      'timerColor',
      [
        'label' => esc_html__( 'Timer Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
      'songTitleColor',
      [
        'label' => esc_html__( 'Song Title - Text Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#a6a6a6',
      ]
    );
    $this->add_control(
      'songAuthorColor',
      [
        'label' => esc_html__( 'Song Author - Text Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
      'barsColor',
      [
        'label' => esc_html__( 'Bars Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
			'showRewindBut',
			[
				'label' => esc_html__( 'Show Rewind Button', 'kws-media-player' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'kws-media-player' ),
				'label_off' => esc_html__( 'No', 'kws-media-player' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
			'showNextPrevBut',
			[
				'label' => esc_html__( 'Show Next & Previous Buttons', 'kws-media-player' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'kws-media-player' ),
				'label_off' => esc_html__( 'No', 'kws-media-player' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
    $this->add_control(
			'showTitle',
			[
				'label' => esc_html__( 'Show Title', 'kws-media-player' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'kws-media-player' ),
				'label_off' => esc_html__( 'No', 'kws-media-player' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);

    $this->add_control(
			'showFacebookBut',
			[
				'label' => esc_html__( 'Show FaceBook Button', 'kws-media-player' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'kws-media-player' ),
				'label_off' => esc_html__( 'No', 'kws-media-player' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
      'facebookAppID',
      [
        'label' => esc_html__( 'FaceBook AppID', 'kws-media-player' ),
        'type' => Controls_Manager::TEXT,
        'label_block' => false,
        'default' => '',
				'condition' => [
					'showFacebookBut' => 'true',
				],
      ]
    );
    $this->add_control(
			'showTwitterBut',
			[
				'label' => esc_html__( 'Show Twitter Button', 'kws-media-player' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'kws-media-player' ),
				'label_off' => esc_html__( 'No', 'kws-media-player' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
      'preload',
      [
        'label' => __( 'Preload', 'kws-media-player' ),
        'type' => Controls_Manager::SELECT,
        'options' => [
          'auto'  => __( 'auto', 'kws-media-player' ),
          'metadata' => __( 'metadata', 'kws-media-player' ),
          'none' => __( 'none', 'kws-media-player' ),
        ],
        'default' => 'metadata',
      ]
    );


    $this->add_control(
			'showPopupBut',
			[
				'label' => esc_html__( 'Show Popup Button', 'kws-media-player' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'kws-media-player' ),
				'label_off' => esc_html__( 'No', 'kws-media-player' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
    $this->add_control(
      'popupWidth',
      [
        'label' => esc_html__( 'Popup Width', 'kws-media-player' ),
        'type' => Controls_Manager::NUMBER,
        'label_block' => false,
        'default' => '1100',
				'condition' => [
					'showPopupBut' => 'true',
				],
      ]
    );
    $this->add_control(
      'popupHeight',
      [
        'label' => esc_html__( 'Popup Height', 'kws-media-player' ),
        'type' => Controls_Manager::NUMBER,
        'label_block' => false,
        'default' => '500',
				'condition' => [
					'showPopupBut' => 'true',
				],
      ]
    );
    $this->end_controls_section();


    $this->start_controls_section(
      'left_side_top_content',
      [
        'label' => esc_html__( 'Playlist Settings', 'kws-media-player' ),
      ]
    );
    $this->add_control(
      'showPlaylist',
      [
        'label' => esc_html__( 'Show Playlist', 'kws-media-player' ),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__( 'Yes', 'kws-media-player' ),
        'label_off' => esc_html__( 'No', 'kws-media-player' ),
        'return_value' => 'true',
        'default' => 'false',
      ]
    );
    $this->add_control(
      'showPlaylistOnInit',
      [
        'label' => esc_html__( 'Show Playlist On Init', 'kws-media-player' ),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__( 'Yes', 'kws-media-player' ),
        'label_off' => esc_html__( 'No', 'kws-media-player' ),
        'return_value' => 'true',
        'default' => 'false',
      ]
    );
    $this->add_control(
      'showPlaylistBut',
      [
        'label' => esc_html__( 'Show Playlist Button', 'kws-media-player' ),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__( 'Yes', 'kws-media-player' ),
        'label_off' => esc_html__( 'No', 'kws-media-player' ),
        'return_value' => 'true',
        'default' => 'false',
      ]
    );
    $this->add_control(
      'playlistTopPos',
      [
        'label' => esc_html__( 'Playlist Top Position', 'kws-media-player' ),
        'type' => Controls_Manager::NUMBER,
        'label_block' => false,
        'default' => '2',
      ]
    );
    $this->add_control(
      'playlistBgColor',
      [
        'label' => esc_html__( 'Playlist Background Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#000000',
      ]
    );
    $this->add_control(
      'playlistRecordBgOffColor',
      [
        'label' => esc_html__( 'Playlist Record Background Off Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#000000',
      ]
    );
    $this->add_control(
      'playlistRecordBgOnColor',
      [
        'label' => esc_html__( 'Playlist Record Background On Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#333333',
      ]
    );
    $this->add_control(
      'playlistRecordBottomBorderOffColor',
      [
        'label' => esc_html__( 'Playlist Record Bottom Border Off Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#333333',
      ]
    );
    $this->add_control(
      'playlistRecordBottomBorderOnColor',
      [
        'label' => esc_html__( 'Playlist Record Bottom Border On Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
      'playlistRecordTextOffColor',
      [
        'label' => esc_html__( 'Playlist Record Text Off Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#777777',
      ]
    );
    $this->add_control(
      'playlistRecordTextOnColor',
      [
        'label' => esc_html__( 'Playlist Record Text On Color', 'kws-media-player' ),
        'type' => Controls_Manager::COLOR,
        'scheme' => [
          'type' => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
      'numberOfThumbsPerScreen',
      [
        'label' => esc_html__( 'Number Of Items Per Screen', 'kws-media-player' ),
        'type' => Controls_Manager::NUMBER,
        'label_block' => false,
        'default' => '5',
      ]
    );
    $this->add_control(
      'playlistPadding',
      [
        'label' => esc_html__( 'Playlist Padding', 'kws-media-player' ),
        'type' => Controls_Manager::NUMBER,
        'label_block' => false,
        'default' => '18',
      ]
    );
    $this->add_control(
      'showPlaylistNumber',
      [
        'label' => esc_html__( 'Show Playlist Number', 'kws-media-player' ),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__( 'Yes', 'kws-media-player' ),
        'label_off' => esc_html__( 'No', 'kws-media-player' ),
        'return_value' => 'true',
        'default' => 'true',
      ]
    );

    $this->end_controls_section();


    /*playlist controls*/
    $this->start_controls_section(
      'playlist_content',
      [
        'label' => esc_html__( 'Playlist Items', 'kws-media-player' ),
      ]
    );


    $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'kws-media-player' ),
				'type' => Controls_Manager::TEXT,
        'label_block' => true,
        'default' => '',
				'dynamic' => [
					'active' => true,
				],
			]
		);
    $repeater->add_control(
			'author', [
				'label' => __( 'Author', 'kws-media-player' ),
				'type' => Controls_Manager::TEXT,
        'label_block' => true,
        'default' => '',
				'dynamic' => [
					'active' => true,
				],
			]
		);

    $repeater->add_control(
      'imgplaylist',
      [
        'label' => esc_html__( 'Playlist Image', 'kws-media-player' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
          'url' => Utils::get_placeholder_image_src(),
        ],
				'dynamic' => [
					'active' => true,
				],
      ]
	  );

    $repeater->add_control(
			'mp3',
			[
				'label' => esc_html__( 'MP3 file (Chrome, IE, Safari)', 'kws-media-player' ),
				//'type' => Controls_Manager::MEDIA,
        'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
					//'categories' => [
					//	TagsModule::MEDIA_CATEGORY,
					//],
				],
				'media_type' => 'audio'
			]
		);
    $repeater->add_control(
      'ogg',
      [
        'label' => esc_html__( 'Optional OGG file (Mozzila, Opera)', 'kws-media-player' ),
        //'type' => Controls_Manager::MEDIA,
        'type' => Controls_Manager::URL,
        'dynamic' => [
          'active' => true,
          //'categories' => [
          //  TagsModule::MEDIA_CATEGORY,
          //],
        ],
        'media_type' => 'audio'
      ]
	  );



    $this->add_control(
			'list',
			[
				'label' => __( 'Playlist items', 'kws-media-player' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Audio Title', 'kws-media-player' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

    $this->end_controls_section();
  }


  protected function render() {
    $rand_id=rand(10,999999);
    $settings = $this->get_settings_for_display();

    $playerBgColor='';
    if ($settings['playerBgHex'])
        $playerBgColor.=$settings['playerBgHex'];
      if ($settings['playerBg']['url']!='' && strpos($settings['playerBg']['url'],'placeholder.png')===FALSE)
        $playerBgColor.=' url('.$settings['playerBg']['url'].')';

    $pathToDownloadFile_aux=plugin_dir_url(__FILE__).'kws_audio/';
    ?>
    <script>
  		jQuery(function() {
          setTimeout(function(){
                jQuery("#kmp_kws_audio_<?php echo strip_tags($rand_id); ?>").kws_audio({
                  skin:"<?php echo strip_tags($settings['skin']); ?>",
          				initialVolume:<?php echo strip_tags($settings['initialVolume']); ?>,
          				autoPlay:<?php echo (($settings['autoPlay']==='true')?'true':'false'); ?>,
          				loop:<?php echo (($settings['loop']==='true')?'true':'false'); ?>,
                  shuffle:false,
          				sticky:<?php echo (($settings['stickyx']==='true')?'true':'false'); ?>,
          				playerBg:"<?php echo strip_tags($playerBgColor); ?>",
          				bufferEmptyColor:"<?php echo strip_tags($settings['bufferEmptyColor']); ?>",
          				bufferFullColor:"<?php echo strip_tags($settings['bufferFullColor']); ?>",
          				seekbarColor:"<?php echo strip_tags($settings['seekbarColor']); ?>",
          				volumeOffColor:"<?php echo strip_tags($settings['volumeOffColor']); ?>",
          				volumeOnColor:"<?php echo strip_tags($settings['volumeOnColor']); ?>",
          				timerColor:"<?php echo strip_tags($settings['timerColor']); ?>",
          				songTitleColor:"<?php echo strip_tags($settings['songTitleColor']); ?>",
          				songAuthorColor:"<?php echo strip_tags($settings['songAuthorColor']); ?>",
          				showVinylRecord:false,
          				showRewindBut:<?php echo (($settings['showRewindBut']==='true')?'true':'false'); ?>,
          				showNextPrevBut:<?php echo (($settings['showNextPrevBut']==='true')?'true':'false'); ?>,
          				showShuffleBut:false,
          				showDownloadBut:false,
          				showBuyBut:false,
          				showLyricsBut:false,
          				buyButTitle:"",
          				lyricsButTitle:"",
          				buyButTarget:"",
          				lyricsButTarget:"_blank",
          				showFacebookBut:<?php echo (($settings['showFacebookBut']==='true')?'true':'false'); ?>,
          				facebookAppID:"<?php echo strip_tags($settings['facebookAppID']); ?>",
          				showTwitterBut:<?php echo (($settings['showTwitterBut']==='true')?'true':'false'); ?>,
          				showAuthor:<?php echo (($settings['showAuthor']==='true')?'true':'false'); ?>,
          				showTitle:<?php echo (($settings['showTitle']==='true')?'true':'false'); ?>,
          				showPlaylistBut:<?php echo (($settings['showPlaylistBut']==='true')?'true':'false'); ?>,
          				showPlaylist:<?php echo (($settings['showPlaylist']==='true')?'true':'false'); ?>,
          				showPlaylistOnInit:<?php echo (($settings['showPlaylistOnInit']==='true')?'true':'false'); ?>,
          				playlistTopPos:<?php echo strip_tags($settings['playlistTopPos']); ?>,
          				playlistBgColor:"<?php echo strip_tags($settings['playlistBgColor']); ?>",
          				playlistRecordBgOffColor:"<?php echo strip_tags($settings['playlistRecordBgOffColor']); ?>",
          				playlistRecordBgOnColor:"<?php echo strip_tags($settings['playlistRecordBgOnColor']); ?>",
          				playlistRecordBottomBorderOffColor:"<?php echo strip_tags($settings['playlistRecordBottomBorderOffColor']); ?>",
          				playlistRecordBottomBorderOnColor:"<?php echo strip_tags($settings['playlistRecordBottomBorderOnColor']); ?>",
          				playlistRecordTextOffColor:"<?php echo strip_tags($settings['playlistRecordTextOffColor']); ?>",
          				playlistRecordTextOnColor:"<?php echo strip_tags($settings['playlistRecordTextOnColor']); ?>",
          				categoryRecordBgOffColor:"<?php echo strip_tags($settings['categoryRecordBgOffColor']); ?>",
          				categoryRecordBgOnColor:"<?php echo strip_tags($settings['categoryRecordBgOnColor']); ?>",
          				categoryRecordBottomBorderOffColor:"<?php echo strip_tags($settings['categoryRecordBottomBorderOffColor']); ?>",
          				categoryRecordBottomBorderOnColor:"<?php echo strip_tags($settings['categoryRecordBottomBorderOnColor']); ?>",
          				categoryRecordTextOffColor:"<?php echo strip_tags($settings['categoryRecordTextOffColor']); ?>",
          				categoryRecordTextOnColor:"<?php echo strip_tags($settings['categoryRecordTextOnColor']); ?>",
          				numberOfThumbsPerScreen:<?php echo strip_tags($settings['numberOfThumbsPerScreen']); ?>,
          				playlistPadding:<?php echo strip_tags($settings['playlistPadding']); ?>,
                  showCategories:false,
                  showSearchArea:false,
          				showPlaylistNumber:<?php echo (($settings['showPlaylistNumber']==='true')?'true':'false'); ?>,
          				pathToDownloadFile:"<?php echo strip_tags($pathToDownloadFile_aux); ?>",
          				showPopupBut:<?php echo (($settings['showPopupBut']==='true')?'true':'false'); ?>,
                  popupWidth:<?php echo strip_tags( ($settings['showPopupBut']==='true')?$settings['popupWidth']:'0'); ?>,
                  popupHeight:<?php echo strip_tags( ($settings['showPopupBut']==='true')?$settings['popupHeight']:'0'); ?>,
          				barsColor:"<?php echo strip_tags($settings['barsColor']); ?>"
                });
          },100);
  		});
  	</script>
    <div class="kws_audio">
          <div id="kmp_kws_audio_<?php echo strip_tags($rand_id); ?>">
          				<div class="xaudioplaylist">
                  <?php
                  if ( $settings['list'] ) {
                      foreach (  $settings['list'] as $item ) {
                          echo '<ul>';
                              echo '<li class="xtitle">'.strip_tags($item['title']).'</li>';
                              echo '<li class="xauthor">'.strip_tags($item['author']).'</li>';
                              echo '<li class="ximage">'.strip_tags($item['imgplaylist']['url']).'</li>';
                              echo '<li class="xauthorlink">'.strip_tags($item['authorlink']).'</li>';
                              echo '<li class="xauthorlinktarget">'.strip_tags($item['authorlinktarget']).'</li>';
                              echo '<li class="xcategory">'.(($item['category']!='')?strip_tags($item['category']):"ALL CATEGORIES").'</li>';
                              echo '<li class="xbuy">'.strip_tags($item['buylink']).'</li>';
                              echo '<li class="xlyrics">'.strip_tags($item['lyricslink']).'</li>';
                              echo '<li class="xsources_mp3">'.strip_tags($item['mp3']['url']).'</li>';
                              echo '<li class="xsources_ogg">'.strip_tags($item['ogg']['url']).'</li>';
                          echo '</ul>';
                      }
                  }
                  ?>
                  </div>
        </div>
    </div>
    <?php
  }

  protected function _content_template() {
  }
}
