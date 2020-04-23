import { dispatch } from "../../../store";
import { UPLOAD_FILE_TO_SERVER } from "../constants";

/**
 * @param { FileList } files
 * @return { function }
 **/
export const upload = ( files ) => dispatch({
    type: UPLOAD_FILE_TO_SERVER, payload: files
});
