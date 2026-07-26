---
name: Integrated Workshop System (Monochrome & Workshop Orange)
colors:
  surface: '#f8f9fb'
  surface-dim: '#d9dadc'
  surface-bright: '#f8f9fb'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f4f6'
  surface-container: '#edeef0'
  surface-container-high: '#e7e8ea'
  surface-container-highest: '#e1e2e4'
  on-surface: '#191c1e'
  on-surface-variant: '#43474e'
  inverse-surface: '#161615'
  inverse-on-surface: '#ededec'
  outline: '#74777f'
  outline-variant: '#c4c6cf'
  surface-tint: '#ff6b00'
  primary: '#000000'
  on-primary: '#ffffff'
  primary-container: '#1a1a1a'
  on-primary-container: '#cccccc'
  inverse-primary: '#e1e2e4'
  secondary: '#FF6B00'
  on-secondary: '#ffffff'
  secondary-container: '#ffa454'
  on-secondary-container: '#713b00'
  tertiary: '#161615'
  on-tertiary: '#ffffff'
  tertiary-container: '#2a2a27'
  on-tertiary-container: '#ededec'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#e1e2e4'
  primary-fixed-dim: '#cccccc'
  on-primary-fixed: '#000000'
  on-primary-fixed-variant: '#222222'
  secondary-fixed: '#ffdcc3'
  secondary-fixed-dim: '#ffb77d'
  on-secondary-fixed: '#2f1500'
  on-secondary-fixed-variant: '#6e3900'
  tertiary-fixed: '#e1e2e4'
  tertiary-fixed-dim: '#cccccc'
  on-tertiary-fixed: '#000000'
  on-tertiary-fixed-variant: '#161615'
  background: '#f8f9fb'
  on-background: '#191c1e'
  surface-variant: '#e1e2e4'
typography:
  headline-xl:
    fontFamily: Sora
    fontSize: 40px
    fontWeight: '700'
    lineHeight: 48px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Sora
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-lg-mobile:
    fontFamily: Sora
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  headline-md:
    fontFamily: Sora
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
    letterSpacing: 0.01em
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: 0.02em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 4px
  xs: 8px
  sm: 16px
  md: 24px
  lg: 32px
  xl: 48px
  gutter: 20px
  margin-mobile: 16px
  margin-desktop: 32px
---

## Brand & Style
The design system is engineered for an industrial-technical environment, balancing the utility of a SaaS dashboard with the rugged reliability of an automotive workshop. The brand personality is professional, precise, and authoritative. 

The visual style follows a **Corporate / Modern** aesthetic with a lean toward **Industrial Minimalism**. It prioritizes clarity and high-performance ergonomics. The interface should feel like a specialized tool—uncluttered, structured, and resilient. Surfaces are clean, using distinct borders and subtle elevations to define functional zones rather than relying on decorative flourishes.

