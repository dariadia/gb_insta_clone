import { SET_MEDIA_REQUEST_DATE } from "./constants";
import { mediaApi } from "../../../common/request/MediaApi";
import { Api } from "../../../common/request/Api";
const { freeze } = Object;

/**
 * @type { object }
 * */
export const mediaInitialState = freeze({
  mediaList: [],
  mediaHeaders: {}
});

export default {
  state: { ...mediaInitialState },
  getters: {
    mediaList: ({ mediaList }) => Array.isArray( mediaList ) ? mediaList : [ mediaList ],
    mediaHeaders: ({ mediaHeaders }) => mediaHeaders,
  },
  setters: {},
  mutations: {
    [ SET_MEDIA_REQUEST_DATE ] : ( state, response ) => {
      const { headers, data } = response || {};
      const mediaList = data || mediaInitialState.mediaList;

      state.mediaList.push( ...mediaList );
      state.mediaHeaders = Api.parseHeaders( headers );
    },
  },
  actions: {
    [ SET_MEDIA_REQUEST_DATE ] : async ({ commit }, payload ) => {
      const response = await mediaApi.getUserMedia( payload );
      commit( SET_MEDIA_REQUEST_DATE, response );
    },
  }
};