import { Collection } from '../helpers/Collection';

export default new Collection({
    debug: false,
    sheldonCooperSays: 'Scissors cuts paper, paper covers rock, rock crushes lizard, lizard poisons Spock, Spock smashes scissors, scissors decapitates lizard, lizard eats paper, paper disproves Spock, Spock vaporizes rock, and as it always has, rock crushes scissors.',
    ...(window.__app || {}),
});
