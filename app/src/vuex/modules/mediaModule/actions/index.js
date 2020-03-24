import { dispatch } from "../../../store";
import { SET_MEDIA_REQUEST_DATE } from "../constants";

/**
 * @param { int } userId
 * @param { int } offset
 * @param { int|null } limit
 * @return { function }
 **/
export const getMedia = ( userId, offset = 0, limit = null ) => dispatch({
  type: SET_MEDIA_REQUEST_DATE,
  payload: { userId, offset, limit }
});