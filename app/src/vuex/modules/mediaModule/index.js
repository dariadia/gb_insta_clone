import { SET_MEDIA_REQUEST_DATE } from "./constants";
import { mediaApi } from "../../../common/request/MediaApi";
const { freeze } = Object;

/**
 * @type { object }
 * */
export const mediaInitialState = freeze({
  mediaList: [],
  mediaHeaders: []
});

export default {
  state: { ...mediaInitialState },
  getters: {
    mediaList: ({ mediaList }) => Array.isArray( mediaList ) ? mediaList : [ mediaList ]
  },
  setters: {},
  mutations: {
    [ SET_MEDIA_REQUEST_DATE ] : ( state, response ) => {
      const { headers, data } = response;
      state.mediaList = data || mediaInitialState.mediaList;
      /** @todo расспарсить */
      state. mediaHeaders = headers;
    },
  },
  actions: {
    [ SET_MEDIA_REQUEST_DATE ] : async ({ commit }, payload ) => {
      const response = await mediaApi.getUserMedia( payload );
      commit( SET_MEDIA_REQUEST_DATE, response );
    },
  }
};