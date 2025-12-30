# Color Themes Guide

This guide helps you easily change the color theme of your portfolio site.

## Current Theme: Deep Teal

**Primary Color**: #0891b2 (Deep Teal)
**Personality**: Professional, Modern, Tech-Forward, Trustworthy
**Best For**: Tech companies, SaaS platforms, modern startups

## How to Change Colors

Edit `public/css/styles.css` starting at line 10:

```css
:root {
    /* Color Palette - Deep Teal Theme */
    --primary: #0891b2;        /* Main brand color */
    --primary-dark: #0e7490;   /* Darker shade */
    --primary-light: #06b6d4;  /* Lighter shade */
    --secondary: #14b8a6;      /* Secondary color */
    --accent: #f59e0b;         /* Accent color */
}
```

Simply replace these values with any theme below!

---

## Professional Color Themes

### 1. Deep Teal (Current)
```css
--primary: #0891b2;
--primary-dark: #0e7490;
--primary-light: #06b6d4;
--gradient-primary: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
```
**Use Case**: Modern tech, SaaS, development agencies
**Personality**: Professional, innovative, trustworthy

---

### 2. Rich Purple
```css
--primary: #7c3aed;
--primary-dark: #6d28d9;
--primary-light: #8b5cf6;
--gradient-primary: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
```
**Use Case**: Creative agencies, design studios, premium brands
**Personality**: Creative, innovative, luxury, bold

---

### 3. Forest Green
```css
--primary: #059669;
--primary-dark: #047857;
--primary-light: #10b981;
--gradient-primary: linear-gradient(135deg, #059669 0%, #10b981 100%);
```
**Use Case**: Sustainability, finance, health, organic products
**Personality**: Growth, stability, trustworthy, eco-friendly

---

### 4. Deep Blue (Classic)
```css
--primary: #2563eb;
--primary-dark: #1e40af;
--primary-light: #3b82f6;
--gradient-primary: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
```
**Use Case**: Corporate, finance, consulting, traditional business
**Personality**: Trust, professional, reliable, established

---

### 5. Slate Gray (Minimalist)
```css
--primary: #475569;
--primary-dark: #334155;
--primary-light: #64748b;
--gradient-primary: linear-gradient(135deg, #475569 0%, #64748b 100%);
```
**Use Case**: Architecture, law, high-end products, minimalist design
**Personality**: Sophisticated, timeless, elegant, professional

---

### 6. Deep Indigo
```css
--primary: #4338ca;
--primary-dark: #3730a3;
--primary-light: #6366f1;
--gradient-primary: linear-gradient(135deg, #4338ca 0%, #6366f1 100%);
```
**Use Case**: Enterprise software, consulting, corporate services
**Personality**: Wisdom, professional, trustworthy, corporate

---

### 7. Vibrant Orange
```css
--primary: #ea580c;
--primary-dark: #c2410c;
--primary-light: #f97316;
--gradient-primary: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
```
**Use Case**: Energy, food, sports, entertainment, dynamic brands
**Personality**: Energetic, bold, friendly, enthusiastic

---

### 8. Royal Red
```css
--primary: #dc2626;
--primary-dark: #b91c1c;
--primary-light: #ef4444;
--gradient-primary: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
```
**Use Case**: Bold brands, sports, entertainment, urgent services
**Personality**: Powerful, passionate, bold, attention-grabbing

---

## Quick Color Selection Guide

### Choose Based on Industry:

| Industry | Recommended Color | Theme Number |
|----------|------------------|--------------|
| Tech/SaaS | Deep Teal or Deep Blue | #1 or #4 |
| Creative/Design | Rich Purple | #2 |
| Finance/Legal | Deep Blue or Slate Gray | #4 or #5 |
| Health/Wellness | Forest Green or Deep Teal | #3 or #1 |
| Consulting | Deep Indigo or Deep Blue | #6 or #4 |
| E-commerce | Vibrant Orange or Rich Purple | #7 or #2 |
| Food/Restaurant | Vibrant Orange or Royal Red | #7 or #8 |
| Corporate | Deep Blue or Deep Indigo | #4 or #6 |
| Architecture | Slate Gray or Forest Green | #5 or #3 |

### Choose Based on Personality:

- **Trustworthy & Reliable**: Deep Blue (#4)
- **Modern & Innovative**: Deep Teal (#1), Rich Purple (#2)
- **Professional & Corporate**: Deep Indigo (#6), Slate Gray (#5)
- **Creative & Bold**: Rich Purple (#2), Vibrant Orange (#7)
- **Stable & Secure**: Forest Green (#3), Deep Blue (#4)
- **Sophisticated & Elegant**: Slate Gray (#5)
- **Energetic & Dynamic**: Vibrant Orange (#7), Royal Red (#8)

---

## Step-by-Step Color Change

1. **Open the CSS file**:
   ```bash
   code public/css/styles.css
   ```

2. **Find the color variables** (around line 10-17)

3. **Copy your chosen theme** from above

4. **Replace the values** in the `:root` section

5. **Save the file**

6. **Refresh your browser** - changes are instant!

## Testing Your New Colors

After changing colors:

1. Check all sections (Hero, Services, Portfolio, Contact)
2. Test hover states on buttons and cards
3. Verify text readability on colored backgrounds
4. Check mobile responsiveness
5. Test in both light and dark browser modes

## Need a Custom Color?

Use this template and adjust to your brand:

```css
:root {
    --primary: #YOUR_COLOR;              /* Your main brand color */
    --primary-dark: #DARKER_VERSION;      /* 15-20% darker */
    --primary-light: #LIGHTER_VERSION;    /* 15-20% lighter */
    --gradient-primary: linear-gradient(135deg, #YOUR_COLOR 0%, #LIGHTER_VERSION 100%);
}
```

**Tools for finding color variations:**
- [Coolors.co](https://coolors.co) - Color palette generator
- [Color Hunt](https://colorhunt.co) - Color palette inspiration
- [Adobe Color](https://color.adobe.com) - Color wheel and harmonies

---

## Advanced: Multiple Color Variables

For more control, edit all color variables:

```css
:root {
    /* Primary Colors */
    --primary: #0891b2;
    --primary-dark: #0e7490;
    --primary-light: #06b6d4;

    /* Secondary Colors */
    --secondary: #14b8a6;

    /* Accent Colors */
    --accent: #f59e0b;

    /* Gradients */
    --gradient-primary: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    --gradient-secondary: linear-gradient(135deg, #14b8a6 0%, #2dd4bf 100%);
    --gradient-accent: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
}
```

---

**Pro Tip**: Keep a backup of your original colors before experimenting! Comment them out rather than deleting:

```css
/* Original Blue Theme - Backup
--primary: #2563eb;
--primary-dark: #1e40af;
--primary-light: #3b82f6;
*/

/* Current Deep Teal Theme */
--primary: #0891b2;
--primary-dark: #0e7490;
--primary-light: #06b6d4;
```
