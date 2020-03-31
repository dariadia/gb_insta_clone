import { dispatch } from "../../../store";
import { SET_MEDIA_REQUEST_DATE } from "../constants";

/**
 * @param { string } userLogin
 * @param { int } offset
 * @param { int|null } limit
 * @param { string } sort
 * @return { function }
 **/
export const getMedia = ( userLogin, offset = 0, limit = null, sort = 'id' ) => dispatch({
  type: SET_MEDIA_REQUEST_DATE,
  payload: {
    filter: { 'user_login': userLogin },
    query: {
      sort, page: offset, 'per-page': limit,
    }
  }
});