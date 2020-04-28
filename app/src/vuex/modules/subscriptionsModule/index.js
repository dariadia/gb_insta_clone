
export const subscriptionsInitialState = Object.freeze({
    token: null,
    isGuest: true,
    isFetching: false,
    errors: {},
    followers: Object.freeze({}),
    subscriptions: Object.freeze({}),
});

export default {
    state: { ...subscriptionsInitialState },
    getters: {
        followers: ({ followers }) => followers.totalItems || 0,
        subscriptions: ({ subscriptions }) => subscriptions.totalItems || 0
    },
    mutations: {
    },
    actions: {
    }
};