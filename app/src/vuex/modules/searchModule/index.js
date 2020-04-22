import {
    SEARCH_QUERY_CHANGE,
    CLEAR_SEARCH_STRING,
    GET_SEARCHED_DATA,
    SEARCH_RESPONSE_SUCCESS,
    SEARCH_RESPONSE_ERROR
} from "./constants";
import { userApi } from "../../../common/request/UserApi";

/**
 * чтоб не было соблазна редактировать обьект стандартного состояния
 * @type { object }
 **/
export const searchInitialState = Object.freeze({
    isFetching: false,
    searchResults: [],
});

export default {
    state: { ...searchInitialState },
    getters: {
        searchString: ({ searchString }) => searchString,
        searchResults: ({ searchResults }) => searchResults,
        isFetching: ({ isFetching }) => isFetching,
    },
    setters: {},
    mutations: {
        [ SEARCH_QUERY_CHANGE ] : ( state, searchString ) => {
            state.isFetching = true;
            state.searchString = searchString
        },
        [ CLEAR_SEARCH_STRING ] : ( state ) => state.searchString = searchInitialState.searchString,
        [ SEARCH_RESPONSE_SUCCESS ] : ( state, data ) => {
            state.searchResults = data;
            state.isFetching = false;
        },
        [ SEARCH_RESPONSE_ERROR ] : ( state ) => {
            state.isFetching = false;
        }
    },
    actions: {
        [ SEARCH_QUERY_CHANGE ] : ({ commit }, payload ) => commit( SEARCH_QUERY_CHANGE, payload.searchString ),
        [ CLEAR_SEARCH_STRING ] : ({ commit }) => commit( CLEAR_SEARCH_STRING ),
        [ GET_SEARCHED_DATA ] : async ({ commit }, payload ) => {
            const { searchQuery } = payload;
            if ( !searchQuery ) {
                return commit( SEARCH_RESPONSE_SUCCESS, searchInitialState.searchResults );
            }
            const { status, data } = await userApi.search({ username: searchQuery });

            if ( status === 200 ) {
                return commit( SEARCH_RESPONSE_SUCCESS, data );
            }
            return commit( SEARCH_RESPONSE_ERROR, data );
        },
    }
};