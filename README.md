# Elementor Concierge Addons – Setup & Usage Guide

## 📋 Overview

This is a custom Elementor addon plugin that provides premium, professional UI elements for Concierge Golf Scotland tour pages. Currently includes two main widgets:

- **Sidebar Nav** - A sticky sidebar navigation that highlights active sections as user scrolls
- **Sidebar Nav Title** - A title bar for the sidebar navigation

## 🚀 Installation

### Step 1: Upload the Plugin
1. Go to your WordPress root directory
2. Navigate to `wp-content/plugins/`
3. Copy the entire `elementor-concierge-addons` folder here
4. The path should look like: `wp-content/plugins/elementor-concierge-addons/`

### Step 2: Activate the Plugin
1. Go to **WordPress Admin Dashboard**
2. Navigate to **Plugins**
3. Find "Elementor Concierge Addons"
4. Click **Activate**

### Step 3: Verify Installation
1. In WordPress, go to **Elementor Editor** (edit any page)
2. In the left widget panel, look for the **"Concierge Golf"** category
3. You should see two new widgets:
   - **Sidebar Nav Title**
   - **Sidebar Nav**

## 🎨 How to Use the Widgets

### Sidebar Nav Title Widget

This widget displays a title/header for your sidebar navigation.

**To add it:**
1. Drag **"Sidebar Nav Title"** widget to your page
2. In the **Content tab**, enter your title (e.g., "On this page")
3. Customize styling in the **Style tab**:
   - Background Color
   - Text Color
   - Typography (font, size, weight)
   - Padding & Border Radius

