const defaultModule = {
    beforeCreate(args) {},
    beforeDestroy(args) {},
    beforeMount(args) {},
    created(args) {},
    destroyed(args) {},
    mounted(args) {},
    when: true,
};

/**
 * @example
 * const controller = new Controller();
 *
 * controller.push({
 *     mounted() { // do something... },
 *     when: 'home',
 * });
 */
export default class Controller {
    /**
     * @type {DOMElement|null}
     * @private
     */
    _element = null;

    /**
     * @type {[]}
     * @private
     */
    _modules = [];

    /**
     * Constructor.
     * @param {any[]|{}} modules
     * @param {{}} shared
     */
    constructor(modules = [], element = document.body) {
        this._element = element;

        if (Boolean(modules) && typeof modules === 'object' && modules.constructor === Object) {
            modules = Object.keys(modules).reduce((acc, className) => {
                acc.push({
                    when: () => Array.from(document.body.classList).includes(className),
                    mounted: modules[ className ],
                });

                return acc;
            }, []);
        }

        modules.forEach((module) => this.push(module));
    }

    /**
     * Create.
     * @return {Controller}
     */
    create() {
        this.fire('beforeCreate');
        this.fire('created');
        return this;
    }

    /**
     * Destroy.
     * @return {Controller}
     */
    destroy() {
        this.fire('beforeDestroy');
        this.fire('destroyed');
        return this;
    }

    /**
     * Fire.
     * @param {string} method
     * @return {Controller}
     */
    fire(method) {
        const args = {
            element: this._element,
            modules: this._modules,
        };
        this._modules.forEach((module) => {
            if (module.when(args)) {
                this.trigger(`${method}:before`, args);
                module[method].call(this, args);
                this.trigger(method, args);
                this.trigger(`${method}:after`, args);
            }
        });
        return this;
    }

    /**
     * Mount.
     * @return {Controller}
     */
    mount() {
        this.create();
        this.fire('beforeMount');
        this.fire('mounted');
        return this;
    }

    /**
     * Off.
     * @param {string} eventName
     * @param {function} callback
     * @return {Controller}
     */
    off(eventName, callback) {
        this._element.removeEventListener(eventName, callback);
        return this;
    }

    /**
     * On.
     * @param {string} eventName
     * @param {function} callback
     * @return {Controller}
     */
    on(eventName, callback) {
        this._element.addEventListener(eventName, callback, false);
        return this;
    }

    /**
     * Push.
     * @param {{}} module
     * @return {Controller}
     */
    push(module) {
        if (typeof module === 'function') {
            module = { mounted: module };
        }

        module = {...defaultModule, ...module};

        if (typeof module.when === 'boolean') {
            const result = module.when;
            module.when = () => result;
        } else if (typeof module.when === 'string') {
            const classNames = module.when.split(',').map((s) => s.trim());
            module.when = () => Array.from(document.body.classList).some((className) => classNames.includes(className));
        }

        this._modules.push(module);
        return this;
    }

    /**
     * Ready.
     * @return {Controller}
     */
    ready() {
        if (document.readyState !== 'loading') {
            setTimeout(() => this.mount(), 0);
            return this;
        }

        document.addEventListener('DOMContentLoaded', () => this.mount());
        return this;
    }

    /**
     * Trigger.
     * @param {string} eventName
     * @param args
     * @return {Controller}
     */
    trigger(eventName, args = null) {
        const event = new CustomEvent(eventName, { detail: args });
        this._element.dispatchEvent(event);
        return this;
    }
}
