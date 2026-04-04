# Elementor Concierge Addons – Quick Reference & Examples

## 🎯 Quick Setup (Tour Page Example)

### Step 1: Page Structure in Elementor

Create a 2-column layout:
- **Column 1 (25% width)**: Sidebar (sticky)
  - Add: Sidebar Nav Title widget
  - Add: Sidebar Nav widget
- **Column 2 (75% width)**: Main content

### Step 2: Configure Sidebar Nav Title
```
Label: "On this page"
Background: #1d3461 (Navy)
Text Color: rgba(255,255,255,0.7)
Font Size: 9px
Font Weight: Bold
Text Transform: Uppercase
Letter Spacing: 0.25em
Padding: 14px 20px
```

### Step 3: Configure Sidebar Nav

**Content Tab:**
Add these navigation items:

| Label | Link |
|-------|------|
| Trip Highlights | #highlights |
| Itinerary | #itinerary |
| Golf Courses | #courses |
| Lodging | #lodging |
| Transportation | #transportation |
| Inclusions | #inclusions |
| Pricing | #pricing |
| FAQs | #faqs |
| Related Tours | #related |

- Enable: "Enable Scroll Spy" ✓
- Scroll Offset: 150 (adjust based on header height)

**Container Tab:**
```
Background: #f7f5f0 (Cream)
Border Color: #dde3ec
Border Width: 1px
Border Radius: 3px
Margin Bottom: 24px
```

**Items Tab:**
```
Text Color: #6b7a8d (Muted)
Font Size: 11px
Font Weight: 500
Padding: 12px 20px
Border Color: #dde3ec (item separators)
```

**Hover & Active Tab:**
```
Text Color: #1d3461 (Navy)
Background: #ffffff (White)
Indicator Color: #c4973a (Gold)
Active Indicator Color: #c4973a (Gold)
Indicator Size: 5px
Hover Padding Left: 26px
```

### Step 4: Add Content Sections

Make sure your main content has matching section IDs:

```html
<!-- TRIP HIGHLIGHTS -->
<section id="highlights">
  <h2>Trip Highlights</h2>
  <!-- Content here -->
</section>

<!-- ITINERARY -->
<section id="itinerary">
  <h2>Itinerary</h2>
  <!-- Content here -->
</section>

<!-- GOLF COURSES -->
<section id="courses">
  <h2>Golf Courses</h2>
  <!-- Content here -->
</section>

<!-- LODGING -->
<section id="lodging">
  <h2>Lodging</h2>
  <!-- Content here -->
</section>

<!-- And so on... -->
```

## 🎨 Color Scheme Variations

### Premium Navy & Gold Theme (Default)
```css
--primary: #1d3461       (Navy Dark)
--accent: #c4973a        (Gold)
--bg-light: #f7f5f0      (Cream)
--text: #1c2333          (Dark Text)
--muted: #6b7a8d         (Muted Gray)
--border: #dde3ec        (Light Border)
```

### Minimal Modern Theme
```css
Background: #ffffff (White)
Text: #2c2c2c (Dark Gray)
Accent: #0066cc (Blue)
Border: #e0e0e0 (Light Gray)
Highlight: #f5f5f5 (Off-white)
```

### Light & Luxe Theme
```css
Background: #faf8f3 (Very Light Cream)
Title BG: #2a3f6f (Dark Blue)
Text: #3a3a3a (Almost Black)
Accent: #d4af37 (Bright Gold)
Border: #e8e6e1 (Soft Beige)
```

## 📱 Responsive Design Tips

### Mobile Adjustments (Built-in)
The plugin automatically adjusts on mobile:
- Font size reduces slightly
- Padding reduces
- Indicator size remains proportional

**Custom mobile override (if needed in Elementor):**
Go to **Responsive** tab and reduce:
- Font Size: 10px
- Padding: 10px 16px
- Indicator Size: 4px

### Tablet Adjustments
Use Elementor's responsive settings:
- Column widths: Sidebar 30%, Content 70%
- Font sizes: 10px (items)
- Spacing: 16px padding

