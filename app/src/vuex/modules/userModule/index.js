import { userApi } from "../../../common/request/UserApi";
import {
  INIT,
  SEARCH_QUERY_CHANGE,
  LOGIN_ACTION,
  LOGOUT_ACTION,
  CLEAR_SEARCH_STRING,
  REGISTER_ACTION,
  REGISTER_SUCCESS,
  REGISTER_ERROR,
  LOGIN_ACTION_ERROR,
  LOGIN_ACTION_SUCCESS,
  GET_PROFILE,
  GET_PROFILE_SUCCESS,
  GET_PROFILE_ERROR
} from "./constants";
import { getProfile } from "./actions/getProfile";

const TOKEN_KEY = 'token';

/**
 * чтоб не было соблазна редактировать обьект стандартного состояния
 * @type { object }
 **/
export const usersInitialState = Object.freeze({
  login: null,
  token: null,
  isGuest: true,
  isFetching: false,
  searchString: null,
  errors: {},
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
    token: ({ token }) => token,
    errors: ({ errors }) => errors,
  },
  setters: {},
  mutations: {
    [ INIT ]: ( state, token ) => {
      if ( token ) {
          state.isGuest = false;
          state.token = token;
      }
    },
    [ LOGOUT_ACTION ] : ( state ) => {
      state.token = null;
      state.isGuest = usersInitialState.isGuest;
      document.cookie = 'token=';
    },
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
    [ REGISTER_ERROR ]:  ( state, errors ) => {
      state.errors.register = errors;
    },
    [ LOGIN_ACTION_SUCCESS ]: ( state, authToken ) => {
      state.token = authToken;
      state.isGuest = false;

      /** @todo придумать защиту */
      document.cookie = `token=${ authToken }`;
    },
    /** Обрабатываем както ошибку при авторизации @todo реалиовать */
    [ LOGIN_ACTION_ERROR ]: ( state ) => {
      state.errors.login = 'Неверное имя пользователя или пароль';
    },
    /** Прфиль успешно получен, сохраняем данные **/
    [ GET_PROFILE_SUCCESS ]: ( state, data ) => {
      state.personalData = { ...state.personalData, ...data };
    },
    /** Сохраняем данные, либо чтото делаем если профиль не был найден **/
    [ GET_PROFILE_ERROR ]: ( state ) => {
      state.errors.profile= 'cant get profile';
    }
  },
  actions: {
    /** @todo найти модуль или написать класс для работы с куками */
    [ INIT ]: ({ commit }) => {
      let token = null;
      const cookies = document.cookie.split(';');
      const tokenString = cookies.find(item => item.match(RegExp(TOKEN_KEY)));

      if ( tokenString ) {
        const parts = tokenString.split('=');
        const tokenPart = parts[ 1 ];
        token = tokenPart && tokenPart.trim() ? tokenPart : null;

        if ( token ) {
          userApi.setToken( token );
          getProfile();
        }
      }
      commit( INIT, token );
    },
    [ LOGIN_ACTION ] : async ({ commit }, payload ) => {
      const { username, password } = payload;
      const { status, data } = await userApi.login( username, password );

      if ( status === 200 && data ) {
         return commit( LOGIN_ACTION_SUCCESS, data )
      }
      return commit( LOGIN_ACTION_ERROR );
    },
    [ LOGOUT_ACTION ] : ({ commit }) => commit( LOGOUT_ACTION ),
    [ SEARCH_QUERY_CHANGE ] : ({ commit }, payload ) => commit( SEARCH_QUERY_CHANGE, payload.searchString ),
    [ CLEAR_SEARCH_STRING ] : ({ commit } ) => commit( CLEAR_SEARCH_STRING ),

    /** Регистрация пользователя */
    [ REGISTER_ACTION ]: async ({ commit }, payload ) => {
      const { formValues } = payload;

      const clearFormFields = Object.entries( formValues ).map(([ key, { value } ]) => ({
        [ key ]: value
      }));
      const userObject = Object.assign({}, ...clearFormFields );

      const { status, data } = await userApi.signUp( userObject );

      /** както будем проверять на ошибки*/
      if ( status === 200 ) {
        return commit( REGISTER_SUCCESS, data.token );
      }
      return commit( REGISTER_ERROR, data.errors );
    },

    [ GET_PROFILE ]: async ({ commit }) => {
      const { status, data } = await userApi.getProfile();
      /** както будем проверять на ошибки*/
      if ( status === 200 ) {
        return commit( GET_PROFILE_SUCCESS, data );
      }
      return commit( GET_PROFILE_ERROR );
    },
  }
};