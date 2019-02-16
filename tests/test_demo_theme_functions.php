<?php
    include_once('../../mu-plugins/custom-widgets.php');
    class Test_Demo_Theme_Functions extends WP_UnitTestCase {

        /**
	 * Manager.
	 *
	 * @var WP_Customize_Manager
	 */

        public $wp_customize;

        public function setUp() {

            parent::setUp();
            wp_set_current_user( $this->factory()->user->create( array( 'role' => 'administrator' ) ) );
            require_once( ABSPATH . WPINC . '/class-wp-customize-manager.php' );
            $GLOBALS['wp_customize'] = new WP_Customize_Manager();
            $this->wp_customize      = $GLOBALS['wp_customize'];
        }

        public function test_active_theme() {
            $this->assertTrue( 'DemoCompany' == wp_get_theme() );
        } // end test_active_theme

        public function test_inactive_theme() {
            $this->assertFalse( 'Twenty Nineteen' == wp_get_theme() );

        } // end test_inactive_theme

        public function test_jQuery_isLoaded() {
            $this->assertFalse( wp_script_is( 'jquery') );

            do_action( 'wp_enqueue_scripts');
            $this->assertTrue( wp_script_is('jquery'));
            $this->assertTrue( wp_script_is('bootstrapjs'));
            $this->assertTrue( wp_script_is('popperjs'));
            $this->assertTrue( wp_script_is('democompany-navigation'));
            $this->assertTrue( wp_script_is('democompany-pages_script'));
            $this->assertTrue( wp_style_is('democompany-style'));
            $this->assertTrue( wp_style_is('bootstrap'));
            $this->assertTrue( wp_style_is('fontawesome'));
        }

        public function test_basic_meta_description() {
            $meta_description = '<meta name="description" content="' . get_bloginfo('description') . '" />';
            $this->expectOutputString($meta_description, democompany_basic_meta_description());
        }

        public function test_check_home() {
            $this->go_to('/');
            $this->assertQueryTrue('is_home', 'is_front_page');

            $this->go_to('/?p=1234546363');
            $this->assertQueryTrue('is_404');
        }

        public function test_ensure_footer_logo_and_copyright_is_cutomizable() {
            $this->assertTrue(has_action('customize_register'));
            $this->assertEquals(has_action('customize_register', 'democompany_customize_register'), 10);
            $this->assertEquals(did_action('customize_register'), 0);

            do_action('customize_register', $this->wp_customize);
            $this->assertEquals(did_action('customize_register'), 1);
            $this->assertEquals($this->wp_customize->get_setting('footer_logo_url')->id, 'footer_logo_url');
            $this->assertEquals($this->wp_customize->get_setting('footer_logo_url')->default, get_template_directory_uri() . '/images/logo.jpg');
            $this->assertEquals($this->wp_customize->get_setting('copyright_info')->id, 'copyright_info');
            $this->assertEquals($this->wp_customize->get_setting('copyright_info')->default, 'rtPanel. All Rights Reserved. Designed by rtCamp');
        }

        /*
            The remaining tests below are associated with the plugin test found in mu-plugins folder.
            Better as a separate file though but I'll be leaving it here since the plugin is a crucial
            part of the theme.
        */

        public function test_news_widget_construct() {
            $widget = new DemoCompany_Widget();
            $this->assertEquals( 'news_widget', $widget->id_base );
            $this->assertEquals( 'news_widget', $widget->widget_options['classname'] );
        }

        public function test_news_widget_functionality() {
            $widget  = new DemoCompany_Widget();
            $description = 'All News Here';

            $my_cat = self::factory()->category->create(
                array(
                    'name' => 'News',
                    'description' => $description,
                    'slug'         => 'news'
                )
            );

            $found_cat = category_description($my_cat);
            $expected_cat = apply_filters('term_description', $description);
            $this->assertSame($expected_cat, $found_cat);

            $category = get_term( $my_cat );
            $this->assertSame($expected_cat, $found_cat);
            $found_cat = wp_list_categories(
                array(
                    'hide_empty' => false,
                    'echo'       => false,
                )
            );
            $this->assertContains( 'class="cat-item cat-item-' . $my_cat . '"', $found_cat );


            $created_post_id = $this->factory()->post->create(array(
                'post_content'  => 'This is a test. This is only a Test. A big Test',
                'post_title'    => 'A Test Post',
                'post_excerpt'  => 'This is a test',
                'post_category' => array(2),
            ));

            $post_cat = (wp_get_post_categories($created_post_id));


            $args     = array(
                'before_title'  => '<h2>',
                'after_title'   => "</h2>\n",
                'before_widget' => '<section id="custom_html-5" class="widget widget_custom_html">',
                'after_widget'  => "</section>\n",
            );
            $instance = array(
                'category_to_display' => get_category($post_cat[0])->slug
            );


            $this->assertNotEmpty($instance['category_to_display']);
            $this->assertSame($instance['category_to_display'], "news");

            ob_start();
            //Now it's Time to test widget functionality
            $widget->widget( $args, $instance );
            $output = ob_get_clean();
            $this->assertContains('<ul class="no-bullet frontpage-widget-lists">', $output);
            $this->assertContains('<i class="fa fa-arrow-right news-arrow"></i>', $output);
            $this->assertContains('<a href="' . get_permalink( $created_post_id ) . '">', $output);
            $this->assertContains(get_the_excerpt( $created_post_id ), $output);
        }

        public function test_news_widget_outputs_nothing_when_post_is_not_in_news_category() {
            $widget = new DemoCompany_Widget();

            $new_post_without_news_category = $this->factory()->post->create(array(
                'post_content'  => 'This post has no News Category',
                'post_title'    => 'A Test Post with no News Category',
                'post_excerpt'  => 'This is an uncategorised post',
            ));
            $args     = array(
                'before_title'  => '<h2>',
                'after_title'   => "</h2>\n",
                'before_widget' => '<section id="custom_html-5" class="widget widget_custom_html">',
                'after_widget'  => "</section>\n",
            );
            $post_cat = (wp_get_post_categories($new_post_without_news_category));
            $instance = array(
                'category_to_display' => get_category($post_cat[0])->slug
            );
            $this->assertNotEmpty($instance['category_to_display']);
            $this->assertSame($instance['category_to_display'], 'uncategorized');

            ob_start();

            //we test that widget without news categories are not displayed
            $widget->widget( $args, $instance );
            $output = ob_get_clean();
            $this->assertNotContains($args['before_title'], $output);
            $this->assertNotContains('<ul class="no-bullet frontpage-widget-lists">', $output);
            $this->assertNotContains('<i class="fa fa-arrow-right news-arrow"></i>', $output);
            $this->assertNotContains('<a href="' . get_permalink( $new_post_without_news_category ) . '">', $output);
            $this->assertNotContains(get_the_excerpt( $new_post_without_news_category ), $output);
            $this->assertEquals(null, $output);
        }

        public function test_social_media_widget_construct() {
            $widget = new DC_SocialMedia_Widget();
            $this->assertEquals( 'socialmedia_widget', $widget->id_base );
            $this->assertEquals( 'socialmedia_widget', $widget->widget_options['classname'] );
        }

        public function test_no_output_with_zero_social_links() {
            $widget = new DC_SocialMedia_Widget();
            $args     = array(
                'before_title'  => '<h2>',
                'after_title'   => "</h2>\n",
                'before_widget' => '<section id="custom_html-5" class="widget widget_custom_html">',
                'after_widget'  => "</section>\n",
            );

            $instance = array(
                'title'         => 'My Test Title',
                'facebook_id'   => '',
                'twitter_id'    => '',
                'linkedin_id'   => '',
                'rss_id'        => ''
            );
            ob_start();

            $widget->widget( $args, $instance );
            $output = ob_get_clean();
            $this->assertNotContains($args['before_widget'], $output);
            $this->assertNotContains($args['before_title'], $output);
            $this->assertNotContains($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'], $output);
            $this->assertNotContains('<div class="social_media_links">', $output);
            $this->assertNotContains('<a href="https://facebook.com" target="_blank">', $output);
            $this->assertNotContains($args['after_widget'], $output);
        }

        public function test_smw_output_with_one_social_link() {
            $widget = new DC_SocialMedia_Widget();
            $args     = array(
                'before_title'  => '<h2>',
                'after_title'   => "</h2>\n",
                'before_widget' => '<section id="custom_html-5" class="widget widget_custom_html">',
                'after_widget'  => "</section>\n",
            );

            $instance = array(
                'title'         => 'My Test Title',
                'facebook_id'   => 'sleeky',
                'twitter_id'   => '',
                'linkedin_id'   => '',
                'rss_id'   => '',
            );
            ob_start();


            $widget->widget( $args, $instance );
            $output = ob_get_clean();
            $this->assertContains($args['before_widget'], $output);
            $this->assertContains($args['before_title'], $output);
            $this->assertContains($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'], $output);
            $this->assertContains('<div class="social_media_links">', $output);
            $this->assertContains('<a href="https://facebook.com/' .  $instance['facebook_id'] . '" target="_blank">', $output);
            $this->assertNotContains('<a href="https://twitter.com/' .  $instance['twitter_id'] . '" target="_blank">', $output);
            $this->assertNotContains('<a href="https://linkedin.com/' .  $instance['linkedin_id'] . '" target="_blank">', $output);
            $this->assertNotContains('<a href="https://rss.com/' .  $instance['rss_id'] . '" target="_blank">', $output);
            $this->assertContains($args['after_widget'], $output);
            $this->assertNotEquals(null, $output);
        }

        public function test_smw_output_with_all_social_links() {
            $widget = new DC_SocialMedia_Widget();
            $args     = array(
                'before_title'  => '<h2>',
                'after_title'   => "</h2>\n",
                'before_widget' => '<section id="custom_html-5" class="widget widget_custom_html">',
                'after_widget'  => "</section>\n",
            );

            $instance = array(
                'title'         => 'My Test Title',
                'facebook_id'   => 'sleeky',
                'twitter_id'   => 'sleeky',
                'linkedin_id'   => 'sleeky',
                'rss_id'   => 'sleeky',
            );
            ob_start();


            $widget->widget( $args, $instance );
            $output = ob_get_clean();
            $this->assertContains($args['before_widget'], $output);
            $this->assertContains($args['before_title'], $output);
            $this->assertContains($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'], $output);
            $this->assertContains('<div class="social_media_links">', $output);
            $this->assertContains('<a href="https://facebook.com/' .  $instance['facebook_id'] . '" target="_blank">', $output);
            $this->assertContains('<a href="https://twitter.com/' .  $instance['twitter_id'] . '" target="_blank">', $output);
            $this->assertContains('<a href="https://linkedin.com/' .  $instance['linkedin_id'] . '" target="_blank">', $output);
            $this->assertContains('<a href="https://rss.com/' .  $instance['rss_id'] . '" target="_blank">', $output);
            $this->assertContains($args['after_widget'], $output);
            $this->assertNotEquals(null, $output);
        }
    }
?>