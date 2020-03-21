import { dispatch } from "../../../store";
import { FETCH_MEDIA } from "../constants";

/**
 * @return { function }
 **/
export const getMedia = () => dispatch({ type: FETCH_MEDIA });