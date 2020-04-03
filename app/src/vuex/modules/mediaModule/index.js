import { SET_MEDIA_REQUEST_DATE, SET_MEDIA_REQUEST_VIEW } from "./constants";
import { mediaApi } from "../../../common/request/MediaApi";
import { Api } from "../../../common/request/Api";
const { freeze } = Object;

/**
 * @type { object }
 * */
export const mediaInitialState = freeze({
  mediaList: [],
  mediaItem: [],
  mediaHeaders: []
});

export default {
  state: { ...mediaInitialState },
  getters: {
    mediaList: ({ mediaList }) => Array.isArray( mediaList ) ? mediaList : [ mediaList ],
    mediaHeaders: ({ mediaHeaders }) => mediaHeaders,  },
  setters: {},
  mutations: {
    [ SET_MEDIA_REQUEST_DATE ] : ( state, response ) => {
      const { headers, data } = response || {};
      const mediaList = data || mediaInitialState.mediaList;

      state.mediaList.push( ...mediaList );
      state.mediaHeaders = Api.parseHeaders( headers );
    },
    [ SET_MEDIA_REQUEST_VIEW ] : ( state, response ) => {
      const { headers, data } = response;
      state.mediaItem = data || mediaInitialState.mediaItem;
      /** @todo расспарсить */
      state. mediaHeaders = headers;
    },
  },
  actions: {
    [ SET_MEDIA_REQUEST_DATE ] : async ({ commit }, payload ) => {
      const response = await mediaApi.getMediaList( payload );
      commit( SET_MEDIA_REQUEST_DATE, response );
    },
    [ SET_MEDIA_REQUEST_VIEW ] : async ({ commit }, payload ) => {
      const response = await mediaApi.getMediaItem( payload );
      commit( SET_MEDIA_REQUEST_VIEW, response );
    },
  }
};