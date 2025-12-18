import Collection from '../helpers/Collection';

export function useCollection(items = {}) {
    return new Collection(items);
}
