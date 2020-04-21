import { dispatch } from "../../../store";
import { SEARCH_QUERY_CHANGE } from "../constants";


/**
 * @param { string } searchString
 * @return { function }
 **/
export const searchChange = ( searchString ) => dispatch({
  type: SEARCH_QUERY_CHANGE,
  payload: { searchString }
});