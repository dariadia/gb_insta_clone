import Vue from "vue";
import Vuex from "vuex";
import createLogger from 'vuex/dist/logger';
import UserModule from '../modules/userModule';
import MediaModule from '../modules/mediaModule';
import ProfileModule from '../modules/profileModule';
import SearchModule from '../modules/searchModule';
import SubscriptionsModule from '../modules/subscriptionsModule';

Vue.use( Vuex );

/** Список плагинов приложения */
const plugins = [];

/** Подключаем все что нужно для разработки **/
if ( process.env.NODE_ENV !== 'production' ) {
    plugins.push( createLogger() );
}

const mainInitialState = Object.freeze({
    staticPath: process.env.VUE_APP_STATIC_HOST
});

/**
 * Состояние всего приложения, так как скорее всего разработка будет модульной, станарные ключи были убранны
 * @type { object } Vuex.Store
 **/
const store = new Vuex.Store({
  state: { ...mainInitialState },
  getters: {
      staticPath: ({ staticPath } ) => staticPath
  },
  modules: {
      UserModule, MediaModule, ProfileModule, SearchModule,
      SubscriptionsModule
  },
  plugins
});

/**
 * Метод для вызова действий конкретного модуля ( или просто действия в store )
 * Используется в actions, чтоб не тянуть за собой store, а инициировать лиш аргументами
 * @param { object<{ type: string, payload: object }> } action
 * @return { Promise }
 **/
export const dispatch = ( action ) => {
  const { type, payload } = action;
  return store.dispatch( type, payload );
};

export default store;
