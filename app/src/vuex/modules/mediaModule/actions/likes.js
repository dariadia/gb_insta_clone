import { dispatch } from "../../../store";
import { SET_MEDIA_REQUEST_LIKE } from "../constants";

/**
 * @param { string } id
 * @return { function }
 **/
export const getMedia = ( id ) => dispatch({
    type: SET_MEDIA_REQUEST_LIKE,
    payload: {
        filter: { 'id': id },
        query: {}
    }
});