## 🔗 Adding More Items Later

To add more navigation items later:

1. **Edit the page** in Elementor
2. **Click** on the Sidebar Nav widget
3. **Content tab** → Scroll down to "Navigation Items"
4. **Click** the "+" icon to add new items
5. Enter Label and Link (section ID)
6. **Update** the page

## 🎯 JavaScript Events & Custom Actions

### Manual Active State (if needed)
```javascript
// Set active manually
$('.sidebar-nav a[data-section="highlights"]').addClass('is-active');

// Remove active from all
$('.sidebar-nav a').removeClass('is-active');
```

### Track When User Reaches Section
```javascript
// Already built-in! Just monitor for .is-active changes
$(document).on('click', '.sidebar-nav a.is-active', function() {
    console.log('Active section:', $(this).data('section'));
});
```

## 🚀 Performance Optimization

### Reduce Scroll Spy Load (if many items)
- Limit to 8-10 navigation items max
- Use moderate scroll offset (150-200px)
- Debounce is built-in (250ms on resize)

### CSS Optimization
- Styles are inline where possible
- CSS transitions use hardware acceleration (transform)
- Minimal DOM manipulation on scroll

## 🎨 Advanced CSS Customizations

### Custom Indicator Shape (replace dot)
Add to your theme's custom CSS:
```css
.sidebar-nav a::before {
    content: '▸';  /* Triangle symbol */
    width: auto;
    height: auto;
    font-size: 10px;
}
```

### Animated Active State
```css
.sidebar-nav a.is-active {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        padding-left: 20px;
        opacity: 0;
    }
    to {
        padding-left: 26px;
        opacity: 1;
    }
}
```

### Custom Scrollbar Behavior
```css
.sidebar-nav {
    max-height: 500px;  /* Add if very long */
    overflow-y: auto;
}

.sidebar-nav::-webkit-scrollbar {
    width: 6px;
}

.sidebar-nav::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.05);
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: #c4973a;
    border-radius: 3px;
}
```

## 🐛 Common Issues & Solutions

### Issue: Scroll Spy not detecting sections
**Solution:** 
- Verify section IDs are exact matches (case-sensitive)
- Check that sections actually exist on page
- Increase scroll offset if header is tall

### Issue: Navigation not sticky
**Elementor Solution:**
1. Select the sidebar column
2. Advanced → Position: **Sticky**
3. Adjust "Top" offset for sticky positioning

### Issue: Smooth scroll not working
**Solution:**
- Browser doesn't support smooth scroll
- Add fallback in theme (Elementor → Settings → Advanced → Smooth Scroll)

### Issue: Colors not changing
**Solution:**
- Clear Elementor cache (Elementor → Tools → Regenerate CSS)
- Check for conflicting custom CSS
- Use !important in custom CSS if needed

## 📊 Layout Recommendations

### Ideal Layout Proportions
```
Page Width: 1340px (max)
Sidebar Width: ~300px (22%)
Content Width: ~1000px (75%)
Gutter: ~40px
```

### Spacing Guidelines
```
Vertical rhythm: 24px base unit
- Section padding: 40-60px top/bottom
- Item padding: 12px vertical
- Container margin: 24px
- Title padding: 14px
```

### Typography Stack
```
Headers: Cormorant Garamond (elegant serif)
Body: Montserrat (modern sans-serif)
Navigation: 11px Montserrat (slightly larger for readability)
Title: 9px uppercase, bold
```

## ✨ Enhancement Ideas

1. **Add Icons to Items**
   - Golf pin icon for courses
   - Calendar icon for itinerary
   - Bed icon for lodging

2. **Nested Navigation**
   - Sub-items under main items
   - Multi-level hierarchy

3. **Progress Indicator**
   - Show how far through page user is
   - Visual progress bar

4. **Smooth Highlighting**
   - Fade-in animation on active
   - Slide-in from left effect

5. **Dark Mode Support**
   - Toggle between light/dark themes
   - Use CSS custom properties

---

**Quick Reference Version:** 1.0  
**Last Updated:** 2026
