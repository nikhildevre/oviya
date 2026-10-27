=== Oviya ===
Contributors: Nikhil Devre
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.1.1
License: MIT License
License URI: https://github.com/nikhildevre/oviya/blob/main/LICENSE
Tags: blog, two-columns, right-sidebar, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready

Oviya WordPress Theme, Copyright 2026 Apur Group (Nikhil Devre)
Oviya is distributed under the terms of the MIT License.

== Description ==

A thoughtfully designed WordPress theme built for writers, developers, and independent creators who value clarity, performance, and a focused reading experience. 

It combines a clean, responsive design with essential tools for modern technical blogging, including:
* Native light and dark mode support
* Syntax-highlighted code blocks
* Integrated table-of-contents navigation
* Automated related posts engine
* Hierarchical category browsing
* Clean, responsive search sidebar

Designed with simplicity and usability at its core, Oviya provides a refined foundation for publishing technical articles, tutorials, documentation, and personal knowledge. Developed by Nikhil Devre of Apur Group.

== Installation ==

1. In your admin panel, go to **Appearance > Themes** and click **Add New**.
2. Click **Upload Theme** and choose the `oviya.zip` file.
3. Click **Install Now** and then **Activate**.

== Changelog ==

= 1.1.1 =
* Fixed skip-to-content focus visibility and accessibility styling.
* Updated style.css primary enqueueing and cleaned header metadata.
* Enqueued Disqus commenting script with proper privacy declaration.
* Wrapped mailto URLs with esc_url() in sidebar.
* Added nonce verification for author Twitter user meta.
* Removed inline onerror handlers from custom logo.
* Added proper text underlines for post content and comment links.
* Enabled viewport zoom/scaling.
* Fixed undefined variable warning on date archives.
* Prefixed widget area ID with theme slug.
* Documented third-party bundled resources and licenses.
* Included localization POT template.

= 1.1.0 =
* New Feature: Integrated highlightjs to automatically syntax-highlight code blocks in posts and pages.

= 1.0.2 =
* Documentation update: Added theme details, metadata, and description

= 1.0.1 =
* Documentation update: Added license details.

= 1.0.0 =
* Initial public release of the Oviya WordPress theme.


== Resources ==

* Bootstrap
  Source: https://getbootstrap.com/
  License: MIT License
  License URI: https://github.com/twbs/bootstrap/blob/main/LICENSE

* Font Awesome Free (Icons & Fonts)
  Source: https://fontawesome.com/
  License: SIL OFL 1.1 (Fonts), CC BY 4.0 (Icons), MIT License (Code)
  License URI: https://fontawesome.com/license/free

* Highlight.js
  Source: https://highlightjs.org/
  License: BSD 3-Clause License
  License URI: https://github.com/highlightjs/highlight.js/blob/main/LICENSE

* Tocbot
  Source: https://tscanlin.github.io/tocbot/
  License: MIT License
  License URI: https://github.com/tscanlin/tocbot/blob/master/LICENSE-MIT

* GLightbox
  Source: https://biati-digital.github.io/glightbox/
  License: MIT License
  License URI: https://github.com/biati-digital/glightbox/blob/master/LICENSE.md

* clipboard.js
  Source: https://clipboardjs.com/
  License: MIT License
  License URI: https://github.com/zenorocha/clipboard.js/blob/master/license

* Day.js
  Source: https://day.js.org/
  License: MIT License
  License URI: https://github.com/iamkun/dayjs/blob/master/LICENSE

* Mermaid
  Source: https://mermaid.js.org/
  License: MIT License
  License URI: https://github.com/mermaid-js/mermaid/blob/develop/LICENSE

* MathJax
  Source: https://www.mathjax.org/
  License: Apache License 2.0
  License URI: https://github.com/mathjax/MathJax/blob/master/LICENSE

* Lato Font
  Source: https://fonts.google.com/specimen/Lato
  Author: Łukasz Dziedzic
  License: SIL Open Font License, 1.1
  License URI: http://scripts.sil.org/OFL

* Source Sans 3 Font
  Source: https://fonts.google.com/specimen/Source+Sans+3
  Author: Frank Grießhammer / Adobe
  License: SIL Open Font License, 1.1
  License URI: http://scripts.sil.org/OFL

* Screenshot Images
  Source: Self-created by theme author
  License: CC0 1.0 Universal (Public Domain)
  License URI: https://creativecommons.org/publicdomain/zero/1.0/

== Privacy Note ==

This theme optionally provides an integration with Disqus comments when configured by the site administrator under Appearance > Customize > Comments.
When Disqus is selected and enabled on single posts and pages, it loads external JavaScript from disqus.com. Disqus is a third-party service that may collect IP addresses, browser information, and cookies in accordance with their privacy policy.
Disqus Privacy Policy: https://help.disqus.com/en/articles/1717103-disqus-privacy-policy