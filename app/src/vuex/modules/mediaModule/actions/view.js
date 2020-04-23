import { dispatch } from "../../../store";
import { SET_MEDIA_REQUEST_VIEW } from "../constants";

/**
 * @param { string } id
 * @param { string } type
 * @return { function }
 **/
export const getMedia = ( id, type = SET_MEDIA_REQUEST_VIEW ) => dispatch({
    type: type,
    payload: {
        filter: { 'id': id },
        query: {}
    }
});