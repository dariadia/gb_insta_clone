import { dispatch } from "../../../store";
import { LOGIN_ACTION, LOGOUT_ACTION } from "../constants";

/**
 * @param { string } userName
 * @param { string } password
 * @return { function }
 **/
export const login = ( userName, password ) => dispatch({
  type: LOGIN_ACTION,
  payload: { userName, password}
});

/**
 * @return { function }
 **/
export const logout = () => dispatch({ type: LOGOUT_ACTION });