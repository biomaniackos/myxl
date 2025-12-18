/**
 * Return base64 helpers methods.
 * @return {{encodeBase64: ((function(*=): (string|null))|*), decodeBase64: (function(*=): string), isBase64: ((function(*=): (boolean))|*)}}
 */
export default function useBase64() {
    return {
        decodeBase64,
        encodeBase64,
        isBase64,
    };
}

/**
 * Decode a base64 value.
 * @param value
 * @return {string}
 */
export function decodeBase64(value) {
    if (isBase64(value)) {
        value = atob(value);
    }

    if (typeof value === 'string') {
        try {
            value = JSON.parse(value);
        } catch (e) { /* shhhhhh... */ }
    }

    return value;
}

/**
 * Encode a value to base64.
 * @param value
 * @return {string|null}
 */
export function encodeBase64(value = false) {
    try {
        return btoa(JSON.stringify(value));
    } catch (e) { /* shhhhhh... */ }

    return null;
}

/**
 * Return true if given value is a base64.
 * @param value
 * @return {boolean}
 */
export function isBase64(value) {
    try {
        atob(value);
        return true;
    } catch (e) { /* shhhhhh... */ }

    return false;
}
