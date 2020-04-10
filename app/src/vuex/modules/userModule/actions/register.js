import { dispatch } from "../../../store";
import { REGISTER_ACTION } from "../constants";

/**
 * @param { object } data  данные с формы регистрации
 * @return { function }
 **/
export const register = ( data ) => dispatch({
  type: REGISTER_ACTION,
  payload: data
});
