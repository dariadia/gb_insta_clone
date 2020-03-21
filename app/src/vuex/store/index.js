import Vue from "vue";
import Vuex from "vuex";
import createLogger from 'vuex/dist/logger';
import UserModule from '../modules/userModule';
import MediaModule from '../modules/mediaModule';

Vue.use( Vuex );

const plugins = [];

if ( process.env.NODE_ENV !== 'production' ) {
    plugins.push( createLogger() );
}

/**
 * Стандарнтый набор, изучаю...
 **/
const store = new Vuex.Store({
  state: {},
  /**
   * Мутации, Аля Reducer в Redux, служат для обновления состояния приложения от вызова какихто действий
   * PS: мутации какоето неудачное название, удобнее они лиш в дом что ненужен громадный switch
   *       разделил их по группам, чтоб не рос данный файл
   **/
  mutations: {},
  getters: {},
  setters: {},
  actions: {},
  modules: { UserModule, MediaModule },
  plugins
});

/**
 * @return { void|Promise }
 **/
export const dispatch = ({ type, payload }) => store.dispatch( type, payload );

export default store;
