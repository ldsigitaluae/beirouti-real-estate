# Preview the Solara Bay website in Lovable

## Goal
Bring the uploaded Solara Bay website into this project so it can be reviewed in the Lovable preview first. Public publishing and WordPress-theme packaging will remain separate later steps.

## Implementation
1. **Port the uploaded design faithfully**
   - Recreate the full home page at `/` in the current React app.
   - Preserve the existing branding, typography, responsive layouts, sections, navigation, service tabs, area search and filters, FAQ, contact form, mobile menu, and WhatsApp enquiry flow.
   - Keep the uploaded fallback illustrations because the ZIP contains image placeholders rather than final property photography.

2. **Bring over all community guides**
   - Convert the 36 generated community pages into a reusable dynamic area page at `/area/{slug}`.
   - Preserve each community’s supplied copy, tags, highlights, access details, and enquiry links.
   - Add page-specific search and social metadata for the home page and each community.

3. **Adapt safely to this project**
   - Translate the static HTML, CSS, and JavaScript into the project’s existing structure without importing the uploaded `.git` history, generated cache files, or build output.
   - Keep the uploaded contact, WhatsApp, office, DED, and ORN placeholders unchanged so the preview does not invent business details.
   - Keep forms as WhatsApp handoffs; no database or email delivery is included in this preview.

4. **Preview verification**
   - Check the home page and representative community pages on desktop and mobile.
   - Test navigation, tabs, search/filtering, dialogs, form validation, WhatsApp links, keyboard focus, reduced-motion behavior, and missing-image fallbacks.
   - Resolve layout, runtime, and build errors before presenting the preview.

## Deferred until after preview approval
- Public publishing.
- Replacing placeholder business details and adding final photography.
- Packaging the approved result as a WordPress theme.
