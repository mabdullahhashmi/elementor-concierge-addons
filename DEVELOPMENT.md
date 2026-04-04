# Elementor Concierge Addons – Developer Guide

## 📦 Plugin Architecture

```
elementor-concierge-addons/
├── elementor-concierge-addons.php         ← Main plugin entry point
├── README.md                              ← User documentation
├── QUICK-REFERENCE.md                     ← Quick setup guide
├── DEVELOPMENT.md                         ← This file
│
├── includes/
│   ├── class-elementor-addons.php         ← Plugin main class
│   │   ├── register_category()            ← Register "Concierge Golf" category
│   │   ├── register_widgets()             ← Load all widgets
│   │   ├── enqueue_assets()               ← Load CSS/JS
│   │   └── editor_scripts()               ← Elementor editor hooks
│   │
│   └── widgets/
│       ├── sidebar-nav-title.php          ← Title widget class
│       ├── sidebar-nav.php                ← Navigation widget class
│       └── [future widgets]
│
├── assets/
│   ├── css/
│   │   ├── elementor-addons.css           ← All frontend styles
│   │   └── [widget-specific].css
│   │
│   └── js/
│       ├── elementor-addons.js            ← Scroll spy & interactions
│       └── [widget-specific].js
│
└── languages/
    └── elementor-concierge-addons.pot     ← i18n/translation file
```

## 🔧 Core Components

### Main Plugin Class (`class-elementor-addons.php`)
```php
class Elementor_Concierge_Addons {
    - instance()                    // Singleton pattern
    - __construct()                 // Setup hooks
    - register_category()           // Creates "Concierge Golf" category
    - register_widgets()            // Instantiate & register all widgets
    - enqueue_assets()              // Load CSS & JS
    - editor_scripts()              // Optional: Editor-specific code
}
```

**Hook Points Used:**
- `plugins_loaded` - Initialize plugin
- `elementor/elements/categories_registered` - Register category
- `elementor/widgets/register` - Register widgets
- `wp_enqueue_scripts` - Enqueue frontend assets
- `elementor/editor/footer` - Editor scripts

### Widget Base Class

All widgets extend `\Elementor\Widget_Base`:

```php
class Elementor_Custom_Widget extends \Elementor\Widget_Base {
    public function get_name()          // Unique ID (snake-case)
    public function get_title()         // Display name
    public function get_icon()          // Icon class
    public function get_categories()    // Category array
    protected function register_controls() // Control definitions
    protected function render()         // Frontend output
    protected function content_template() // Elementor live preview
}
```

## 🎨 Widget Control Types

### Common Controls Used

```php
// Text input
$this->add_control('field_id', [
    'label' => esc_html__('Label', 'textdomain'),
    'type' => \Elementor\Controls_Manager::TEXT,
    'default' => 'Default value',
]);

// Color picker
$this->add_control('color_field', [
    'label' => esc_html__('Color', 'textdomain'),
    'type' => \Elementor\Controls_Manager::COLOR,
    'default' => '#1d3461',
    'selectors' => [
        '{{WRAPPER}} .my-class' => 'color: {{VALUE}};',
    ],
]);

// Repeater (list of items)
$repeater = new \Elementor\Repeater();
$repeater->add_control('item_name', ['type' => Controls_Manager::TEXT]);
$this->add_control('items', [
    'label' => esc_html__('Items', 'textdomain'),
    'type' => \Elementor\Controls_Manager::REPEATER,
    'fields' => $repeater->get_controls(),
    'title_field' => '{{{ item_name }}}',
]);

// Typography group
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    ['name' => 'typography', 'selector' => '{{WRAPPER}} .text']
);

// Dimensions (padding, margin)
$this->add_control('padding', [
    'label' => esc_html__('Padding', 'textdomain'),
    'type' => \Elementor\Controls_Manager::DIMENSIONS,
    'size_units' => ['px', 'em', '%'],
    'selectors' => [
        '{{WRAPPER}} .element' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    ],
]);

// Toggle/Switch
$this->add_control('enabled', [
    'label' => esc_html__('Enable', 'textdomain'),
    'type' => \Elementor\Controls_Manager::SWITCHER,
    'label_on' => esc_html__('Yes', 'textdomain'),
    'label_off' => esc_html__('No', 'textdomain'),
    'return_value' => 'yes',
    'default' => 'yes',
]);
```

