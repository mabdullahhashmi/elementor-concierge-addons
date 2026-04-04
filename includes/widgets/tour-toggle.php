<?php
/**
 * Tour Toggle Widget
 */

class Elementor_Tour_Toggle extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'tour-toggle';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'Tour Toggle', 'elementor-concierge-addons' );
	}

	/**
	 * Get widget icon
	 */
	public function get_icon() {
		return 'eicon-toggle';
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
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Toggle Items', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'day_text',
			[
				'label'       => esc_html__( 'Day Text', 'elementor-concierge-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Day 1', 'elementor-concierge-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'title_text',
			[
				'label'       => esc_html__( 'Title', 'elementor-concierge-addons' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Arrival and Welcome Round', 'elementor-concierge-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'content_text',
			[
				'label'   => esc_html__( 'Content', 'elementor-concierge-addons' ),
				'type'    => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Arrive at your hotel, enjoy a welcome dinner, and prepare for tomorrow\'s first tee time.', 'elementor-concierge-addons' ),
			]
		);

		$this->add_control(
			'toggle_items',
			[
				'label'       => esc_html__( 'Items', 'elementor-concierge-addons' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ day_text }}} - {{{ title_text }}}',
				'default'     => [
					[
						'day_text'     => esc_html__( 'Day 1', 'elementor-concierge-addons' ),
						'title_text'   => esc_html__( 'Arrival and Welcome Round', 'elementor-concierge-addons' ),
						'content_text' => esc_html__( 'Arrive in Scotland and settle into your hotel. Evening welcome and briefing with your host.', 'elementor-concierge-addons' ),
					],
					[
						'day_text'     => esc_html__( 'Day 2', 'elementor-concierge-addons' ),
						'title_text'   => esc_html__( 'Championship Course Experience', 'elementor-concierge-addons' ),
						'content_text' => esc_html__( 'Morning transfer to the course followed by 18 holes and afternoon at leisure.', 'elementor-concierge-addons' ),
					],
				],
			]
		);

		$this->add_control(
			'single_open',
			[
				'label'        => esc_html__( 'Single Open Mode', 'elementor-concierge-addons' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'elementor-concierge-addons' ),
				'label_off'    => esc_html__( 'No', 'elementor-concierge-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'open_first',
			[
				'label'        => esc_html__( 'Open First Item', 'elementor-concierge-addons' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'elementor-concierge-addons' ),
				'label_off'    => esc_html__( 'No', 'elementor-concierge-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'animation_speed',
			[
				'label'   => esc_html__( 'Animation Speed (ms)', 'elementor-concierge-addons' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 260,
				'min'     => 0,
				'max'     => 2000,
			]
		);

		$this->add_control(
			'icon_closed',
			[
				'label'   => esc_html__( 'Closed Icon', 'elementor-concierge-addons' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-chevron-down',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'icon_open',
			[
				'label'   => esc_html__( 'Open Icon', 'elementor-concierge-addons' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-chevron-up',
					'library' => 'fa-solid',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_wrapper',
			[
				'label' => esc_html__( 'Wrapper', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'wrapper_background',
				'selector' => '{{WRAPPER}} .cga-tour-toggles',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'wrapper_border',
				'selector' => '{{WRAPPER}} .cga-tour-toggles',
			]
		);

		$this->add_responsive_control(
			'wrapper_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .cga-tour-toggles' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wrapper_padding',
			[
				'label'      => esc_html__( 'Padding', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .cga-tour-toggles' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'items_gap',
			[
				'label'      => esc_html__( 'Items Gap', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 80,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 14,
				],
				'selectors'  => [
					'{{WRAPPER}} .cga-tour-toggles' => 'display: grid; gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_item',
			[
				'label' => esc_html__( 'Item Box', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'item_box_tabs' );

		$this->start_controls_tab(
			'item_box_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor-concierge-addons' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'item_background',
				'selector' => '{{WRAPPER}} .cga-toggle-item',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'item_box_active',
			[
				'label' => esc_html__( 'Active', 'elementor-concierge-addons' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'item_background_active',
				'selector' => '{{WRAPPER}} .cga-toggle-item.is-open',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'item_border',
				'selector' => '{{WRAPPER}} .cga-toggle-item',
			]
		);

		$this->add_responsive_control(
			'item_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .cga-toggle-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Item Inner Padding', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => 0,
					'right'  => 0,
					'bottom' => 0,
					'left'   => 0,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .cga-toggle-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_header',
			[
				'label' => esc_html__( 'Header Row', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label'      => esc_html__( 'Padding', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => 18,
					'right'  => 20,
					'bottom' => 18,
					'left'   => 20,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .cga-toggle-trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_gap',
			[
				'label'      => esc_html__( 'Header Content Gap', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 14,
				],
				'selectors'  => [
					'{{WRAPPER}} .cga-toggle-header-left' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'header_bg_tabs' );

		$this->start_controls_tab(
			'header_bg_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor-concierge-addons' ),
			]
		);

		$this->add_control(
			'header_bg_color',
			[
				'label'     => esc_html__( 'Background', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f8f8f8',
				'selectors' => [
					'{{WRAPPER}} .cga-toggle-trigger' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'header_bg_active',
			[
				'label' => esc_html__( 'Active', 'elementor-concierge-addons' ),
			]
		);

		$this->add_control(
			'header_bg_color_active',
			[
				'label'     => esc_html__( 'Background', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .cga-toggle-item.is-open .cga-toggle-trigger' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_day',
			[
				'label' => esc_html__( 'Day Label', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'day_typography',
				'selector' => '{{WRAPPER}} .cga-toggle-day-label',
			]
		);

		$this->add_control(
			'day_color',
			[
				'label'     => esc_html__( 'Text Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1d3461',
				'selectors' => [
					'{{WRAPPER}} .cga-toggle-day-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'day_number_color',
			[
				'label'     => esc_html__( 'Day Number Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .cga-toggle-day-num' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'day_bg_color',
			[
				'label'     => esc_html__( 'Background', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#e8f1f9',
				'selectors' => [
					'{{WRAPPER}} .cga-toggle-day' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'day_padding',
			[
				'label'      => esc_html__( 'Padding', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => 5,
					'right'  => 10,
					'bottom' => 5,
					'left'   => 10,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .cga-toggle-day' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'day_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .cga-toggle-day' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

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
				'selector' => '{{WRAPPER}} .cga-toggle-title',
			]
		);

		$this->start_controls_tabs( 'title_color_tabs' );

		$this->start_controls_tab(
			'title_color_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor-concierge-addons' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1c2333',
				'selectors' => [
					'{{WRAPPER}} .cga-toggle-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_color_active',
			[
				'label' => esc_html__( 'Active', 'elementor-concierge-addons' ),
			]
		);

		$this->add_control(
			'title_color_active_value',
			[
				'label'     => esc_html__( 'Text Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1d3461',
				'selectors' => [
					'{{WRAPPER}} .cga-toggle-item.is-open .cga-toggle-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__( 'Icons', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 8,
						'max' => 60,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors'  => [
					'{{WRAPPER}} .cga-toggle-icon-wrap i, {{WRAPPER}} .cga-toggle-icon-wrap svg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_area_size',
			[
				'label'      => esc_html__( 'Icon Area Size', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 24,
						'max' => 120,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 34,
				],
				'selectors'  => [
					'{{WRAPPER}} .cga-toggle-icon-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_radius',
			[
				'label'      => esc_html__( 'Icon Area Radius', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .cga-toggle-icon-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'icon_color_tabs' );

		$this->start_controls_tab(
			'icon_color_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor-concierge-addons' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1d3461',
				'selectors' => [
					'{{WRAPPER}} .cga-toggle-icon-wrap' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg',
			[
				'label'     => esc_html__( 'Icon Area Background', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#e8f1f9',
				'selectors' => [
					'{{WRAPPER}} .cga-toggle-icon-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_color_active',
			[
				'label' => esc_html__( 'Active', 'elementor-concierge-addons' ),
			]
		);

		$this->add_control(
			'icon_color_open',
			[
				'label'     => esc_html__( 'Icon Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .cga-toggle-item.is-open .cga-toggle-icon-wrap' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg_open',
			[
				'label'     => esc_html__( 'Icon Area Background', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1d3461',
				'selectors' => [
					'{{WRAPPER}} .cga-toggle-item.is-open .cga-toggle-icon-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content Panel', 'elementor-concierge-addons' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .cga-toggle-content-inner',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Text Color', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#4a5565',
				'selectors' => [
					'{{WRAPPER}} .cga-toggle-content-inner' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_bg',
			[
				'label'     => esc_html__( 'Background', 'elementor-concierge-addons' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .cga-toggle-content-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => 18,
					'right'  => 20,
					'bottom' => 20,
					'left'   => 20,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .cga-toggle-content-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_top_gap',
			[
				'label'      => esc_html__( 'Top Gap', 'elementor-concierge-addons' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors'  => [
					'{{WRAPPER}} .cga-toggle-content' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output
	 */
	protected function render() {
		$settings       = $this->get_settings_for_display();
		$items          = ! empty( $settings['toggle_items'] ) ? $settings['toggle_items'] : [];
		$single_open    = ( isset( $settings['single_open'] ) && 'yes' === $settings['single_open'] ) ? 'yes' : 'no';
		$open_first     = ( isset( $settings['open_first'] ) && 'yes' === $settings['open_first'] ) ? 'yes' : 'no';
		$animation_speed = isset( $settings['animation_speed'] ) ? absint( $settings['animation_speed'] ) : 260;

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="cga-tour-toggles" data-single-open="<?php echo esc_attr( $single_open ); ?>" data-open-first="<?php echo esc_attr( $open_first ); ?>" data-speed="<?php echo esc_attr( $animation_speed ); ?>">
			<?php foreach ( $items as $index => $item ) : ?>
				<?php $is_open = ( 0 === $index && 'yes' === $open_first ); ?>
				<?php
				$day_text = isset( $item['day_text'] ) ? trim( wp_strip_all_tags( $item['day_text'] ) ) : '';
				$day_num  = '';
				$day_lbl  = $day_text;

				if ( preg_match( '/(\d+)/', $day_text, $matches ) ) {
					$day_num = $matches[1];
					$day_lbl = trim( preg_replace( '/\d+/', '', $day_text ) );
				}

				if ( '' === $day_lbl ) {
					$day_lbl = esc_html__( 'Day', 'elementor-concierge-addons' );
				}
				?>
				<div class="cga-toggle-item<?php echo $is_open ? ' is-open' : ''; ?>">
					<button class="cga-toggle-trigger" type="button" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>">
						<span class="cga-toggle-header-left">
							<?php if ( ! empty( $item['day_text'] ) ) : ?>
								<span class="cga-toggle-day">
									<?php if ( '' !== $day_num ) : ?>
										<span class="cga-toggle-day-num"><?php echo esc_html( $day_num ); ?></span>
									<?php endif; ?>
									<span class="cga-toggle-day-label"><?php echo esc_html( strtoupper( $day_lbl ) ); ?></span>
								</span>
							<?php endif; ?>
							<span class="cga-toggle-title"><?php echo esc_html( $item['title_text'] ); ?></span>
						</span>
						<span class="cga-toggle-icon-wrap" aria-hidden="true">
							<span class="cga-icon-closed">
								<?php \Elementor\Icons_Manager::render_icon( $settings['icon_closed'], [ 'aria-hidden' => 'true' ] ); ?>
							</span>
							<span class="cga-icon-open">
								<?php \Elementor\Icons_Manager::render_icon( $settings['icon_open'], [ 'aria-hidden' => 'true' ] ); ?>
							</span>
						</span>
					</button>
					<div class="cga-toggle-content"<?php echo $is_open ? '' : ' style="display:none;"'; ?>>
						<div class="cga-toggle-content-inner">
							<?php echo wp_kses_post( $item['content_text'] ); ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}

	/**
	 * Render plain content
	 */
	protected function content_template() {
		?>
		<# if ( settings.toggle_items && settings.toggle_items.length ) { #>
		<div class="cga-tour-toggles" data-single-open="{{{ settings.single_open ? 'yes' : 'no' }}}" data-open-first="{{{ settings.open_first ? 'yes' : 'no' }}}" data-speed="{{{ settings.animation_speed }}}">
			<# _.each( settings.toggle_items, function( item, index ) { var opened = index === 0 && settings.open_first; #>
			<div class="cga-toggle-item {{{ opened ? 'is-open' : '' }}}">
				<button class="cga-toggle-trigger" type="button" aria-expanded="{{{ opened ? 'true' : 'false' }}}">
					<span class="cga-toggle-header-left">
						<# if ( item.day_text ) { #>
							<span class="cga-toggle-day">
								<span class="cga-toggle-day-num">{{{ (item.day_text.match(/\d+/) || [''])[0] }}}</span>
								<span class="cga-toggle-day-label">{{{ item.day_text.replace(/\d+/g, '').trim() || 'DAY' }}}</span>
							</span>
						<# } #>
						<span class="cga-toggle-title">{{{ item.title_text }}}</span>
					</span>
					<span class="cga-toggle-icon-wrap" aria-hidden="true">
						<span class="cga-icon-closed"><i class="fas fa-chevron-down"></i></span>
						<span class="cga-icon-open"><i class="fas fa-chevron-up"></i></span>
					</span>
				</button>
				<div class="cga-toggle-content" {{{ opened ? '' : 'style="display:none;"' }}}>
					<div class="cga-toggle-content-inner">{{{ item.content_text }}}</div>
				</div>
			</div>
			<# }); #>
		</div>
		<# } #>
		<?php
	}
}
