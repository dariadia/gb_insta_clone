import { dispatch } from "../../../store";
import { UPLOAD_NEW_PHOTO } from "../constants";

/**
 * @param { FileList } files
 * @return { function }
 **/
export const uploadPhoto = ( files ) => dispatch({
    type: UPLOAD_NEW_PHOTO, payload: files
});
