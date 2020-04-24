import { dispatch } from "../../../store";
import {SET_MEDIA_LIKE_DECREMENT} from "../constants";

/**
 * @param { int } mediaId
 * @return { function }
 **/
export const deleteLike = ( mediaId ) => dispatch({
    type: SET_MEDIA_LIKE_DECREMENT, payload: mediaId
});