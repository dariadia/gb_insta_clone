import {
    SET_PROFILE_REQUEST_DATE,
    SET_PROFILE_REQUEST_VIEW, UPDATE_PROFILE,
    UPLOAD_NEW_PHOTO,
    UPLOAD_PHOTO_ERROR,
    UPLOAD_PHOTO_SUCCESS
} from "./constants";
import { profileApi } from "../../../common/request/ProfileApi";
import { Api } from "../../../common/request/Api";
import { getProfile} from "../userModule/actions/getProfile";
const { freeze } = Object;

export const DEFAULT_PROFILE_PHOTO = 'profile.jpg';

/**
 * @type { object }
 * */
export const profileInitialState = freeze({
    profileList: [],
    profileItem: null,
    profileHeaders: [],
    profilePath: process.env.VUE_APP_STATIC_HOST + 'profiles/',
    errors: []
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
        [ UPLOAD_PHOTO_SUCCESS ] : ( state ) => state,
        [ UPLOAD_PHOTO_ERROR ] : ( state, error ) => state.errors.push( error ),
        [ UPDATE_PROFILE ] : ( state ) => state,
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
        [ UPLOAD_NEW_PHOTO ] : async ({ commit }, payload ) => {
            const { status, data } = await profileApi.uploadNewPhoto( payload );
            if ( status === Api.STATUS_OK ) {
                await getProfile();
                commit( UPLOAD_PHOTO_SUCCESS, data );
            } else {
                commit( UPLOAD_PHOTO_ERROR );
            }
        },
        [ UPDATE_PROFILE ] : async ({ commit }, payload ) => {
            const { status } = await profileApi.updateUserProfile( payload );

            if ( status === Api.STATUS_OK ) {
                await getProfile();
            }
            commit( UPDATE_PROFILE );
        },
    }
};