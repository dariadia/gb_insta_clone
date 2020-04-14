import { dispatch } from "../../../store";
import { GET_PROFILE } from "../constants";

/**
 * Получение профиля пользователя
 * @return { function }
 **/
export const getProfile = () => dispatch({
  type: GET_PROFILE, payload: {}
});