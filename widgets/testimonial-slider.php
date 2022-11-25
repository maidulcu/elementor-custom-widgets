<?php
    namespace DwlElementorAddon\Widgets;

    use Elementor\Widget_Base;
    use Elementor\Controls_Manager;
	use Elementor\Core\Schemes\Color;
	use Elementor\Core\Schemes\Typography;
	use Elementor\Group_Control_Typography;

    class Testimonial_Slider extends Widget_Base {

        public function get_name() {
            return 'Unitek-Elementor-Addon';
        }

        public function get_title() {
            return esc_html__( 'Testimonial Slider', 'unitek-elementor' );
        }

        public function get_icon() {
            return 'eicon-code';
        }

        public function get_categories() {
            return [ 'general' ];
        }

        public function get_keywords() {
            return [ 'testimonial', 'unitek', 'unitek testimonial' ];
        }

		/**
		 * Register the widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @since 1.0.0
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'section_content',
				[
					'label' => __( 'Testimonial Slider', 'unitek-elementor' ),
				]
			);

			$repeater = new \Elementor\Repeater();

			$repeater->add_control(
				'image', [
					'label'     => __( 'Author Image', 'unitek-elementor' ),
					'type'      => \Elementor\Controls_Manager::MEDIA,
					'separator' => 'before'
				]
			);

			$repeater->add_control(
				'name', [
					'label'       => __( 'Name', 'unitek-elementor' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'designation', [
					'label'       => __( 'Designation', 'unitek-elementor' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'label_block' => true,
				]
			);

// 			$repeater->add_control(
// 				'content', [
// 					'label'       => __( 'Content', 'unitek-elementor' ),
// 					'type'        => \Elementor\Controls_Manager::TEXTAREA,
// 					'label_block' => true,
// 				]
// 			);

			$repeater->add_control(
				'editor', [
					'label'       => __( 'HTML Editor', 'unitek-elementor' ),
					'type'        => \Elementor\Controls_Manager::WYSIWYG,
					'label_block' => true,
				]
			);

			$this->add_control(
				'unitek_testimonial',
				[
					'label'       => __( 'Create Testimonial', 'unitek-elementor' ),
					'type'        => \Elementor\Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'title_field' => '{{{ name }}}',
				]
			);
			
			$this->end_controls_section();

			$this->start_controls_section(
				'section_content_setting',
				[
					'label' => __( 'Slider Settings', 'unitek-elementor' ),
				]
			);
			
			$this->add_control(
			'alignment',
				[
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'label' => esc_html__( 'Alignment', 'unitek-elementor' ),
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'unitek-elementor' ),
							'icon' => 'eicon-text-align-left',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'unitek-elementor' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'default' => 'left',
				]
			);

			
			$this->end_controls_section();
			
			/**
			 * Start Style Section
			 */
			$this->start_controls_section(
				'section_style',
				[
					'label' => __( 'Style', 'unitek-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'color_content', [
					'label'     => esc_html__( 'Content Text Color', 'unitek-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .unitek-testimonial-content p' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'content_typography',
					'label' => __( 'Content Typography', 'unitek-elementor' ),
					'scheme' => Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .unitek-testimonial-content p',
				]
			);

			$this->add_control(
				'color_name', [
					'label'     => esc_html__( 'Name Color', 'unitek-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .unitek-testimonial-name' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'name_typography',
					'label' => __( 'Name Typography', 'unitek-elementor' ),
					'scheme' => Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .unitek-testimonial-name',
				]
			);

			$this->add_control(
				'color_designation', [
					'label'     => esc_html__( 'Designation Color', 'unitek-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .unitek-testimonial-designation' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'designation_typography',
					'label' => __( 'Designation Typography', 'unitek-elementor' ),
					'scheme' => Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .unitek-testimonial-designation',
				]
			);

			$this->add_control(
				'color_quote_bg', [
					'label'     => esc_html__( 'Quote Background Color', 'unitek-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .unitek-quote-icon span.dashicons' => 'background: {{VALUE}};',
					],
				]
			);

			$this->end_controls_section();

		}

		protected function render() {
			$settings = $this->get_settings_for_display();
			$testimonials = ! empty( $settings['unitek_testimonial'] ) ? $settings['unitek_testimonial'] : '';
			$alignment = ! empty( $settings['alignment'] ) ? $settings['alignment'] : 'left';
			?>

			<div id="unitek-testimonial-slider" class="unitek-testimonial-slider">
				<?php
				if( $testimonials ):
					foreach ( $testimonials as $index => $item ):
					?>
						<div class="unitek-testimonial-item">

							<?php if( !empty( $item['image']['url'] ) AND 'left' == $alignment ):?>
								<div class="testimonial-image-item">
									<img data-lazy="<?php echo $item['image']['url'];?>" src="<?php echo $item['image']['url'];?>" alt="<?php echo  $item['name'];?>" />
								</div>
							<?php endif; ?>

							<div class="testimonial-content">

								<div class="unitek-quote-icon">
									<span class="dashicons dashicons-format-quote"></span>
								</div>

								<?php if( !empty( $item['content'] ) ||  !empty( $item['editor'] ) ):?>
									<div class="unitek-testimonial-content">
										<p><?php echo esc_html( $item['content'] ); ?></p>
										<?php echo $item['editor']; ?>
									</div>
								<?php endif; ?>
								
								<?php if( !empty( $item['name'] ) ):?>
									<span class="unitek-testimonial-name">
										<?php echo esc_html( $item['name'] ); ?>
									</span>
								<?php endif; ?>
								
								<?php if( !empty( $item['designation'] ) ):?>
									<span class="unitek-testimonial-designation">
										<?php echo esc_html( $item['designation'] ); ?>
									</span>
								<?php endif; ?>

							</div>
							
							<?php if( !empty( $item['image']['url'] ) AND 'right' == $alignment ):?>
								<div class="testimonial-image-item">
									<img data-lazy="<?php echo $item['image']['url'];?>" src="<?php echo $item['image']['url'];?>" alt="<?php echo  $item['name'];?>" />
								</div>
							<?php endif; ?>

						</div>
					<?php
					endforeach; 
				endif;
				?>
			</div>

		<?php
			
		}
}