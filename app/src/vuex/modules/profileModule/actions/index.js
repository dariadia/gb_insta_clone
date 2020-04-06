import { dispatch } from "../../../store";
import { SET_PROFILE_REQUEST_DATE } from "../constants";

/**
 * @param { int } offset
 * @param { int|null } limit
 * @param { string } sort
 * @return { function }
 **/
export const getProfiles = ( offset = 0, limit = null, sort = 'id' ) => dispatch({
    type: SET_PROFILE_REQUEST_DATE,
    payload: {
        //filter: { 'username': username },
        query: {
            sort, page: offset, 'per-page': limit,
        }
    }
});