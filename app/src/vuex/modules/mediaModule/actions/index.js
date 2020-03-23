import { dispatch } from "../../../store";
import { FETCH_MEDIA } from "../constants";

/**
 * @param { int } userId
 * @param { int } offset
 * @param { int|null } limit
 * @return { function }
 **/
export const getMedia = ( userId, offset = 0, limit = null ) => dispatch({
  type: FETCH_MEDIA,
  payload: { userId, offset, limit }
});