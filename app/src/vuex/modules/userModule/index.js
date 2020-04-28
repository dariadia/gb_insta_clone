import _ from 'lodash';
import { userApi } from "../../../common/request/UserApi";
import { profileApi } from "../../../common/request/ProfileApi";
import {
  INIT,
  LOGIN_ACTION,
  LOGOUT_ACTION,
  REGISTER_ACTION,
  REGISTER_SUCCESS,
  REGISTER_ERROR,
  LOGIN_ACTION_ERROR,
  LOGIN_ACTION_SUCCESS,
  GET_PROFILE,
  GET_PROFILE_SUCCESS,
  GET_PROFILE_ERROR
} from "./constants";

const TOKEN_KEY = 'token';

/**
 * чтоб не было соблазна редактировать обьект стандартного состояния
 * @type { object }
 **/
export const usersInitialState = Object.freeze({
  token: null,
  isGuest: true,
  isFetching: true,
  isProfileFetching: true,
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
    username: ({ personalData }) => personalData.username || null,
    token: ({ token }) => token,
    errors: ({ errors }) => errors,
    isUserFetching: ({ isFetching }) => isFetching,
    isUserProfileIsFetching: ({ isProfileFetching }) => isProfileFetching,
  },
  setters: {},
  mutations: {
    [ INIT ]: ( state, token ) => {
      if ( token ) {
          state.isGuest = false;
          state.token = token;
      }
      state.isFetching = false;
    },
    [ LOGOUT_ACTION ] : ( state ) => {
      state.token = null;
      state.isGuest = usersInitialState.isGuest;
      state.personalData = usersInitialState.personalData;
      document.cookie = 'token=';
    },

    /**
     * Действия при регистрации, Коммитить не обядательно действия 1 в 1 как было то что вызванно,
     * коммитить можно любые другие действия, потому что мы можем пойти по разным веткам
     **/
    [ REGISTER_SUCCESS ]:  ( state, response ) => {
      /** с ответа скорее всего будем получать некий токен, либо id сессии*/
      const { token } = response;
      state.token = token;
      state.errors.register = null;
    },
    [ REGISTER_ERROR ]:  ( state, errors ) => {
      state.errors.register = _.mapKeys( errors, (value, key) => _.camelCase(key) );
    },
    [ LOGIN_ACTION_SUCCESS ]: ( state, authToken ) => {
      state.token = authToken;
      state.isGuest = false;

      userApi.setToken( authToken );
      /** @todo придумать защиту */
      document.cookie = `token=${ authToken }`;
    },
    /** Обрабатываем както ошибку при авторизации @todo реализовать */
    [ LOGIN_ACTION_ERROR ]: ( state ) => {
      state.errors.login = 'Неверное имя пользователя или пароль';
    },
    /** Прфиль успешно получен, сохраняем данные **/
    [ GET_PROFILE_SUCCESS ]: ( state, data ) => {
      state.isProfileFetching = false;
      state.personalData = { ...state.personalData, ...data };
    },
    /** Сохраняем данные, либо чтото делаем если профиль не был найден **/
    [ GET_PROFILE_ERROR ]: ( state ) => {
      state.isProfileFetching = false;
      state.errors.personalData = 'cant get profile';
    },
  },
  actions: {
    /** @todo найти модуль или написать класс для работы с куками */
    [ INIT ]: ({ commit }) => {
      let token = null;
      const cookies = document.cookie.split(';');
      const tokenString = cookies.find(item => item.match( RegExp( TOKEN_KEY )) );
      if ( tokenString ) {
        const parts = tokenString.split('=');
        const tokenPart = parts[ 1 ];
        token = tokenPart && tokenPart.trim() ? tokenPart : null;

        token && userApi.setToken( token );
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
      const { status, data } = await profileApi.getProfileByAuthToken();
      /** както будем проверять на ошибки*/
      if ( status === 200 ) {
        commit( GET_PROFILE_SUCCESS, data );
      } else {
        commit( GET_PROFILE_ERROR );
      }
    },
  }
};