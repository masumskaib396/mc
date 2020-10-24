<?php
/**
 * Thmpw Logo Widget.
 *
 *
 * @since 1.0.0
 */
namespace Mc\Widgets\Elementor;

use  Elementor\Widget_Base;
use  Elementor\Controls_Manager;
use  Elementor\utils;


if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Mc_blog extends \Elementor\Widget_Base{

	public function get_name(){
		return 'mc_post';
	}

	public function get_title(){
		return __('Blog Post', 'mc');
	}

	public function get_icon(){
		return ('eicon-logo');
	}

	public function get_categories(){
		return ['mc'];
	}

	public function get_keywords(){
		return ['post', 'blog'];
	}

	protected function _register_controls(){

		$this->start_controls_section('blog_post',
			[
				'label' => __( 'Blog Post', 'mc' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'post_per_page',
            [
                'label' => __( 'Post Per Page', 'mc' ),
                'type' => Controls_Manager::TEXT,
                'default' => 3,
            ]
        );


		$this->end_controls_section();


	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$post_per_page = $settings['post_per_page'];

		$args = [
			'post_type' => 'post',
			'posts_per_page' => $post_per_page,
			'post_status' => 'publish',
		];


		$query = new \WP_Query( $args );


		
				  

		?>

		<div class="mc-blog-wraper">
			<?php 

			while($query->have_posts() ): $query->the_post();
				$args = array(
				  'orderby' => 'name',
				  'order' => 'ASC',
				  'number' => 3, // how many categories
				  );
				$categories = get_categories($args);

				
			    
			    $permalink = get_permalink();
			   


			 ?>
				<div class="btSingleLatestPost inherit mc-singel-item">
					<div class="btSingleLatestPostImage btTextCenter">
						<div class="bpgPhoto out-right">
							<a href="" target="_self" title=""></a>
							<div class="boldPhotoBox">
								<div class="bpbItem">
									<div class="btImage">
										<?php the_post_thumbnail('medium'); ?>
									</div>
								</div>
							</div>
							<div class="captionPane">
								<div class="captionTable">
									<div class="captionCell">
										<div class="captionTxt"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<span class="btIco btIcoMediumSize btIcoFilledType btIcoAccentColor"><a class="btIcoHolder" data-ico-cs="" href=""><em></em></a></span>
					<div class="btSingleLatestPostContent">
						<div class="btSLPCCwrap">
							<header class="header btClear medium btAlternateDash">
								<div class="btSuperTitle">
									<span class="btArticleDate"><?php echo get_the_date(); ?></span>
										<a class="btArticleAuthor" href=""><?php the_author(); ?></a>
								</div>
								<div class="dash">
									<h3>
										<span class="headline"><a href="<?php the_permalink(); ?>" target="_self"><?php the_title(); ?></a></span>
									</h3>
								</div>
							</header>
							<p class="btLatestPostContent">
								<?php the_excerpt(); ?>
							</p>
							<div class="btSingleLatestPostFooter">
								<?php
									foreach($categories as $category) { 
									    echo '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.' </a> ';
									    } 
								 ?>

									 <a class="btArticleComments" href="<?php echo esc_url( $permalink) ?>#comments" class="comments_link"> 
									 	<?php comments_number(); ?>
									 </a>
							

							</div>
						</div>
					</div>
				</div>
		<?php endwhile; wp_reset_postdata(); ?>
		</div>
		<?php

	}

}


