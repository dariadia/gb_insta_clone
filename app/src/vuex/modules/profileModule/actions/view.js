import { dispatch } from "../../../store";
import { SET_PROFILE_REQUEST_VIEW } from "../constants";

/**
 * @param { string } username
 * @return { function }
 **/
export const getProfile = ( username ) => dispatch({
    type: SET_PROFILE_REQUEST_VIEW,
    payload: {
        filter: { 'username': username },
        query: {}
    }
});