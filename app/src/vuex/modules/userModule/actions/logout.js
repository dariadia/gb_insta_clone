import { dispatch } from "../../../store";
import { LOGOUT_ACTION } from "../constants";

/**
 * @return { function }
 **/
export const logout = () => dispatch({ type: LOGOUT_ACTION });
