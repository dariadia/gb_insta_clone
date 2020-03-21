import { FETCH_MEDIA } from "./constants";
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
    [ FETCH_MEDIA ] : async ({ commit }) => {
      const mediaList = /* await */ [ 1,2,3,4 ];
      commit( FETCH_MEDIA, { mediaList });
    },
  }
};