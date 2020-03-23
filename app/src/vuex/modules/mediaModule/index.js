import { FETCH_MEDIA } from "./constants";
import { mediaApi } from "../../../common/request/MediaApi";
const { freeze } = Object;

/**
 * @type { object }
 * */
export const mediaInitialState = freeze({
  mediaList: []
});

export default {
  state: { ...mediaInitialState },
  getters: { mediaList: ({ mediaList }) => mediaList },
  setters: {},
  mutations: {
    [ FETCH_MEDIA ] : ( state, { mediaList } ) => state.mediaList = mediaList,
  },
  actions: {
    [ FETCH_MEDIA ] : async ({ commit }, payload ) => {
      const mediaList = await mediaApi.getUserMedia( payload );
      commit( FETCH_MEDIA, { mediaList });
    },
  }
};