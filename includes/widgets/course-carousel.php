<?php
/**
 * Course Carousel Widget
 */

class Elementor_Course_Carousel extends \Elementor\Widget_Base {

	public function get_name() {
		return 'course-carousel';
	}

	public function get_title() {
		return esc_html__( 'Course Carousel', 'elementor-concierge-addons' );
	}

	public function get_icon() {
		return 'eicon-slides';
	}

	public function get_categories() {
		return [ 'concierge-golf' ];
	}

	protected function register_controls() {

		// ── CONTENT: Cards ────────────────────────────────────────────
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Carousel Cards', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'card_image',
			[
				'label'   => esc_html__( 'Image', 'elementor-concierge-addons' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
			]
		);

		$repeater->add_control(
			'card_tag',
			[
				'label'       => esc_html__( 'Tag', 'elementor-concierge-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Featured', 'elementor-concierge-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'card_title_line1',
			[
				'label'       => esc_html__( 'Title Line 1', 'elementor-concierge-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Castle Course', 'elementor-concierge-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'card_title_line2',
			[
				'label'       => esc_html__( 'Title Line 2 (Italic)', 'elementor-concierge-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'St Andrews', 'elementor-concierge-addons' ),
				'placeholder' => esc_html__( 'Optional — shown in italic', 'elementor-concierge-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'carousel_items',
			[
				'label'       => esc_html__( 'Cards', 'elementor-concierge-addons' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ card_title_line1 }}}',
				'default'     => [
					[
						'card_tag'         => 'Featured',
						'card_title_line1' => 'Castle Course',
						'card_title_line2' => 'St Andrews',
					],
					[
						'card_tag'         => 'Historic',
						'card_title_line1' => 'New Course',
						'card_title_line2' => 'St Andrews',
					],
					[
						'card_tag'         => 'Open Venue',
						'card_title_line1' => 'Carnoustie',
						'card_title_line2' => 'Golf Club',
					],
					[
						'card_tag'         => 'World Top 100',
						'card_title_line1' => 'Kingsbarns',
						'card_title_line2' => 'Golf Links',
					],
				],
			]
		);

		$this->end_controls_section();

		// ── CONTENT: Settings ─────────────────────────────────────────
		$this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__( 'Settings', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'slides_to_show',
			[
				'label'          => esc_html__( 'Slides to Show', 'elementor-concierge-addons' ),
				'type'           => \Elementor\Controls_Manager::NUMBER,
				'default'        => 2,
				'tablet_default' => 1.5,
				'mobile_default' => 1.1,
				'min'            => 1,
				'max'            => 6,
				'step'           => 0.1,
				'selectors'      => [
					'{{WRAPPER}} .cgc-wrapper' => '--cgc-slides: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'cards_gap',
			[
				'label'      => esc_html__( 'Cards Gap', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .cgc-wrapper' => '--cgc-gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .cgc-track'   => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_aspect_ratio',
			[
				'label'      => esc_html__( 'Image Height (%)', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [ '%' => [ 'min' => 30, 'max' => 150 ] ],
				'default'    => [ 'unit' => '%', 'size' => 70 ],
				'selectors'  => [
					'{{WRAPPER}} .cgc-card-img' => 'padding-top: {{SIZE}}%;',
				],
			]
		);

		$this->add_control(
			'carousel_speed',
			[
				'label'   => esc_html__( 'Slide Speed (ms)', 'elementor-concierge-addons' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 700,
				'min'     => 100,
				'max'     => 3000,
			]
		);

		$this->add_control(
			'autoplay_enabled',
			[
				'label'        => esc_html__( 'Autoplay', 'elementor-concierge-addons' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'elementor-concierge-addons' ),
				'label_off'    => esc_html__( 'No', 'elementor-concierge-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'autoplay_delay',
			[
				'label'     => esc_html__( 'Autoplay Delay (ms)', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 4000,
				'min'       => 500,
				'max'       => 15000,
				'condition' => [ 'autoplay_enabled' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// ── STYLE: Card ───────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_card',
			[
				'label' => esc_html__( 'Card', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#0a1228',
				'selectors' => [ '{{WRAPPER}} .cgc-card' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => 4,
					'right'    => 4,
					'bottom'   => 4,
					'left'     => 4,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .cgc-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ── STYLE: Overlay ────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_overlay',
			[
				'label' => esc_html__( 'Image Overlay', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_bottom_color',
			[
				'label'     => esc_html__( 'Bottom Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(10,18,40,0.95)',
				'selectors' => [ '{{WRAPPER}} .cgc-card-overlay' => '--cgc-ov-b: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'overlay_mid_color',
			[
				'label'     => esc_html__( 'Mid Color (45%)', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(10,18,40,0.40)',
				'selectors' => [ '{{WRAPPER}} .cgc-card-overlay' => '--cgc-ov-m: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'overlay_top_color',
			[
				'label'     => esc_html__( 'Top Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(10,18,40,0)',
				'selectors' => [ '{{WRAPPER}} .cgc-card-overlay' => '--cgc-ov-t: {{VALUE}};' ],
			]
		);

		$this->end_controls_section();

		// ── STYLE: Tag ────────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_tag',
			[
				'label' => esc_html__( 'Tag', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'tag_typography',
				'selector' => '{{WRAPPER}} .cgc-card-tag',
			]
		);

		$this->add_control(
			'tag_color',
			[
				'label'     => esc_html__( 'Text Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#d4a847',
				'selectors' => [ '{{WRAPPER}} .cgc-card-tag' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'tag_bg_color',
			[
				'label'     => esc_html__( 'Background', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(196,151,58,0.15)',
				'selectors' => [ '{{WRAPPER}} .cgc-card-tag' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'tag_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(196,151,58,0.30)',
				'selectors' => [ '{{WRAPPER}} .cgc-card-tag' => 'border-color: {{VALUE}};' ],
			]
		);

		$this->add_responsive_control(
			'tag_padding',
			[
				'label'      => esc_html__( 'Padding', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .cgc-card-tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ── STYLE: Title ──────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Title', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .cgc-card-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [ '{{WRAPPER}} .cgc-card-title' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'title_em_color',
			[
				'label'     => esc_html__( 'Italic Part Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#d4a847',
				'selectors' => [ '{{WRAPPER}} .cgc-card-title em' => 'color: {{VALUE}};' ],
			]
		);

		$this->end_controls_section();

		// ── STYLE: Navigation ─────────────────────────────────────────
		$this->start_controls_section(
			'section_style_nav',
			[
				'label' => esc_html__( 'Navigation', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'arrow_size',
			[
				'label'     => esc_html__( 'Arrow Button Size (px)', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 40,
				'min'       => 24,
				'max'       => 80,
				'selectors' => [
					'{{WRAPPER}} .cgc-arr-btn' => 'width: {{VALUE}}px; height: {{VALUE}}px;',
				],
			]
		);

		$this->start_controls_tabs( 'arrow_tabs' );

		$this->start_controls_tab(
			'arrow_normal',
			[ 'label' => esc_html__( 'Normal', 'elementor-concierge-addons' ) ]
		);

		$this->add_control(
			'arrow_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#dde3ec',
				'selectors' => [ '{{WRAPPER}} .cgc-arr-btn' => 'border-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'arrow_bg_color',
			[
				'label'     => esc_html__( 'Background', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => [ '{{WRAPPER}} .cgc-arr-btn' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'arrow_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1d3461',
				'selectors' => [ '{{WRAPPER}} .cgc-arr-btn svg' => 'stroke: {{VALUE}};' ],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'arrow_hover',
			[ 'label' => esc_html__( 'Hover', 'elementor-concierge-addons' ) ]
		);

		$this->add_control(
			'arrow_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1d3461',
				'selectors' => [ '{{WRAPPER}} .cgc-arr-btn:hover' => 'border-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'arrow_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1d3461',
				'selectors' => [ '{{WRAPPER}} .cgc-arr-btn:hover' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'arrow_icon_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [ '{{WRAPPER}} .cgc-arr-btn:hover svg' => 'stroke: {{VALUE}};' ],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'progress_track_color',
			[
				'label'     => esc_html__( 'Progress Track Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#dde3ec',
				'selectors' => [ '{{WRAPPER}} .cgc-progress-track' => 'background-color: {{VALUE}};' ],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'progress_fill_color',
			[
				'label'     => esc_html__( 'Progress Fill Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1d3461',
				'selectors' => [ '{{WRAPPER}} .cgc-progress-fill' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'dot_color',
			[
				'label'     => esc_html__( 'Dot Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#dde3ec',
				'selectors' => [ '{{WRAPPER}} .cgc-dot' => 'background-color: {{VALUE}};' ],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dot_active_color',
			[
				'label'     => esc_html__( 'Dot Active Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1d3461',
				'selectors' => [ '{{WRAPPER}} .cgc-dot.is-active' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output
	 */
	protected function render() {
		$settings  = $this->get_settings_for_display();
		$items     = ! empty( $settings['carousel_items'] ) ? $settings['carousel_items'] : [];
		if ( empty( $items ) ) {
			return;
		}

		$speed     = absint( $settings['carousel_speed'] ?? 700 );
		$autoplay  = ( 'yes' === ( $settings['autoplay_enabled'] ?? '' ) )
			? absint( $settings['autoplay_delay'] ?? 4000 )
			: 0;
		?>
		<div class="cgc-wrapper" data-speed="<?php echo esc_attr( $speed ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
			<div class="cgc-viewport">
				<div class="cgc-track">
					<?php foreach ( $items as $item ) : ?>
					<div class="cgc-card">
						<div class="cgc-card-img">
							<?php if ( ! empty( $item['card_image']['url'] ) ) : ?>
							<img
								src="<?php echo esc_url( $item['card_image']['url'] ); ?>"
								alt="<?php echo esc_attr( $item['card_title_line1'] ); ?>"
								loading="lazy"
							/>
							<?php endif; ?>
						</div>
						<div class="cgc-card-overlay"></div>
						<div class="cgc-card-body">
							<?php if ( ! empty( $item['card_tag'] ) ) : ?>
							<span class="cgc-card-tag"><?php echo esc_html( $item['card_tag'] ); ?></span>
							<?php endif; ?>
							<h3 class="cgc-card-title">
								<?php echo esc_html( $item['card_title_line1'] ); ?>
								<?php if ( ! empty( $item['card_title_line2'] ) ) : ?>
								<br><em><?php echo esc_html( $item['card_title_line2'] ); ?></em>
								<?php endif; ?>
							</h3>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="cgc-footer">
				<div class="cgc-arrows">
					<button class="cgc-arr-btn cgc-arr-prev" aria-label="<?php esc_attr_e( 'Previous', 'elementor-concierge-addons' ); ?>">
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
							<path d="M10 4L6 8l4 4"/>
						</svg>
					</button>
					<button class="cgc-arr-btn cgc-arr-next" aria-label="<?php esc_attr_e( 'Next', 'elementor-concierge-addons' ); ?>">
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
							<path d="M6 4l4 4-4 4"/>
						</svg>
					</button>
				</div>
				<div class="cgc-progress-track"><div class="cgc-progress-fill"></div></div>
				<div class="cgc-dots"></div>
			</div>
		</div>
		<?php
	}

	/**
	 * Elementor editor live preview
	 */
	protected function content_template() {
		?>
		<# if ( settings.carousel_items && settings.carousel_items.length ) { #>
		<div class="cgc-wrapper"
			data-speed="{{{ settings.carousel_speed || 700 }}}"
			data-autoplay="{{{ settings.autoplay_enabled === 'yes' ? ( settings.autoplay_delay || 4000 ) : 0 }}}">
			<div class="cgc-viewport">
				<div class="cgc-track">
					<# _.each( settings.carousel_items, function( item ) { #>
					<div class="cgc-card">
						<div class="cgc-card-img">
							<# if ( item.card_image && item.card_image.url ) { #>
							<img src="{{{ item.card_image.url }}}" alt="{{{ item.card_title_line1 }}}" loading="lazy" />
							<# } #>
						</div>
						<div class="cgc-card-overlay"></div>
						<div class="cgc-card-body">
							<# if ( item.card_tag ) { #>
							<span class="cgc-card-tag">{{{ item.card_tag }}}</span>
							<# } #>
							<h3 class="cgc-card-title">
								{{{ item.card_title_line1 }}}
								<# if ( item.card_title_line2 ) { #><br><em>{{{ item.card_title_line2 }}}</em><# } #>
							</h3>
						</div>
					</div>
					<# }); #>
				</div>
			</div>
			<div class="cgc-footer">
				<div class="cgc-arrows">
					<button class="cgc-arr-btn cgc-arr-prev" aria-label="Previous">
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10 4L6 8l4 4"/></svg>
					</button>
					<button class="cgc-arr-btn cgc-arr-next" aria-label="Next">
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 4l4 4-4 4"/></svg>
					</button>
				</div>
				<div class="cgc-progress-track"><div class="cgc-progress-fill"></div></div>
				<div class="cgc-dots"></div>
			</div>
		</div>
		<# } #>
		<?php
	}
}
