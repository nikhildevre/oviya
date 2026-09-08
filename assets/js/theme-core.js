/**
 * A utility class that manages the site's theme mode.
 */
class Theme {
	static #storageKey = 'theme';

	static Mode = Object.freeze({
		DARK: 'dark',
		LIGHT: 'light',
		SYSTEM: 'system'
	});

	static #root = document.documentElement;
	static #mediaDark = window.matchMedia('(prefers-color-scheme: dark)');

	static get #domTheme() {
		return this.#root.dataset.bsTheme || null;
	}

	static get #storedTheme() {
		return localStorage.getItem(this.#storageKey);
	}

	static get #systemTheme() {
		return this.#prefersDark ? this.Mode.DARK : this.Mode.LIGHT;
	}

	static get #prefersDark() {
		return this.#mediaDark.matches;
	}

	static #apply(theme, { persist = false, domPersist = false } = {}) {
		this.#root.dataset.bsTheme = theme;

		if (persist) {
			localStorage.setItem(this.#storageKey, theme);
		}

		if (domPersist || persist) {
			this.#root.toggleAttribute('data-theme-persisted', true);
		}
	}

	static #clearStorage() {
		localStorage.removeItem(this.#storageKey);
		this.#root.toggleAttribute('data-theme-persisted', false);
	}

	static #notify() {
		window.postMessage({ id: this.eventId }, '*');
	}

	static isToggleable = this.#domTheme === null;
	static eventId = 'theme-updated';

	static get resolvedTheme() {
		return this.#storedTheme || this.#systemTheme;
	}

	static get isSystemTheme() {
		return this.#storedTheme === null;
	}

	static get isDark() {
		return this.resolvedTheme === this.Mode.DARK;
	}

	static newThemeMap(light, dark) {
		return {
			[this.Mode.LIGHT]: light,
			[this.Mode.DARK]: dark
		};
	}

	static init() {
		if (!this.isToggleable) {
			this.#clearStorage();
			return;
		}

		const storedTheme = this.#storedTheme;

		if (storedTheme) {
			this.#apply(storedTheme, { domPersist: true });
		} else {
			this.#apply(this.#systemTheme);
		}

		this.#mediaDark.addEventListener('change', () => {
			if (this.#storedTheme) {
				return;
			}
			this.#apply(this.#systemTheme);
			this.#notify();
		});
	}

	static update(mode) {
		const newTheme = mode === this.Mode.SYSTEM ? this.#systemTheme : mode;

		if (newTheme !== this.resolvedTheme) {
			this.#notify();
		}

		this.#apply(newTheme, { persist: mode !== this.Mode.SYSTEM });

		if (mode === this.Mode.SYSTEM) {
			this.#clearStorage();
		}
	}
}

Theme.init();
