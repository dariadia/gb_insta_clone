import { dispatch } from "../../../store";
import { GET_PROFILE } from "../constants";

/**
 * Получение профиля пользователя
 * @todo сделать общим параметром токен, не тянуть его через действия
 * @param { string } token
 * @return { function }
 **/
export const getProfile = ( token ) => dispatch({
  type: GET_PROFILE, payload: { token }
});