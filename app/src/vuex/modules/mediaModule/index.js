import { SET_MEDIA_REQUEST_DATE, SET_MEDIA_REQUEST_VIEW } from "./constants";
import { mediaApi } from "../../../common/request/MediaApi";
import { Api } from "../../../common/request/Api";
const { freeze } = Object;

/**
 * @type { object }
 * */
export const mediaInitialState = freeze({
  mediaList: [],
  mediaItem: {},
  mediaHeaders: []
});

export default {
  state: { ...mediaInitialState },
  getters: {
    mediaList: ({ mediaList }) => mediaList,
    mediaItem: ({ mediaItem }) => mediaItem,
    mediaHeaders: ({ mediaHeaders }) => mediaHeaders,
    },
  setters: {},
  mutations: {
    [ SET_MEDIA_REQUEST_DATE ] : ( state, response ) => {
      const { headers, data } = response || {};
      const mediaList = data || mediaInitialState.mediaList;

      state.mediaHeaders = Api.parseHeaders( headers );

      const currentPage = state.mediaHeaders.currentPage;

      /** если страница 1 обнуляем лист, чтоб небыло дублей */
      if ( currentPage === 1 ) {
        state.mediaList = mediaList;
      } else {
        state.mediaList.push( ...mediaList );
      }
    },
    [ SET_MEDIA_REQUEST_VIEW ] : ( state, response ) => {
      const { headers, data } = response || {};

      state.mediaItem = data.length ? data[data.length - 1] : mediaInitialState.mediaItem;
      state.mediaHeaders = Api.parseHeaders( headers );
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