import { SET_PROFILE_REQUEST_DATE, SET_PROFILE_REQUEST_VIEW } from "./constants";
import { profileApi } from "../../../common/request/ProfileApi";
import { Api } from "../../../common/request/Api";
const { freeze } = Object;

/**
 * @type { object }
 * */
export const profileInitialState = freeze({
    profileList: [],
    profileItem: {},
    profileHeaders: []
});

export default {
    state: { ...profileInitialState },
    getters: {
        profileList: ({ profileList }) => profileList,
        profileItem: ({ profileItem }) => profileItem,
        profileHeaders: ({ profileHeaders }) => profileHeaders,
    },
    setters: {},
    mutations: {
        [ SET_PROFILE_REQUEST_DATE ] : ( state, response ) => {
            const { headers, data } = response || {};
            const profileList = data || profileInitialState.profileList;

            state.profileList.push( ...profileList );
            state.profileHeaders = Api.parseHeaders( headers );
        },
        [ SET_PROFILE_REQUEST_VIEW ] : ( state, response ) => {
            const { headers, data } = response || {};

            state.profileItem = data.length ? data[data.length - 1] : profileInitialState.profileItem;
            state.profileHeaders = Api.parseHeaders( headers );
        },
    },
    actions: {
        [ SET_PROFILE_REQUEST_DATE ] : async ({ commit }, payload ) => {
            const response = await profileApi.getProfilesList( payload );
            commit( SET_PROFILE_REQUEST_DATE, response );
        },
        [ SET_PROFILE_REQUEST_VIEW ] : async ({ commit }, payload ) => {
            const response = await profileApi.getProfileItem( payload );
            commit( SET_PROFILE_REQUEST_VIEW, response );
        },
    }
};