## Colors
The palette is built on **Monochrome Industrial (Pure Black #000000 / Charcoal #161615 & Off-White #EDEDEC)** to establish ultra-modern visual clarity and **Workshop Orange (#FF6B00 / #FF8F42)** to drive action and high-priority interactions (Google Stitch Design System). STRICT RULE: No navy or bluish tints are permitted in the dark mode palette.

- **Primary (Monochrome Pure Black #000000 in Light Mode, Off-White #EDEDEC in Dark Mode):** Used for navigation sidebars, headers, primary buttons, and core branding elements.
- **Secondary (Workshop Orange #FF6B00 / #FF8F42):** Reserved strictly for high-priority actions, interactive hover states, Floating Action Buttons (FABs), and primary Call-to-Actions (CTAs).
- **Backgrounds & Surfaces:** Light mode uses clean, crisp light backgrounds (#F8F9FB) with white surfaces (#FFFFFF). Dark mode uses deep charcoal and warm black containers (#0A0A0A for backgrounds, #111111 and #161615 for surfaces and cards) to ensure high contrast and sleek glassmorphism without any blue/navy tint.
- **Status Colors:** High-saturation tones are used for status indicators (Amber, Blue, Green) to ensure they are glanceable across the garage floor. No pastels or muted tones are permitted; colors must remain "Industrial" and high-contrast.

## Typography
Typography is optimized for legibility in fast-paced environments. 

- **Headings:** Sora is used for its geometric, modern, and slightly technical feel. It commands attention and fits the "Integrated System" narrative.
- **Body & Data:** Inter is used for all functional text, data tables, and forms. Its high x-height ensures readability on tablets and handheld devices used by mechanics.
- **Hierarchy:** Use bold weights for data labels to ensure technicians can quickly distinguish between a label (e.g., "License Plate") and the value (e.g., "B 1234 ABC").

## Layout & Spacing
The layout uses a **Fluid Grid** system to maximize data density on desktop while remaining highly touch-accessible on mobile.

- **Desktop & Static Sidebar:** 12-column grid with a fixed, static sidebar (280px or 64rem container width). The sidebar must be static (non-hideable by default on desktop) to eliminate layout shift and ensure immediate access to workshop modules.
- **Mobile/Tablet:** 4-column or 8-column grid with 16px side margins. Dock navigation at the bottom must remain clean and organized.
- **Touch Targets:** All interactive elements (buttons, list items, inputs) must maintain a minimum height of **44px** to accommodate gloved or moving hands in a workshop setting.
- **Rhythm:** An 8px linear scale is used for all spatial relationships.

## Elevation & Depth
This design system uses a **Tonal Layering** approach combined with **Low-Contrast Outlines**.

- **Surfaces:** Depth is created by placing white cards on the light gray background. In Dark Mode, surfaces use charcoal (#161615) or deep warm black (#111111) container shades—strictly avoiding any navy or blue tint.
- **Borders:** Every card and input field must have a 1px solid border (#E2E8F0 in light mode, #3E3E3A in dark mode). This reinforces the "Industrial" and "Technical" feel.
- **Shadows:** Shadows are used sparingly to indicate "Interactable" or "Floating" states. Use a focused, medium-opacity shadow with 0px offset for active cards to make them appear slightly raised.

## Shapes
Shapes are defined as **Rounded**, striking a balance between modern software and mechanical components.

- **Standard Elements:** Buttons, inputs, and cards use an **8px (0.5rem)** to **12px (0.75rem)** corner radius.
- **Dropdowns & Modals:** Dropdown menus (`x-dropdown` and form `<select>` popups) must feature **16px (1rem, rounded-2xl)** rounded corners with modern borders (#3E3E3A in dark mode) and smooth opacity/scale transitions.
- **Status Pills:** Tags and status indicators use a fully rounded/pill shape (`rounded-full`) to distinguish them from functional buttons.

## Components & Interactive Rules

- **Buttons:** 
  - *Primary:* Solid Monochrome background (#000000 in Light Mode, #EDEDEC in Dark Mode or Workshop Orange #FF8F42) with contrasting text. 
  - *Secondary (Action):* Workshop Orange (#FF6B00) background. Used for "Create Job," "Finalize Invoice," and high-impact CTAs.
  - *Outlined:* 1px solid border (#74777F or #3E3E3A in Dark Mode) for secondary actions like "Print" or "Export."
- **Input Fields & Dropdowns:** 
  - Background: White (Light) / Surface Container (#111111 or #161615 in Dark Mode). Never allow hardcoded unstyled `bg-white` in dark mode.
  - Border: 1px Solid Outline Variant (#C4C6CF / #3E3E3A), turning Workshop Orange (#FF6B00) or Monochrome Black/White on focus. 
  - Labels must always be visible above the input, never just as placeholders.
- **Theme Animation (View Transition API):** 
  - Light and dark mode transitions must implement `document.startViewTransition` using click event coordinates (`getBoundingClientRect()`) to create a smooth circular clipping transition across all viewports and devices.
- **Data Tables:** 
  - Clean rows with 1px bottom dividers and hover states (`hover:bg-surface-container-lowest dark:hover:bg-white/5`).
- **Brand & SEO Naming:** 
  - The official application and SEO title is strictly **"Sistem Informasi Bengkel" (SIBENGKEL)**. The term "Sistem Manajemen" is deprecated and must not be used in headers, titles, or meta tags.