import { dispatch } from "../../../store";
import { SET_MEDIA_LIKE_INCREMENT } from "../constants";

/**
 * @param { string } mediaID
 * @return { function }
 **/
export const doLike = ( mediaID ) => dispatch({
  type: SET_MEDIA_LIKE_INCREMENT,
  payload: {
      mediaID
  }
});