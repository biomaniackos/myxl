/**
 * Collection.
 * @note Deeply inspired by https://github.com/ecrmnn/collect.js
 *
 * @example
 * const collection = new Collection({
 *     foo: {
 *         bar: 'baz',
 *     },
 * });
 * collection.get('foo.bar');
 * collection.set('foo.bar', 'foo');
 */
export class Collection {
    /**
     * Items
     * @type {array|object}
     * @private
     */
    _items = [];

    /**
     * @param {array|object} items
     */
    constructor(items = {}) {
        this._items = items;
    }

    /**
     * Return all items.
     * @return {array|object}
     */
    all() {
        return this._items;
    }

    /**
     * Clone an array or object.
     * @return {Collection}
     */
    clone() {
        return new Collection(this._items);
    }

    /**
     * Get value of a nested property.
     * @param {string} key
     * @param {*} defaultValue
     * @return {*}
     */
    get(key, defaultValue = null) {
        try {
            const value = key.split('.').reduce((acc, prop) => acc[prop], this._items);

            if (value === undefined) {
                return defaultValue;
            }

            return value;
        } catch (err) {
            return defaultValue;
        }
    }

    /**
     * Check if a key exist in items.
     * @param {string} key
     * @return {boolean}
     */
    has(key) {
        return this.get(key) !== undefined;
    }

    /**
     * Merge given items with current collection.
     * @param {array|object|string} items
     * @return {Collection}
     */
    merge(items) {
        if (typeof items === 'string') {
            items = [items];
        }

        if (Array.isArray(this._items) && Array.isArray(items)) {
            this._items.concat(items);
        }

        Object.keys(items).forEach((key) => {
            this._items[key] = items[key];
        });

        return this;
    }

    /**
     * Merge recursively given items with current collection.
     * @param {array|object} items
     * @return {Collection}
     */
    mergeRecursive(items) {
        const mergeRecursive = (target, source) => {
            const merged = {};
            const mergedKeys = Object.keys(Object.assign({}, target, source));

            mergedKeys.forEach((key) => {
                if (target[key] === undefined && source[key] !== undefined) {
                    merged[key] = source[key];
                } else if (
                    target[key] !== undefined &&
                    source[key] === undefined
                ) {
                    merged[key] = target[key];
                } else if (
                    target[key] !== undefined &&
                    source[key] !== undefined
                ) {
                    if (target[key] === source[key]) {
                        merged[key] = target[key];
                    } else if (
                        !Array.isArray(target[key]) &&
                        typeof target[key] === 'object' &&
                        !Array.isArray(source[key]) &&
                        typeof source[key] === 'object'
                    ) {
                        merged[key] = mergeRecursive(target[key], source[key]);
                    } else {
                        merged[key] = [].concat(target[key], source[key]);
                    }
                }
            });

            return merged;
        };

        this._items = mergeRecursive(this._items, items);

        return this;
    }

    /**
     * Set the given key and value.
     * @param {string} key
     * @param {*} value
     * @return {array|object}
     */
    set(key, value) {
        const keys = key.split('.');
        let source = this._items;

        for (let i = 0, len = keys.length; i < len; i++) {
            const k = keys[i];

            if (i === keys.length - 1) {
                source[k] = value;
            }

            source = source[k];
        }

        return this._items;
    }

    /**
     * Converts the collection into a plain array. If the collection is an object, an array containing the values will be returned.
     * @return {array}
     */
    toArray() {
        /**
         * @param list
         * @param collection
         * @return {*}
         */
        function iterate(list, collection) {
            const childCollection = [];

            if (Array.isArray(list)) {
                list.forEach((i) => iterate(i, childCollection));
                collection.push(childCollection);
            } else {
                collection.push(list);
            }

            return collection;
        }

        if (Array.isArray(this._items)) {
            return this._items.reduce((acc, items) => iterate(items, acc), []);
        }

        return this.values();
    }

    /**
     * Converts the collection into JSON string.
     * @return {string}
     */
    toJSON() {
        if (Array.isArray(this._items)) {
            return JSON.stringify(this.toArray());
        }

        return JSON.stringify(this.all());
    }

    /**
     * Retrieve values from collection when it is an array or object.
     * @return {array}
     */
    values() {
        return Object.keys(this._items).map((key) => this._items[key]);
    }

    /**
     * Filters the collection by a given key / value pair.
     * @param {string} key
     * @param {string} operator
     * @param {*} value
     * @return {array}
     * @example
     * const filtered = collection.where('price', 100);
     * @example
     * const filtered = collection.where('price', '===', 100);
     */
    where(key, operator, value) {
        let comparisonOperator = operator;
        let comparisonValue = value;

        if (value === undefined) {
            comparisonValue = operator;
            comparisonOperator = '===';
        }

        const items = this.values();

        return items.filter((item) => {
            const val = new Collection(item).get(key);
            switch (comparisonOperator) {
                case '==':
                    return (
                        val === Number(comparisonValue) ||
                        val === comparisonValue.toString()
                    );

                default:
                case '===':
                    return val === comparisonValue;

                case '!=':
                case '<>':
                    return (
                        val !== Number(comparisonValue) &&
                        val !== comparisonValue.toString()
                    );

                case '!==':
                    return val !== comparisonValue;

                case '<':
                    return val < comparisonValue;

                case '<=':
                    return val <= comparisonValue;

                case '>':
                    return val > comparisonValue;

                case '>=':
                    return val >= comparisonValue;
            }
        });
    }

    /**
     * Filters the collection by a given key / value contained within the given array.
     * @param key
     * @param values
     * @return {array}
     * @example
     * const filtered = collection.whereIn('price', [100, 150]);
     */
    whereIn(key, values) {
        const items = new Collection(values).values();
        return this.values().filter(
            (item) => items.indexOf(new Collection(item).get(key)) !== -1,
        );
    }

    /**
     * Filters the collection by a given key / value not contained within the given array.
     * @param {string} key
     * @param {array} values
     * @return {array}
     * @example
     * const filtered = collection.whereNotIn('price', [100, 150]);
     */
    whereNotIn(key, values) {
        const items = new Collection(values).values();
        return this.values().filter(
            (item) => items.indexOf(new Collection(item).get(key)) === -1,
        );
    }
}
