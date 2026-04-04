<?php
/**
 * Sidebar Nav Title Widget
 */

class Elementor_Sidebar_Nav_Title extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'sidebar-nav-title';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'Sidebar Nav Title', 'elementor-concierge-addons' );
	}

	/**
	 * Get widget icon
	 */
	public function get_icon() {
		return 'eicon-text';
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

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'elementor-concierge-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'On this page', 'elementor-concierge-addons' ),
				'placeholder' => esc_html__( 'Enter title', 'elementor-concierge-addons' ),
			]
		);

		$this->end_controls_section();

		// ──── STYLE TAB ────
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1d3461',
				'selectors' => [
					'{{WRAPPER}} .sidebar-nav-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.7)',
				'selectors' => [
					'{{WRAPPER}} .sidebar-nav-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'label'    => esc_html__( 'Typography', 'elementor-concierge-addons' ),
				'selector' => '{{WRAPPER}} .sidebar-nav-title',
			]
		);

		$this->add_control(
			'padding',
			[
				'label'      => esc_html__( 'Padding', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => '14',
					'right'  => '20',
					'bottom' => '14',
					'left'   => '20',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .sidebar-nav-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '3',
					'right'  => '3',
					'bottom' => '3',
					'left'   => '3',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .sidebar-nav-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		?>
		<div class="sidebar-nav-title">
			<?php echo esc_html( $settings['title'] ); ?>
		</div>
		<?php
	}

	/**
	 * Render plain content
	 */
	protected function content_template() {
		?>
		<div class="sidebar-nav-title">
			{{{ settings.title }}}
		</div>
		<?php
	}
}
