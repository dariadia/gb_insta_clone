import { dispatch } from "../../../store";
import { UPDATE_PROFILE } from "../constants";

/**
 * @param { int } id
 * @param { object } data
 * @return { function }
 **/
export const updateProfile = ( id, data ) => dispatch({
    type: UPDATE_PROFILE, payload: { id, ...data }
});
