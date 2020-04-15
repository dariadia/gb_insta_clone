import { dispatch } from "../../../store";
import { LOGIN_ACTION } from "../constants";

/**
 * @param { string } username
 * @param { string } password
 * @return { function }
 **/
export const login = ( username, password ) => dispatch({
  type: LOGIN_ACTION,
  payload: { username, password }
});