import { userApi } from "../../../common/request/UserApi";
import {
  SEARCH_QUERY_CHANGE,
  LOGIN_ACTION,
  LOGOUT_ACTION,
  CLEAR_SEARCH_STRING,
  REGISTER_ACTION,
  REGISTER_SUCCESS, REGISTER_ERROR
} from "../userModule/constants";

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
  errors: [],
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
    /**
     * Действия при регистрации, Коммитить не обядательно действия 1 в 1 как было то что вызванно,
     * коммитить можно любые другие действия, потому что мы можем пойти по разным веткам
     **/
    [ REGISTER_SUCCESS ]:  ( state, response ) => {
      /** с ответа скорее всего будем получать некий токен, либо id сессии*/
      const { token } = response;
      state.token = token;
    },
    [ REGISTER_ERROR ]:  ( state, errorMessage ) => {
      state.errors.push( errorMessage);
    }
  },
  actions: {
    [ LOGIN_ACTION ] : ({ commit }) => commit( LOGIN_ACTION ),
    [ LOGOUT_ACTION ] : ({ commit }) => commit( LOGOUT_ACTION ),
    [ SEARCH_QUERY_CHANGE ] : ({ commit }, payload ) => commit( SEARCH_QUERY_CHANGE, payload.searchString ),
    [ CLEAR_SEARCH_STRING ] : ({ commit } ) => commit( CLEAR_SEARCH_STRING ),
    [ REGISTER_ACTION ]: async ({ commit }, payload ) => {
      const { data } = payload;
      const response = await userApi.register( data );
      /** както будем проверять на ошибки*/
      if (response ) {
        return commit( REGISTER_SUCCESS, response );
      }
     return  commit( REGISTER_ERROR, response );
    },
  }
};