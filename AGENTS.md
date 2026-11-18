<!-- LOVABLE:BEGIN -->
> [!IMPORTANT]
> This project is connected to [Lovable](https://lovable.dev). Avoid rewriting
> published git history — force pushing, or rebasing/amending/squashing commits
> that are already pushed — as it rewrites history on Lovable's side and the
> user will likely lose their project history.
>
> Commits you push to the connected branch sync back to Lovable and show up in
> the editor, so keep the branch in a working state.
<!-- LOVABLE:END -->

- Keep the supplied static Solara Bay build isolated under `public/solara` and present it through the index route, because this preserves the approved source behavior for preview before WordPress conversion.
- Build the WordPress theme package from `public/solara` as the visual source of truth, because Preview and the installable theme must remain visually identical.
- Keep the WordPress package lightweight and provide built-in demo setup plus native controls for brand, hero, menus, footer, contact details, and imagery, because the theme must be reusable by different Dubai property companies.
- Keep reusable WordPress PHP and configuration in `wordpress-theme` and package its `site` from `public/solara`, because future deliveries must retain customization without diverging from preview.
- Share cross-page presentation revisions through the static build's local stylesheet and rewrite its URL in the theme renderer, because both preview and WordPress must use the same styles.
