import { dispatch } from "../../../store";
import { LOGIN_ACTION, LOGOUT_ACTION } from "../constants";

/**
 * @param { string } username
 * @param { string } password
 * @return { function }
 **/
export const login = ( username, password ) => dispatch({
  type: LOGIN_ACTION,
  payload: { username, password}
});

/**
 * @return { function }
 **/
export const logout = () => dispatch({ type: LOGOUT_ACTION });