<?php

class WP_Test_Jetpack_Shortcodes_Vimeo extends WP_UnitTestCase {

	/**
	 * @author scotchfield
	 * @covers ::vimeo_shortcode
	 * @since 3.2
	 */
	public function test_shortcodes_vimeo_exists() {
		$this->assertEquals( shortcode_exists( 'vimeo' ), true );
	}

	/**
	 * @author scotchfield
	 * @covers ::vimeo_shortcode
	 * @since 3.2
	 */
	public function test_shortcodes_vimeo() {
		$content = '[vimeo]';

		$shortcode_content = do_shortcode( $content );

		$this->assertNotEquals( $content, $shortcode_content );
	}

	/**
	 * @author scotchfield
	 * @covers ::vimeo_shortcode
	 * @since 3.2
	 */
	public function test_shortcodes_vimeo_id() {
		$video_id = '141358';
		$content = '[vimeo ' . $video_id . ']';

		$shortcode_content = do_shortcode( $content );

		$this->assertContains( 'vimeo.com/video/' . $video_id, $shortcode_content );
	}

	/**
	 * @author scotchfield
	 * @covers ::vimeo_shortcode
	 * @since 3.2
	 */
	public function test_shortcodes_vimeo_url() {
		$video_id = '141358';
		$url = 'http://vimeo.com/' . $video_id;
		$content = '[vimeo ' . $url . ']';

		$shortcode_content = do_shortcode( $content );

		$this->assertContains( 'vimeo.com/video/' . $video_id, $shortcode_content );
	}

	/**
	 * @author scotchfield
	 * @covers ::vimeo_shortcode
	 * @since 3.2
	 */
	public function test_shortcodes_w_h() {
		$video_id = '141358';
		$width = '350';
		$height = '500';
		$content = '[vimeo ' . $video_id . ' w=' . $width . '&h=' . $height . ']';

		$shortcode_content = do_shortcode( $content );

		$this->assertContains( 'vimeo.com/video/' . $video_id, $shortcode_content );
		$this->assertContains( 'width="' . $width . '"', $shortcode_content );
		$this->assertContains( 'height="' . $height . '"', $shortcode_content );
	}

	/**
	 * @author scotchfield
	 * @covers ::vimeo_shortcode
	 * @since 3.2
	 */
	public function test_shortcodes_width_height() {
		$video_id = '141358';
		$width = '350';
		$height = '500';
		$content = '[vimeo ' . $video_id . ' width=' . $width . ' height=' . $height . ']';

		$shortcode_content = do_shortcode( $content );

		$this->assertContains( 'vimeo.com/video/' . $video_id, $shortcode_content );
		$this->assertContains( 'width="' . $width . '"', $shortcode_content );
		$this->assertContains( 'height="' . $height . '"', $shortcode_content );
	}

	/**
	 * @author Toro_Unit
	 * @covers ::vimeo_shortcode
	 * @since 3.9
	 */
	public function test_replace_url_with_iframe_in_the_content() {
		global $post;

		$video_id = '141358';
		$url = 'http://vimeo.com/' . $video_id;
		$post = $this->factory->post->create_and_get( array( 'post_content' => $url ) );

		do_action( 'init' );
		setup_postdata( $post );
		ob_start();
		the_content();
		$actual = ob_get_clean();
		wp_reset_postdata();
		$this->assertContains( '<div class="embed-vimeo"', $actual );
		$this->assertContains( '<iframe src="https://player.vimeo.com/video/'.$video_id.'"', $actual );
	}

}