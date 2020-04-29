import { dispatch } from "../../../store";
import { ADD_COMMENT_TO_POST } from "../constants";

/**
 * @param { int } mediaId
 * @param { string } comment
 * @return { function }
 **/
export const addComment = ( mediaId, comment ) => dispatch({
    type: ADD_COMMENT_TO_POST, payload: { mediaId, comment }
});