## 🚀 Adding New Widgets

### Step 1: Create Widget File
Create `includes/widgets/my-widget.php`:

```php
<?php
class Elementor_My_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'my-widget';
    }

    public function get_title() {
        return esc_html__('My Widget', 'elementor-concierge-addons');
    }

    public function get_icon() {
        return 'eicon-my-icon';
    }

    public function get_categories() {
        return ['concierge-golf'];
    }

    protected function register_controls() {
        // CONTENT tab
        $this->start_controls_section('section_content', [
            'label' => esc_html__('Content', 'elementor-concierge-addons'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        // Add controls here...

        $this->end_controls_section();

        // STYLE tab
        $this->start_controls_section('section_style', [
            'label' => esc_html__('Style', 'elementor-concierge-addons'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        // Add style controls here...

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="my-widget">
            <!-- Output here -->
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <div class="my-widget">
            {{{ settings.field_name }}}
        </div>
        <?php
    }
}
```

### Step 2: Register in Main Class
Edit `includes/class-elementor-addons.php`:

```php
public function register_widgets( $widgets_manager ) {
    // Existing widgets...

    // New widget
    require_once ELEMENTOR_CONCIERGE_ADDONS_PATH . 'includes/widgets/my-widget.php';
    $widgets_manager->register( new \Elementor_My_Widget() );
}
```

### Step 3: Add Widget Styles (Optional)
Add to `assets/css/elementor-addons.css` or create `assets/css/my-widget.css`:

```css
.my-widget {
    padding: 20px;
}
```

If creating separate file, enqueue in `class-elementor-addons.php`:

```php
wp_register_style(
    'my-widget-css',
    ELEMENTOR_CONCIERGE_ADDONS_URL . 'assets/css/my-widget.css'
);
wp_enqueue_style('my-widget-css');
```

## 📝 Widget Best Practices

### 1. Use Proper Selectors
```php
'selectors' => [
    '{{WRAPPER}} .my-element' => 'color: {{VALUE}};',
]
```
- `{{WRAPPER}}` - Widget container
- `{{VALUE}}` - Control value placeholder

### 2. Use Responsive Controls
```php
$this->add_responsive_control('font_size', [
    'label' => esc_html__('Font Size', 'elementor-concierge-addons'),
    'type' => \Elementor\Controls_Manager::SLIDER,
    'selectors' => [
        '{{WRAPPER}} .text' => 'font-size: {{SIZE}}{{UNIT}};',
    ],
]);
```

### 3. Organize Controls in Sections
```php
// Content section
$this->start_controls_section('section_content', [...]);
$this->add_control('field1', [...]);
$this->add_control('field2', [...]);
$this->end_controls_section();

// Style section
$this->start_controls_section('section_style', [...]);
$this->add_control('style1', [...]);
$this->end_controls_section();
```

### 4. Use Conditions for Related Controls
```php
$this->add_control('show_button', [
    'label' => esc_html__('Show Button', 'elementor-concierge-addons'),
    'type' => \Elementor\Controls_Manager::SWITCHER,
]);

$this->add_control('button_text', [
    'label' => esc_html__('Button Text', 'elementor-concierge-addons'),
    'type' => \Elementor\Controls_Manager::TEXT,
    'condition' => ['show_button' => 'yes'],
]);
```

### 5. Proper Escaping in Output
```php
// In render()
echo esc_html($settings['text']);
echo esc_url($settings['link']);
echo wp_kses_post($settings['html']);

// In content_template (Elementor handles escaping)
{{{ settings.text }}}
```

## 🔗 Widget Communication

### Passing Data via Attributes
```html
<div class="sidebar-nav" data-scroll-spy="true" data-scroll-offset="150">
    <!-- Widgets can read these data attributes -->
</div>
```

### Reading in JavaScript
```javascript
var $nav = $('.sidebar-nav');
var scrollSpy = $nav.attr('data-scroll-spy'); // "true"
var offset = parseInt($nav.attr('data-scroll-offset')); // 150
```

## 🧩 Typical Widget Components

### Form Widget Example
```php
class Elementor_Contact_Form extends \Elementor\Widget_Base {
    // Fields: Name, Email, Message
    // Button styling
    // Validation
    // Form submission handling
}
```

