import { SET_PROFILE_REQUEST_DATE, SET_PROFILE_REQUEST_VIEW } from "./constants";
import { profileApi } from "../../../common/request/ProfileApi";
import { Api } from "../../../common/request/Api";
const { freeze } = Object;

export const DEFAULT_PROFILE_PHOTO = 'profile.jpg';

/**
 * @type { object }
 * */
export const profileInitialState = freeze({
    profileList: [],
    profileItem: null,
    profileHeaders: [],
    profilePath: process.env.VUE_APP_STATIC_HOST + 'profiles/'
});

export default {
    state: { ...profileInitialState },
    getters: {
        profileList: ({ profileList }) => profileList,
        profileItem: ({ profileItem }) => profileItem,
        profileHeaders: ({ profileHeaders }) => profileHeaders,
        profilePath: ({ profilePath }) => profilePath,
    },
    setters: {},
    mutations: {
        [ SET_PROFILE_REQUEST_DATE ] : ( state, response ) => {
            const { headers, data } = response || {};
            const profileList = data || profileInitialState.profileList;

            state.profileList.push( ...profileList );
            state.profileHeaders = Api.parseHeaders( headers );
        },
        [ SET_PROFILE_REQUEST_VIEW ] : ( state, data ) => {
            state.profileItem = data.length ? data[ 0 ] : profileInitialState.profileItem;
        },
    },
    actions: {
        [ SET_PROFILE_REQUEST_DATE ] : async ({ commit }, payload ) => {
            const response = await profileApi.getProfilesList( payload );
            commit( SET_PROFILE_REQUEST_DATE, response );
        },
        [ SET_PROFILE_REQUEST_VIEW ] : async ({ commit }, payload ) => {
            const { data } = await profileApi.getProfileItem( payload );
            commit( SET_PROFILE_REQUEST_VIEW, data );
        },
    }
};