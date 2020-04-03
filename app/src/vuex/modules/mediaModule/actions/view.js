import { dispatch } from "../../../store";
import { SET_MEDIA_REQUEST_VIEW } from "../constants";

/**
 * @param { string } id
 * @return { function }
 **/
export const getMediaItem = ( id ) => dispatch({
    type: SET_MEDIA_REQUEST_VIEW,
    payload: {
        filter: { 'id': id },
        query: {}
    }
});