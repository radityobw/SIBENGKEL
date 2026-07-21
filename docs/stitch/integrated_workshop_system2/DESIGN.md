---
name: Integrated Workshop System
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
  inverse-surface: '#2e3132'
  inverse-on-surface: '#f0f1f3'
  outline: '#74777f'
  outline-variant: '#c4c6cf'
  surface-tint: '#455f87'
  primary: '#022448'
  on-primary: '#ffffff'
  primary-container: '#1e3a5f'
  on-primary-container: '#8aa4cf'
  inverse-primary: '#adc8f5'
  secondary: '#904d00'
  on-secondary: '#ffffff'
  secondary-container: '#ffa454'
  on-secondary-container: '#713b00'
  tertiary: '#002447'
  on-tertiary: '#ffffff'
  tertiary-container: '#003a6c'
  on-tertiary-container: '#62a5f9'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#d5e3ff'
  primary-fixed-dim: '#adc8f5'
  on-primary-fixed: '#001c3b'
  on-primary-fixed-variant: '#2d486d'
  secondary-fixed: '#ffdcc3'
  secondary-fixed-dim: '#ffb77d'
  on-secondary-fixed: '#2f1500'
  on-secondary-fixed-variant: '#6e3900'
  tertiary-fixed: '#d4e3ff'
  tertiary-fixed-dim: '#a4c9ff'
  on-tertiary-fixed: '#001c39'
  on-tertiary-fixed-variant: '#004883'
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
The palette is built on "Industrial Navy" to establish trust and "Workshop Orange" to drive action. 

- **Primary (Industrial Navy):** Used for navigation sidebars, headers, and primary branding elements.
- **Secondary (Workshop Orange):** Reserved strictly for high-priority actions, Floating Action Buttons (FABs), and primary CTAs.
- **Backgrounds:** Light mode uses a sterile, clean gray (#F7F8FA) to reduce glare in workshop lighting. Dark mode uses a deep bluish-gray (#12151C) to maintain brand cohesion.
- **Status Colors:** High-saturation tones are used for status indicators (Amber, Blue, Green) to ensure they are glanceable across the garage floor. No pastels or muted tones are permitted; colors must remain "Industrial" and high-contrast.

## Typography
Typography is optimized for legibility in fast-paced environments. 

- **Headings:** Sora is used for its geometric, modern, and slightly technical feel. It commands attention and fits the "Integrated System" narrative.
- **Body & Data:** Inter is used for all functional text, data tables, and forms. Its high x-height ensures readability on tablets and handheld devices used by mechanics.
- **Hierarchy:** Use bold weights for data labels to ensure technicians can quickly distinguish between a label (e.g., "License Plate") and the value (e.g., "B 1234 ABC").

## Layout & Spacing
The layout uses a **Fluid Grid** system to maximize data density on desktop while remaining highly touch-accessible on mobile.

- **Desktop:** 12-column grid with a fixed sidebar (280px). 24px gutters.
- **Mobile/Tablet:** 4-column or 8-column grid with 16px side margins. 
- **Touch Targets:** All interactive elements (buttons, list items, inputs) must maintain a minimum height of **44px** to accommodate gloved or moving hands in a workshop setting.
- **Rhythm:** An 8px linear scale is used for all spatial relationships.

## Elevation & Depth
This design system uses a **Tonal Layering** approach combined with **Low-Contrast Outlines**.

- **Surfaces:** Depth is created by placing white cards on the light gray background. In Dark Mode, surfaces use a slightly lighter bluish-gray than the background.
- **Borders:** Every card and input field must have a 1px solid border (#E2E8F0 in light mode). This reinforces the "Industrial" and "Technical" feel.
- **Shadows:** Shadows are used sparingly to indicate "Interactable" or "Floating" states. Use a focused, medium-opacity shadow with 0px offset for active cards to make them appear slightly raised.

## Shapes
Shapes are defined as **Rounded**, striking a balance between modern software and mechanical components.

- **Standard Elements:** Buttons, inputs, and cards use an **8px (0.5rem)** corner radius.
- **Large Containers:** Modals and large dashboard panels use **16px (1rem)**.
- **Status Pills:** Tags and status indicators use a fully rounded/pill shape to distinguish them from functional buttons.

## Components

- **Buttons:** 
  - *Primary:* Navy background with white text. 
  - *Secondary (Action):* Workshop Orange background. Used for "Create Job," "Finalize Invoice," and FABs.
  - *Outlined:* 1px Navy border for secondary actions like "Print" or "Export."
- **Input Fields:** 
  - Background: White (Light) / Background-Elevated (Dark).
  - Border: 1px Solid Gray, turning Navy on focus. 
  - Labels must always be visible above the input, never just as placeholders.
- **Cards:** 
  - Used for vehicle summaries and job cards. Must include a colored "Status Strip" on the left border (Amber/Blue/Green) to indicate job progress.
- **Chips/Status:** 
  - High-contrast background with white text for status labels. Use semantic colors (e.g., Green for "Completed").
- **Icons:** 
  - Use 2px stroke "Line Icons." Avoid filled icons unless they are used in an active navigation state. Use industrial metaphors: gear, wrench, clipboard, speedometer.
- **Data Tables:** 
  - Clean rows with 1px bottom dividers. Alternating row colors (Zebra striping) are encouraged for high-density parts lists.