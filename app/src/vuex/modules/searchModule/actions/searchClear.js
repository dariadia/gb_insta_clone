import { dispatch } from "../../../store";
import { CLEAR_SEARCH_STRING } from "../constants";

/**
 * @return { function }
 **/
export const searchClear = () => dispatch({
  type: CLEAR_SEARCH_STRING,
  payload: {}
});