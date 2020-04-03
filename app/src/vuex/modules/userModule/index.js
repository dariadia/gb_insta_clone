import {SEARCH_QUERY_CHANGE, LOGIN_ACTION, LOGOUT_ACTION, CLEAR_SEARCH_STRING} from "../userModule/constants";

/**
 * чтоб не было соблазна редактировать обьект стандартного состояния
 * @type { object }
 * */
export const usersInitialState = Object.freeze({
  login: null,
  token: null,
  isGuest: true,
  isFetching: false,
  searchString: null,

  personalData: Object.freeze({
    userStatistics: null, /// будет заполнена при логине
  }),
});

export default {
  state: { ...usersInitialState },
  getters: {
    isGuest: ({ isGuest }) => isGuest,
    personalData: ({ personalData }) => personalData,
    searchString: ({ searchString }) => searchString,
  },
  setters: {},
  mutations: {
    [ LOGIN_ACTION ] : ( state ) => state.isGuest = false,
    [ LOGOUT_ACTION ] : ( state ) => state.isGuest = usersInitialState.isGuest,
    [ SEARCH_QUERY_CHANGE ] : ( state, searchString ) => state.searchString = searchString,
    [ CLEAR_SEARCH_STRING ] : ( state ) => state.searchString = usersInitialState.searchString,
  },
  actions: {
    [ LOGIN_ACTION ] : ({ commit }) => commit( LOGIN_ACTION ),
    [ LOGOUT_ACTION ] : ({ commit }) => commit( LOGOUT_ACTION ),
    [ SEARCH_QUERY_CHANGE ] : ({ commit }, payload ) => commit( SEARCH_QUERY_CHANGE, payload.searchString ),
    [ CLEAR_SEARCH_STRING ] : ({ commit } ) => commit( CLEAR_SEARCH_STRING ),
  }
};