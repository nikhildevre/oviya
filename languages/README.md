Generate oviya.pot with WP-CLI once the theme is installed:

    wp i18n make-pot . languages/oviya.pot

All translatable strings already use __() / _e() / esc_html__() etc.
throughout the theme, so no code changes are needed first.
