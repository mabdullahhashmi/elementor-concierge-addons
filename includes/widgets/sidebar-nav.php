<?php
/**
 * Sidebar Nav Widget
 */

class Elementor_Sidebar_Nav extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'sidebar-nav';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'Sidebar Nav', 'elementor-concierge-addons' );
	}

	/**
	 * Get widget icon
	 */
	public function get_icon() {
		return 'eicon-nav-menu';
	}

	/**
	 * Get widget categories
	 */
	public function get_categories() {
		return [ 'concierge-golf' ];
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {

		// ──── CONTENT TAB ────
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'nav_label',
			[
				'label'       => esc_html__( 'Label', 'elementor-concierge-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'e.g., Trip Highlights', 'elementor-concierge-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'nav_link',
			[
				'label'       => esc_html__( 'Link / Section ID', 'elementor-concierge-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'e.g., #highlights', 'elementor-concierge-addons' ),
				'description' => esc_html__( 'Enter the # anchor link or section ID', 'elementor-concierge-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'nav_items',
			[
				'label'       => esc_html__( 'Navigation Items', 'elementor-concierge-addons' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'nav_label' => esc_html__( 'Trip Highlights', 'elementor-concierge-addons' ),
						'nav_link'  => '#highlights',
					],
					[
						'nav_label' => esc_html__( 'Itinerary', 'elementor-concierge-addons' ),
						'nav_link'  => '#itinerary',
					],
					[
						'nav_label' => esc_html__( 'Golf Courses', 'elementor-concierge-addons' ),
						'nav_link'  => '#courses',
					],
				],
				'title_field' => '{{{ nav_label }}}',
			]
		);

		$this->add_control(
			'enable_scroll_spy',
			[
				'label'        => esc_html__( 'Enable Scroll Spy', 'elementor-concierge-addons' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'elementor-concierge-addons' ),
				'label_off'    => esc_html__( 'No', 'elementor-concierge-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'Automatically highlight active section while scrolling', 'elementor-concierge-addons' ),
			]
		);

		$this->add_control(
			'scroll_offset',
			[
				'label'       => esc_html__( 'Scroll Offset (px)', 'elementor-concierge-addons' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 150,
				'description' => esc_html__( 'Additional offset for scroll spy detection', 'elementor-concierge-addons' ),
				'condition'   => [
					'enable_scroll_spy!' => '',
				],
			]
		);

		$this->end_controls_section();

		// ──── STYLE TAB - CONTAINER ────
		$this->start_controls_section(
			'section_style_container',
			[
				'label' => esc_html__( 'Container', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'container_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f7f5f0',
				'selectors' => [
					'{{WRAPPER}} .sidebar-nav' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'container_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#dde3ec',
				'selectors' => [
					'{{WRAPPER}} .sidebar-nav' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'container_border_width',
			[
				'label'      => esc_html__( 'Border Width (px)', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'    => 1,
				'min'        => 0,
				'max'        => 10,
				'selectors'  => [
					'{{WRAPPER}} .sidebar-nav' => 'border-width: {{VALUE}}px; border-style: solid;',
				],
			]
		);

		$this->add_control(
			'container_border_radius',
			[
				'label'      => esc_html__( 'Border Radius (px)', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'    => 3,
				'min'        => 0,
				'max'        => 50,
				'selectors'  => [
					'{{WRAPPER}} .sidebar-nav' => 'border-radius: {{VALUE}}px;',
				],
			]
		);

		$this->add_control(
			'container_margin_bottom',
			[
				'label'      => esc_html__( 'Margin Bottom (px)', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'    => 24,
				'min'        => 0,
				'selectors'  => [
					'{{WRAPPER}} .sidebar-nav' => 'margin-bottom: {{VALUE}}px;',
				],
			]
		);

		$this->end_controls_section();

		// ──── STYLE TAB - ITEMS ────
		$this->start_controls_section(
			'section_style_items',
			[
				'label' => esc_html__( 'Navigation Items', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'item_typography',
				'label'    => esc_html__( 'Typography', 'elementor-concierge-addons' ),
				'selector' => '{{WRAPPER}} .sidebar-nav a',
			]
		);

		$this->add_control(
			'item_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6b7a8d',
				'selectors' => [
					'{{WRAPPER}} .sidebar-nav a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'    => '12',
					'right'  => '20',
					'bottom' => '12',
					'left'   => '20',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .sidebar-nav a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#dde3ec',
				'selectors' => [
					'{{WRAPPER}} .sidebar-nav li' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ──── STYLE TAB - HOVER/ACTIVE ────
		$this->start_controls_section(
			'section_style_hover',
			[
				'label' => esc_html__( 'Hover & Active', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_text_color',
			[
				'label'     => esc_html__( 'Text Color (Hover/Active)', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1d3461',
				'selectors' => [
					'{{WRAPPER}} .sidebar-nav a:hover, {{WRAPPER}} .sidebar-nav a.is-active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color (Hover/Active)', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .sidebar-nav a:hover, {{WRAPPER}} .sidebar-nav a.is-active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'indicator_color',
			[
				'label'     => esc_html__( 'Indicator Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#c4973a',
				'selectors' => [
					'{{WRAPPER}} .sidebar-nav a::before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'active_indicator_color',
			[
				'label'     => esc_html__( 'Active Indicator Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#c4973a',
				'selectors' => [
					'{{WRAPPER}} .sidebar-nav a:hover::before, {{WRAPPER}} .sidebar-nav a.is-active::before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'indicator_size',
			[
				'label'      => esc_html__( 'Indicator Size (px)', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'    => 5,
				'min'        => 2,
				'max'        => 15,
				'selectors'  => [
					'{{WRAPPER}} .sidebar-nav a::before' => 'width: {{VALUE}}px; height: {{VALUE}}px;',
				],
			]
		);

		$this->add_control(
			'hover_padding_left',
			[
				'label'      => esc_html__( 'Hover Padding Left (px)', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'    => 26,
				'min'        => 0,
				'selectors'  => [
					'{{WRAPPER}} .sidebar-nav a:hover, {{WRAPPER}} .sidebar-nav a.is-active' => 'padding-left: {{VALUE}}px;',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$nav_items = $settings['nav_items'];
		$enable_scroll_spy = $settings['enable_scroll_spy'];
		$scroll_offset = intval( $settings['scroll_offset'] );

		?>
		<nav class="sidebar-nav" data-scroll-spy="<?php echo esc_attr( $enable_scroll_spy ? 'true' : 'false' ); ?>" data-scroll-offset="<?php echo esc_attr( $scroll_offset ); ?>">
			<ul>
				<?php
				foreach ( $nav_items as $item ) {
					$nav_label = $item['nav_label'];
					$nav_link  = $item['nav_link'];
					?>
					<li>
						<a href="<?php echo esc_url( $nav_link ); ?>" class="nav-link" data-section="<?php echo esc_attr( ltrim( $nav_link, '#' ) ); ?>">
							<?php echo esc_html( $nav_label ); ?>
						</a>
					</li>
					<?php
				}
				?>
			</ul>
		</nav>
		<?php
	}

	/**
	 * Render plain content
	 */
	protected function content_template() {
		?>
		<nav class="sidebar-nav" data-scroll-spy="{{{ settings.enable_scroll_spy ? 'true' : 'false' }}}" data-scroll-offset="{{{ settings.scroll_offset }}}">
			<ul>
				<# _.each( settings.nav_items, function( item ) { #>
					<li>
						<a href="{{{ item.nav_link }}}" class="nav-link" data-section="{{{ item.nav_link.replace('#', '') }}}">
							{{{ item.nav_label }}}
						</a>
					</li>
				<# }); #>
			</ul>
		</nav>
		<?php
	}
}
