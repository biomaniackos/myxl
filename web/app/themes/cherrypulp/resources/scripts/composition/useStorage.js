/**
 * Decode value from encoded storage.
 * @param value
 * @return {RegExp|Date|boolean|string|*|number}
 */
function decode(value) {
    let type, length, source;

    length = value.length;

    if (length < 10) {
        // then it wasn't encoded by us
        return value;
    }

    type = value.substr(0, 8);
    source = value.substring(9);

    switch (type) {
        case '__date__':
            return new Date(source);

        case '__expr__':
            return new RegExp(source);

        case '__numb__':
            return Number(source);

        case '__bool__':
            return Boolean(source === '1');

        case '__strn__':
            return `${source}`;

        case '__objt__':
            return JSON.parse(source);

        default:
            // hmm, we reached here, we don't know the type,
            // then it means it wasn't encoded by us, so just
            // return whatever value it is
            return value;
    }
}

/**
 * Encode value for storage.
 * @param value
 * @return {string|*}
 */
function encode(value) {
    if (Object.prototype.toString.call(value) === '[object Date]') {
        return `__date__|${value.toUTCString()}`;
    }

    if (Object.prototype.toString.call(value) === '[object RegExp]') {
        return `__expr__|${value.source}`;
    }

    if (typeof value === 'number') {
        return `__numb__|${value}`;
    }

    if (typeof value === 'boolean') {
        return `__bool__|${value ? '1' : '0'}`;
    }

    if (typeof value === 'string') {
        return `__strn__|${value}`;
    }

    if (typeof value === 'function') {
        return `__strn__|${value.toString()}`;
    }

    if (value === Object(value)) {
        return `__objt__|${JSON.stringify(value)}`;
    }

    // hmm, we don't know what to do with it,
    // so just return it as is
    return value;
}

/**
 * Add storage methods.
 * @param {String} defaultType Local or session. (default: local)
 * @return {boolean|{}|null|*|{hasStorage(*=, *=): boolean, removeStorage(*=, *=): void, setStorage(*=, *=, *=): void, getStorage(*=, *=, *=): (*|null), isEmptyStorage(*, *=): boolean, clearStorage(*=): *, getAllStorage(*=): {}}|RegExp|Date|string|number}
 */
export default function useStorage(defaultType = 'local') {
    return {
        /**
         * Clear storage.
         * @param type
         * @return {*}
         */
        clearStorage(type = null) {
            return window[`${type || defaultType}Storage`].clear();
        },

        /**
         * Get all values from storage.
         * @param type
         */
        getAllStorage(type = null) {
            const storage = window[`${type || defaultType}Storage`];
            const keys = Object.keys(storage);
            return keys.reduce((acc, key) => {
                acc[key] = decode(storage.getItem(key));
                return acc;
            }, {});
        },

        /**
         * Get a stored value from storage.
         * @param key
         * @param defaultValue
         * @param type
         * @return {null|*}
         */
        getStorage(key, defaultValue = null, type = null) {
            if (this.hasStorage(key)) {
                return decode(window[`${type || defaultType}Storage`].getItem(key));
            }

            return defaultValue;
        },

        /**
         * Return if key exist.
         * @param key
         * @param type
         * @return {boolean}
         */
        hasStorage(key, type = null) {
            return window[`${type || defaultType}Storage`].getItem(key) !== null;
        },

        /**
         * Return true if storage is empty.
         * @param key
         * @param type
         * @return {boolean}
         */
        isEmptyStorage(key, type = null) {
            return window[`${type || defaultType}Storage`].length === 0;
        },

        /**
         * Remove a value from storage.
         * @param key
         * @param type
         */
        removeStorage(key, type = null) {
            window[`${type || defaultType}Storage`].removeItem(key);
        },

        /**
         * Put a value in storage.
         * @param key
         * @param value
         * @param type
         */
        setStorage(key, value, type = null) {
            window[`${type || defaultType}Storage`].setItem(key, encode(value));
        },
    };
}
