import {LOGIN_ACTION, LOGOUT_ACTION} from "./constants";
const { freeze } = Object;

/**
 * чтоб не было соблазна редактировать обьект стандартного состояния
 * @type { object }
 * */
export const usersInitialState = freeze({
  username: null,
  token: null,
  isGuest: true,
  isFetching: false,
  personalData: freeze({}),
});

export default {
  state: { ...usersInitialState },
  getters: { isGuest: ({ isGuest }) => isGuest },
  setters: {},
  mutations: {
    [ LOGIN_ACTION ] : ( state ) => state.isGuest = false,
    [ LOGOUT_ACTION ] : ( state ) => state.isGuest = usersInitialState.isGuest,
  },
  actions: {
    [ LOGIN_ACTION ] : ({ commit }) => commit( LOGIN_ACTION ),
    [ LOGOUT_ACTION ] : ({ commit }) => commit( LOGOUT_ACTION ),
  }
};