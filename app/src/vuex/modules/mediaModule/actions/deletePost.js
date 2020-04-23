import { dispatch } from "../../../store";
import { DELETE_POST } from "../constants";

/**
 * @param { int } id
 * @return { function }
 **/
export const deletePost = ( id ) => dispatch({
    type: DELETE_POST, payload: id
});
