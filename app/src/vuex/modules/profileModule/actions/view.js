import { dispatch } from "../../../store";
import { SET_PROFILE_REQUEST_VIEW } from "../constants";

/**
 * @param { string } user_id
 * @return { function }
 **/
export const getProfile = ( user_id ) => dispatch({
    type: SET_PROFILE_REQUEST_VIEW,
    payload: {
        filter: { 'user_id': user_id },
        query: {}
    }
});