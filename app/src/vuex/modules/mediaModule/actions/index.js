import { dispatch } from "../../../store";
import { SET_MEDIA_REQUEST_DATE } from "../constants";

/**
 * @param { int } userId
 * @param { int } offset
 * @param { int|null } limit
 * @param { string } sort
 * @return { function }
 **/
export const getMedia = ( userId, offset = 0, limit = null, sort = 'id' ) => dispatch({
  type: SET_MEDIA_REQUEST_DATE,
  payload: {
    filter: { key: 'user_id', value: userId },
    query: {
      sort, page: offset, 'per-page': limit,
    }
  }
});