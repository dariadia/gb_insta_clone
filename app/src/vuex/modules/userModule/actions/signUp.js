import { dispatch } from "../../../store";
import { REGISTER_ACTION } from "../constants";

/**
 * @param { object } formValues  данные с формы регистрации
 * @return { function }
 **/
export const signUp = ( formValues ) => dispatch({
  type: REGISTER_ACTION,
  payload: { formValues }
});
