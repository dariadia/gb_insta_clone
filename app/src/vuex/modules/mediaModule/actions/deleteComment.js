import { dispatch } from "../../../store";
import { DELETE_COMMENT } from "../constants";

/**
 * @param { int } id
 * @return { function }
 **/
export const deleteComment = ( id ) => dispatch({
    type: DELETE_COMMENT, payload: id
});