### Gallery Widget Example
```php
class Elementor_Gallery extends \Elementor\Widget_Base {
    // Image repeater
    // Gallery layout (grid, carousel)
    // Lightbox settings
    // Item styling
}
```

### Testimonial Widget Example
```php
class Elementor_Testimonial extends \Elementor\Widget_Base {
    // Text content
    // Author name & position
    // Avatar image
    // Rating/stars
}
```

## 🎯 Common Selectors In Style Controls

```php
// Element selectors
'{{WRAPPER}} .my-element'               // Direct element
'{{WRAPPER}} .my-element:hover'         // Hover state
'{{WRAPPER}} .my-element::before'       // Pseudo-elements
'{{WRAPPER}} .my-element a'             // Child elements

// Responsive
'{{WRAPPER}} .my-element'               // All devices
'(mobile){{WRAPPER}} .my-element'       // Mobile only
'(tablet){{WRAPPER}} .my-element'       // Tablet only
'(desktop){{WRAPPER}} .my-element'      // Desktop only
```

## 📊 Using Group Controls

```php
// Typography
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    ['name' => 'text_typography', 'selector' => '{{WRAPPER}} .text']
);

// Box Shadow
$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    ['name' => 'box_shadow', 'selector' => '{{WRAPPER}}']
);

// Border
$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    ['name' => 'border', 'selector' => '{{WRAPPER}}']
);

// Background
$this->add_group_control(
    \Elementor\Group_Control_Background::get_type(),
    ['name' => 'background', 'selector' => '{{WRAPPER}}']
);
```

## 🔌 Enqueuing Scripts & Styles

In main class:
```php
public function enqueue_assets() {
    // Register (don't enqueue yet)
    wp_register_style('my-style', ELEMENTOR_CONCIERGE_ADDONS_URL . 'css/style.css');
    wp_register_script('my-script', ELEMENTOR_CONCIERGE_ADDONS_URL . 'js/script.js');

    // Enqueue (load immediately)
    wp_enqueue_style('my-style');
    wp_enqueue_script('my-script');

    // With dependencies
    wp_register_script(
        'my-script',
        ELEMENTOR_CONCIERGE_ADDONS_URL . 'js/script.js',
        ['jquery', 'other-lib'], // Dependencies
        '1.0.0',                 // Version
        true                     // Load in footer
    );
}
```

## 🧪 Testing Widgets

### In Elementor Editor:
1. Create new page
2. Open Elementor editor
3. Search for your widget in left panel
4. Drag to canvas
5. Test controls and preview
6. Check rendered output

### Console Testing:
```javascript
// Check if widget loaded
console.log($('.sidebar-nav').length);
console.log(elementorFrontend.isEditMode());

// Manual initialization
initScrollSpy(); // Trigger scroll spy manually
```

## 📚 Elementor Resources

- [Elementor Docs](https://developers.elementor.com/)
- [Widget Development](https://developers.elementor.com/docs/widgets/)
- [Control Types](https://developers.elementor.com/docs/controls/)
- [API Reference](https://developers.elementor.com/docs/apis/)

## 🔐 Security Best Practices

### Input Sanitization
```php
$value = sanitize_text_field($_POST['field']);
$url = esc_url($_POST['url']);
$html = wp_kses_post($_POST['html']);
```

### Output Escaping
```php
echo esc_html($text);
echo esc_url($url);
echo wp_kses_post($html);
```

### Nonce Verification
```php
check_admin_referer('nonce_action', 'nonce_field');
wp_verify_nonce($_REQUEST['_wpnonce'], 'nonce_action');
```

## 🚀 Deployment Checklist

- [ ] All controls properly labeled and described
- [ ] Valid selectors for all styling controls
- [ ] Responsive controls where appropriate
- [ ] Proper escaping/sanitization
- [ ] Widget tested in Elementor editor
- [ ] Widget tested on frontend
- [ ] Mobile responsive verified
- [ ] Performance optimized (no unnecessary reflows)
- [ ] Documentation updated
- [ ] Code commented

---

**Developer Docs Version:** 1.0  
**Last Updated:** 2026  
**Elementor Version Support:** 3.0+