**Example styling:**
- Background: Navy (#1d3461)
- Text: White with 70% opacity
- Font: 9px, uppercase, bold

### Sidebar Nav Widget

This widget provides interactive section navigation with scroll-spy functionality.

**To add it:**
1. Drag **"Sidebar Nav"** widget to your page
2. In the **Content tab**, add navigation items:
   - Click **"Add Item"**
   - **Label**: The text shown in the menu (e.g., "Trip Highlights")
   - **Link**: The section ID with hash prefix (e.g., "#highlights")
   - Add as many items as needed

3. Enable **Scroll Spy** (recommended):
   - Toggle **"Enable Scroll Spy"** to ON
   - Set **Scroll Offset** (typically 150px for sticky headers)

4. Customize styling in multiple style tabs:
   - **Container**: Background, border, padding of the nav
   - **Navigation Items**: Text color, font size, padding
   - **Hover & Active**: Colors and indicator behavior

**Important:** Make sure your page has corresponding sections with matching IDs:
```html
<section id="highlights">
  <!-- Trip Highlights content -->
</section>

<section id="itinerary">
  <!-- Itinerary content -->
</section>
```

## 🔧 Customization Options

### Sidebar Nav Title
| Option | Description | Default |
|--------|-------------|---------|
| Title | Text to display | "On this page" |
| Background Color | Title background | #1d3461 (Navy) |
| Text Color | Title text color | rgba(255,255,255,0.7) |
| Typography | Font family, size, weight | 9px, uppercase, bold |
| Padding | Space inside title | 14px 20px |
| Border Radius | Rounded corners | 3px |

### Sidebar Nav
| Option | Description | Default |
|--------|-------------|---------|
| Navigation Items | Repeater field for menu items | 3 sample items |
| Enable Scroll Spy | Auto-highlight on scroll | Yes |
| Scroll Offset | Px offset for detection | 150px |

**Container Styling:**
| Option | Default |
|--------|---------|
| Background Color | #f7f5f0 (Cream) |
| Border Color | #dde3ec |
| Border Width | 1px |
| Border Radius | 3px |
| Margin Bottom | 24px |

**Item Styling:**
| Option | Default |
|--------|---------|
| Text Color | #6b7a8d (Muted) |
| Font Size | 11px |
| Font Weight | 500 |
| Padding | 12px 20px |
| Border Color | #dde3ec |

**Hover & Active Styling:**
| Option | Default |
|--------|---------|
| Text Color | #1d3461 (Navy) |
| Background | #ffffff (White) |
| Indicator Color | #c4973a (Gold) |
| Indicator Size | 5px |
| Hover Padding Left | 26px |

## 📱 Scroll Spy Features

The sidebar navigation automatically detects which section is in view and highlights the corresponding link.

**How it works:**
1. As user scrolls, the plugin detects which section is currently visible
2. The matching navigation link gets the `.is-active` class
3. Hover state also applies `.is-active` styling
4. Clicking a link smoothly scrolls to that section (600ms animation)

**Adjusting Scroll Spy:**
- **Scroll Offset**: Increase if you have a sticky header. This value is the distance from the top of the viewport where sections are considered "active"
- **Example**: With a 72px sticky header + some padding, use 150px offset

## 🎯 Best Practices

1. **Section IDs**: Always ensure your sections have unique IDs matching the navigation links
   ```html
   <section id="highlights">...</section>
   <!-- Link should be "#highlights" -->
   ```

2. **Sticky Positioning**: Place the sidebar nav in a sticky column/container
   - Use Elementor's column settings: Position → Sticky
   - Adjust "top" value based on your header height

3. **Color Scheme**: Use the design tokens from your tour page:
   - Navy: #1d3461
   - Gold: #c4973a
   - Cream: #f7f5f0
   - Border: #dde3ec

4. **Typography**: Keep typography consistent with your site
   - Headers: Cormorant Garamond
   - Body: Montserrat

5. **Mobile Responsive**: The navigation automatically adjusts font sizes and padding on mobile

## 🔄 Extending the Plugin

### Adding New Widgets

1. Create a new file: `includes/widgets/my-widget.php`
2. Create a new class extending `\Elementor\Widget_Base`:
   ```php
   class Elementor_My_Widget extends \Elementor\Widget_Base {
       public function get_name() { return 'my-widget'; }
       public function get_title() { return 'My Widget'; }
       // ... rest of implementation
   }
   ```
3. Register in `includes/class-elementor-addons.php`:
   ```php
   require_once ELEMENTOR_CONCIERGE_ADDONS_PATH . 'includes/widgets/my-widget.php';
   $widgets_manager->register( new \Elementor_My_Widget() );
   ```

### Adding New Styles

Add CSS to `assets/css/elementor-addons.css` or create new stylesheets and enqueue them in `class-elementor-addons.php`:

```php
wp_register_style(
    'my-widget-css',
    ELEMENTOR_CONCIERGE_ADDONS_URL . 'assets/css/my-widget.css'
);
wp_enqueue_style( 'my-widget-css' );
```

### Plugin Structure
```
elementor-concierge-addons/
├── elementor-concierge-addons.php         (Main plugin file)
├── includes/
│   ├── class-elementor-addons.php         (Main class & registration)
│   └── widgets/
│       ├── sidebar-nav-title.php          (Title widget)
│       ├── sidebar-nav.php                (Navigation widget)
│       └── [future-widgets].php
├── assets/
│   ├── css/
│   │   └── elementor-addons.css           (Frontend styles)
│   └── js/
│       └── elementor-addons.js            (Frontend scripts)
└── README.md                              (This file)
```

## 🐛 Troubleshooting

### Widgets not appearing in Elementor
- Ensure Elementor is installed and activated
- Check that the plugin is activated in WordPress
- Clear Elementor cache: Elementor → Tools → Regenerate CSS

### Scroll spy not working
- Check section IDs match the links (case-sensitive)
- Verify scroll offset is appropriate for your sticky header
- Open browser console for any JavaScript errors

### Styling not applying
- Ensure custom CSS isn't conflicting
- Check that color values are valid hex/rgb
- Clear browser cache

### Performance issues
- Reduce number of navigation items
- Optimize section heights
- Check for conflicting jQuery plugins

## 📦 Requirements

- WordPress 5.0+
- Elementor 3.0+
- PHP 7.4+

## 💡 Tips for Premium Quality

1. Use consistent spacing and alignment
2. Leverage hover states for interactivity feedback
3. Test on mobile and tablet devices
4. Use high-quality typography from design tokens
5. Limit color palette to 3-4 primary colors
6. Add micro-interactions (smooth transitions, fade effects)

## 📝 Future Enhancements

Potential widgets to add:
- Course Carousel
- Tour Highlights Block
- Itinerary Timeline
- Pricing Table
- Golf Courses Grid
- Contact Form Block
- FAQ Accordion

---

**Version:** 1.0.0  
**Build Date:** 2026  
**Author:** Concierge Golf Scotland
