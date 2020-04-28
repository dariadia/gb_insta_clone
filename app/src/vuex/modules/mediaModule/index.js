import {
  SET_MEDIA_REQUEST_DATE,
  SET_MEDIA_REQUEST_VIEW,
  SET_MEDIA_REQUEST_LIKE,
  UPLOAD_FILE_TO_SERVER,
  UPLOAD_SUCCESS,
  UPLOAD_ERROR,
  GET_NEW_MEDIA,
  DELETE_POST,
  DELETE_POST_ERROR,
  DELETE_POST_SUCCESS,
  SET_MEDIA_LIKE_INCREMENT,
  SET_MEDIA_LIKE_DECREMENT
} from "./constants";
import { mediaApi } from "../../../common/request/MediaApi";
import { likeApi } from "../../../common/request/LikeApi";
import { Api } from "../../../common/request/Api";
import { getMedia } from "./actions/view";
const { freeze } = Object;

/**
 * @type { object }
 * */
export const mediaInitialState = freeze({
  mediaList: [],
  mediaItem: {},
  mediaHeaders: {},
  mediaLikes: [],
  errors: [],
  mediaPath: process.env.VUE_APP_STATIC_HOST + 'media/'
});

export default {
  state: { ...mediaInitialState },
  getters: {
    mediaList: ({ mediaList }) => mediaList,
    mediaItem: ({ mediaItem }) => mediaItem,
    mediaHeaders: ({ mediaHeaders }) => mediaHeaders,
    mediaLikes: ({ mediaLikes }) => mediaLikes,
    mediaCount: ({ mediaHeaders }) => mediaHeaders.totalItems || 0,
    mediaPath: ({ mediaPath }) => mediaPath,
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
    [ SET_MEDIA_REQUEST_LIKE ] : ( state, response ) => {
        const { headers, data } = response || {};

        state.mediaLikes = data.length ? data[data.length - 1] : mediaInitialState.mediaLikes;
        state.mediaHeaders = Api.parseHeaders( headers );
    },
    [ UPLOAD_SUCCESS ]: ( state, data ) => {
      state.mediaList.unshift( ...data )
      state.mediaHeaders.totalItems++;
    },
    [ UPLOAD_ERROR ]: ( state, error ) => state.errors.push( error ),
    [ DELETE_POST_SUCCESS ] : ( state, postId ) => {
      state.mediaList = state.mediaList.filter( ({ id }) => id !== postId );
    },
    [ DELETE_POST_ERROR ] : ( state, data ) => state.errors.push( data ),
    [ SET_MEDIA_LIKE_INCREMENT ] : ( state, response ) => {
      const { headers, data } = response || {};
      if (data) state.mediaItem.likes++;
      state.mediaHeaders = Api.parseHeaders( headers );
    },
    [ SET_MEDIA_LIKE_DECREMENT ] : ( state, response ) => {
      const { headers, data } = response || {};
      if (data) state.mediaItem.likes--;
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
    [ SET_MEDIA_REQUEST_LIKE ] : async ({ commit }, payload ) => {
        const response = await mediaApi.getMediaLikes( payload );
        commit( SET_MEDIA_REQUEST_LIKE, response );
    },
    [ UPLOAD_FILE_TO_SERVER ] : async ({ commit }, payload ) => {
      const { status, data } = await mediaApi.uploadPost( payload );
      if ( status === Api.STATUS_OK ) {
        return await getMedia( data, GET_NEW_MEDIA );
      }
      return commit( UPLOAD_ERROR, data );
    },
    [ GET_NEW_MEDIA ] : async ({ commit }, payload ) => {
      const { status, data } = await mediaApi.getMediaItem( payload );
      if ( status === Api.STATUS_OK ) {
        return commit( UPLOAD_SUCCESS, data )
      }
      return commit( UPLOAD_ERROR, data );
    },
    [ DELETE_POST ] : async ({ commit }, payload ) => {
      const { status, data } = await mediaApi.deletePost( payload );
      if ( status === Api.STATUS_DELETED ) {
        return commit( DELETE_POST_SUCCESS, payload );
      }
      return commit( DELETE_POST_ERROR, data );
    },
    [ SET_MEDIA_LIKE_INCREMENT ] : async ({ commit }, payload ) => {
      const response = await likeApi.doLike( payload );
      commit( SET_MEDIA_LIKE_INCREMENT, response );
    },
    [ SET_MEDIA_LIKE_DECREMENT ] : async ({ commit }, payload ) => {
      const response = await likeApi.deleteLike( payload );
      commit( SET_MEDIA_LIKE_DECREMENT, response );
    },
  }
};