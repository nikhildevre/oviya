/**
 * Oviya application JS — deferred, runs after DOMContentLoaded.
 *
 */
(function () {
	'use strict';

	function initSidebar() {
		const ATTR_DISPLAY = 'sidebar-display';
		const $sidebar = document.getElementById('sidebar');
		const $trigger = document.getElementById('sidebar-trigger');
		const $mask = document.getElementById('mask');
		if (!$sidebar || !$trigger || !$mask) return;

		let isExpanded = false;
		function toggle() {
			isExpanded = !isExpanded;
			document.body.toggleAttribute(ATTR_DISPLAY, isExpanded);
			$sidebar.classList.toggle('z-2', isExpanded);
			$mask.classList.toggle('d-none', !isExpanded);
		}
		$trigger.onclick = $mask.onclick = toggle;
	}

	function initTopbar() {
		const $trigger = document.getElementById('search-trigger');
		const $cancel = document.getElementById('search-cancel');
		const $topbar = document.getElementById('topbar');
		const $input = document.getElementById('search-input');
		if (!$trigger || !$cancel || !$topbar) return;

		function show() {
			$topbar.classList.add('unloaded');
			if ($input) $input.focus();
		}
		function hide() {
			$topbar.classList.remove('unloaded');
		}
		$trigger.addEventListener('click', show);
		$cancel.addEventListener('click', hide);
	}

	function back2top() {
		const btn = document.getElementById('back-to-top');
		if (!btn) return;

		window.addEventListener('scroll', () => {
			btn.classList.toggle('show', window.scrollY > 50);
		});
		btn.addEventListener('click', () => window.scrollTo({ top: 0 }));
	}

	function loadTooltip() {
		if (typeof bootstrap === 'undefined' || !bootstrap.Tooltip) return;
		document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((el) => new bootstrap.Tooltip(el));
	}

	function modeWatcher() {
		if (typeof Theme === 'undefined' || !Theme.isToggleable) return;

		const dropdown = document.querySelector('#mode-toggle + .dropdown-menu');
		if (!dropdown) return;

		const ACTIVE_CLASS = 'active';
		const activeMode = Theme.isSystemTheme ? Theme.Mode.SYSTEM : Theme.resolvedTheme;

		dropdown.querySelectorAll('.dropdown-item').forEach((option) => {
			if (option.dataset.themeMode === activeMode) {
				option.classList.add(ACTIVE_CLASS);
			}
		});

		dropdown.addEventListener('click', (event) => {
			const current = event.target.closest('.dropdown-item');
			if (!current) return;

			const lastActive = dropdown.querySelector('.' + ACTIVE_CLASS);
			if (lastActive === current) return;

			if (lastActive) lastActive.classList.remove(ACTIVE_CLASS);
			current.classList.add(ACTIVE_CLASS);
			Theme.update(current.dataset.themeMode);
		});
	}

	function loadImg() {
		const ATTR_DATA_SRC = 'data-src';
		const ATTR_DATA_LQIP = 'data-lqip';
		const cover = { SHIMMER: 'shimmer', BLUR: 'blur' };

		function removeCover(img, clzss) {
			if (img.parentElement) img.parentElement.classList.remove(clzss);
		}
		function handleImage() {
			if (!this.complete) return;
			removeCover(this, this.hasAttribute(ATTR_DATA_LQIP) ? cover.BLUR : cover.SHIMMER);
		}
		function switchLQIP(img) {
			const src = img.getAttribute(ATTR_DATA_SRC);
			img.setAttribute('src', encodeURI(src));
			img.removeAttribute(ATTR_DATA_SRC);
		}

		const images = document.querySelectorAll('article img');
		if (images.length === 0) return;

		images.forEach((img) => img.addEventListener('load', handleImage));

		document.querySelectorAll('article img[loading="lazy"]').forEach((img) => {
			if (img.complete) removeCover(img, cover.SHIMMER);
		});

		document.querySelectorAll(`article img[${ATTR_DATA_LQIP}="true"]`).forEach(switchLQIP);
	}

	function imgPopup() {
		if (typeof GLightbox === 'undefined') return;
		if (document.querySelector('.popup') === null) return;
		GLightbox({ selector: '.popup' });
	}

	function initClipboard() {
		if (typeof ClipboardJS === 'undefined' || typeof bootstrap === 'undefined') return;

		const clipboardSelector = '.code-header>button';
		const ICON_DEFAULT = 'far fa-clipboard';
		const ICON_SUCCESS = 'fas fa-check';
		const ATTR_TIMEOUT = 'timeout';
		const ATTR_TITLE_SUCCEED = 'data-title-succeed';
		const ATTR_TITLE_ORIGIN = 'data-bs-original-title';
		const TIMEOUT = 2000;

		function isLocked(node) {
			const t = node.getAttribute(ATTR_TIMEOUT);
			return t && Number(t) > Date.now();
		}
		function lock(node) {
			node.setAttribute(ATTR_TIMEOUT, Date.now() + TIMEOUT);
		}
		function unlock(node) {
			node.removeAttribute(ATTR_TIMEOUT);
		}

		function setCodeClipboard() {
			const list = document.querySelectorAll(clipboardSelector);
			if (list.length === 0) return;

			const clipboard = new ClipboardJS(clipboardSelector, {
				target: (trigger) => {
					const codeBlock = trigger.parentNode.nextElementSibling;
					return codeBlock.querySelector('code .rouge-code') || codeBlock.querySelector('code');
				}
			});

			[...list].forEach((el) => new bootstrap.Tooltip(el, { placement: 'left' }));

			clipboard.on('success', (e) => {
				const trigger = e.trigger;
				e.clearSelection();
				if (isLocked(trigger)) return;

				const icon = trigger.children[0];
				icon.setAttribute('class', ICON_SUCCESS);

				const succeedTitle = trigger.getAttribute(ATTR_TITLE_SUCCEED);
				trigger.setAttribute(ATTR_TITLE_ORIGIN, succeedTitle);
				bootstrap.Tooltip.getInstance(trigger)?.show();
				lock(trigger);

				setTimeout(() => {
					bootstrap.Tooltip.getInstance(trigger)?.hide();
					trigger.removeAttribute(ATTR_TITLE_ORIGIN);
					icon.setAttribute('class', ICON_DEFAULT);
					unlock(trigger);
				}, TIMEOUT);
			});
		}

		function setLinkClipboard() {
			const btn = document.getElementById('copy-link');
			if (!btn) return;

			btn.addEventListener('click', (e) => {
				const target = e.target.closest('button') || e.target;
				if (isLocked(target)) return;

				navigator.clipboard.writeText(window.location.href).then(() => {
					const defaultTitle = target.getAttribute(ATTR_TITLE_ORIGIN);
					const succeedTitle = target.getAttribute(ATTR_TITLE_SUCCEED);
					target.setAttribute(ATTR_TITLE_ORIGIN, succeedTitle);
					bootstrap.Tooltip.getInstance(target)?.show();
					lock(target);

					setTimeout(() => {
						target.setAttribute(ATTR_TITLE_ORIGIN, defaultTitle);
						unlock(target);
					}, TIMEOUT);
				});
			});

			btn.addEventListener('mouseleave', () => {
				bootstrap.Tooltip.getInstance(btn)?.hide();
			});
		}

		setCodeClipboard();
		setLinkClipboard();
	}

	function categoryCollapse() {
		const children = document.getElementsByClassName('collapse');
		if (children.length === 0) return;

		[...children].forEach((elem) => {
			if (!elem.id.startsWith('l_')) return;
			const parent = document.getElementById('h_' + elem.id.substring(2));

			elem.addEventListener('hide.bs.collapse', () => {
				if (!parent) return;
				const openIcon = parent.querySelector('.far.fa-folder-open');
				if (openIcon) openIcon.className = 'far fa-folder fa-fw';
				const angle = parent.querySelector('.fas.fa-angle-down');
				if (angle) angle.classList.add('rotate');
				parent.classList.remove('hide-border-bottom');
			});

			elem.addEventListener('show.bs.collapse', () => {
				if (!parent) return;
				const closedIcon = parent.querySelector('.far.fa-folder');
				if (closedIcon) closedIcon.className = 'far fa-folder-open fa-fw';
				const angle = parent.querySelector('.fas.fa-angle-down');
				if (angle) angle.classList.remove('rotate');
				parent.classList.add('hide-border-bottom');
			});
		});
	}

	function initLocaleDatetime() {
		if (typeof dayjs === 'undefined') return;

		const locale = document.documentElement.getAttribute('lang')?.substring(0, 2) || 'en';
		try {
			dayjs.locale(locale);
		} catch (e) {
			/* falls back to default locale if the CDN locale file 404s */
		}
		if (window.dayjs_plugin_localizedFormat) dayjs.extend(window.dayjs_plugin_localizedFormat);
		if (window.dayjs_plugin_relativeTime) dayjs.extend(window.dayjs_plugin_relativeTime);

		document.querySelectorAll('[datetime]').forEach((elem) => {
			const date = dayjs(elem.getAttribute('datetime'));
			if (!date.isValid()) return;
			elem.textContent = date.format(elem.dataset.df || 'LL');
			delete elem.dataset.df;

			if (elem.dataset.bsToggle === 'tooltip') {
				elem.dataset.bsTitle = date.format('llll');
				if (typeof bootstrap !== 'undefined') new bootstrap.Tooltip(elem);
			}
		});
	}

	function loadMermaid() {
		if (typeof mermaid === 'undefined' || typeof mermaid.initialize !== 'function') return;

		const themeMap = Theme.newThemeMap('default', 'dark');

		function setNode(elem) {
			const svgCode = elem.textContent;
			const backup = elem.parentElement;
			backup.classList.add('d-none');
			const node = document.createElement('pre');
			node.classList.add('mermaid');
			node.appendChild(document.createTextNode(svgCode));
			backup.after(node);
		}

		const basicList = document.getElementsByClassName('language-mermaid');
		[...basicList].forEach(setNode);

		mermaid.initialize({ theme: themeMap[Theme.resolvedTheme] });
		mermaid.init(null, '.mermaid');

		if (Theme.isToggleable) {
			window.addEventListener('message', (event) => {
				if (event.source !== window || !event.data || event.data.id !== Theme.eventId) return;
				[...document.getElementsByClassName('mermaid')].forEach((elem) => {
					const svgCode = elem.previousSibling?.children?.item(0)?.textContent;
					if (svgCode) elem.textContent = svgCode;
					elem.removeAttribute('data-processed');
				});
				mermaid.initialize({ theme: themeMap[Theme.resolvedTheme] });
				mermaid.init(null, '.mermaid');
			});
		}
	}

	function initToc() {
		if (typeof tocbot === 'undefined') return;
		if (document.querySelector('main>article[data-toc="true"]') === null) return;

		const desktopOptions = {
			tocSelector: '#toc',
			contentSelector: '.content',
			ignoreSelector: '[data-toc-skip]',
			headingSelector: 'h2, h3, h4',
			orderedList: false,
			scrollSmooth: false,
			headingsOffset: 32
		};

		const mobileOptions = Object.assign({}, desktopOptions, {
			tocSelector: '#toc-popup-content',
			collapseDepth: 4,
			headingsOffset: 48
		});

		const $tocWrapper = document.getElementById('toc-wrapper');
		const $tocBar = document.getElementById('toc-bar');
		const $soloTrigger = document.getElementById('toc-solo-trigger');
		const $triggers = document.getElementsByClassName('toc-trigger');
		const $popup = document.getElementById('toc-popup');
		const $btnClose = document.getElementById('toc-popup-close');

		const desktopMode = window.matchMedia('(min-width: 1200px)');
		let barInitialized = false;

		function listenAnchors() {
			document.querySelectorAll('.toc-link').forEach((anchor) => {
				anchor.onclick = () => hidePopup();
			});
		}

		function initBar() {
			if (!$soloTrigger || !$tocBar) return;
			const observer = new IntersectionObserver(
				(entries) => entries.forEach((entry) => $tocBar.classList.toggle('invisible', entry.isIntersecting)),
				{ rootMargin: '-48px 0px 0px 0px' }
			);
			observer.observe($soloTrigger);
			barInitialized = true;
		}

		function lockScroll(enable) {
			document.documentElement.classList.toggle('overflow-hidden', enable);
			document.body.classList.toggle('overflow-hidden', enable);
		}

		function showPopup() {
			if (!$popup) return;
			lockScroll(true);
			$popup.showModal();
			if ($btnClose) $btnClose.blur();
			const activeItem = $popup.querySelector('li.is-active-li');
			if (activeItem) activeItem.scrollIntoView({ block: 'center' });
		}

		function hidePopup() {
			if (!$popup) return;
			$popup.toggleAttribute('closing');
			$popup.addEventListener('animationend', () => {
				$popup.toggleAttribute('closing');
				$popup.close();
			}, { once: true });
			lockScroll(false);
		}

		function initMobileComponents() {
			initBar();
			[...$triggers].forEach((trigger) => (trigger.onclick = showPopup));
			if ($popup) {
				$popup.onclick = (e) => {
					if ($popup.hasAttribute('closing')) return;
					const rect = e.target.getBoundingClientRect();
					if (e.clientX < rect.left || e.clientX > rect.right || e.clientY < rect.top || e.clientY > rect.bottom) {
						hidePopup();
					}
				};
				$popup.oncancel = (e) => {
					e.preventDefault();
					hidePopup();
				};
			}
			if ($btnClose) $btnClose.onclick = hidePopup;
		}

		function initDesktop() {
			tocbot.init(desktopOptions);
		}
		function initMobile() {
			tocbot.init(mobileOptions);
			listenAnchors();
			initMobileComponents();
		}

		function refresh(e) {
			if (e.matches) {
				tocbot.destroy();
				initDesktop();
			} else {
				tocbot.destroy();
				initMobile();
			}
		}

		if (desktopMode.matches) {
			initDesktop();
		} else {
			initMobile();
		}

		if ($tocWrapper) $tocWrapper.classList.remove('invisible');
		desktopMode.addEventListener('change', refresh);
	}

	document.addEventListener('DOMContentLoaded', function () {
		initSidebar();
		initTopbar();
		back2top();
		loadTooltip();
		modeWatcher();
		initLocaleDatetime();
		categoryCollapse();

		const layout = (window.OviyaSettings && window.OviyaSettings.layout) || '';

		if ('home' !== layout) {
			loadImg();
			imgPopup();
			initClipboard();
		} else {
			loadImg();
		}

		initToc();
		loadMermaid();
	});

	document.addEventListener('DOMContentLoaded', function () {
  		const searchTrigger = document.getElementById('search-trigger');
  		const searchCancel = document.getElementById('search-cancel');
		const topbarWrapper = document.getElementById('topbar-wrapper');
		const searchElement = document.getElementById('search');

		if (searchTrigger) {
			searchTrigger.addEventListener('click', function (e) {
			e.preventDefault();
			if (topbarWrapper) topbarWrapper.classList.add('search-active');
			if (searchElement) searchElement.classList.add('active');
			document.body.classList.add('search-active');
			});
		}

		if (searchCancel) {
			searchCancel.addEventListener('click', function (e) {
			e.preventDefault();
			if (topbarWrapper) topbarWrapper.classList.remove('search-active');
			if (searchElement) searchElement.classList.remove('active');
			document.body.classList.remove('search-active');
			});
		}
	});
})();
