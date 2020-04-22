import { dispatch } from "../../../store";
import { GET_SEARCHED_DATA } from "../constants";

/**
 * @param { string } searchQuery
 * @return { function }
 **/
export const getSearchedData = ( searchQuery ) => dispatch({
    type: GET_SEARCHED_DATA, payload: { searchQuery }
});