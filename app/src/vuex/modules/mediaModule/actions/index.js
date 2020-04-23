import { dispatch } from "../../../store";
import { SET_MEDIA_REQUEST_DATE } from "../constants";

/**
 * @param { string } username
 * @param { int } offset
 * @param { int|null } limit
 * @param { string } sort
 * @return { function }
 **/
export const getMedia = ( username, offset = 0, limit = null, sort = 'id DESC' ) => dispatch({
  type: SET_MEDIA_REQUEST_DATE,
  payload: {
    filter: { 'username': username },
    query: {
      sort, page: offset, 'per-page': limit,
    }
  }
});