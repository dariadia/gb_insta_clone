import { dispatch } from "../../../store";
import { SUBSCRIBE } from "../constants";

/**
 * Действие подписатся
 * @param { number } userId
 * @return { function }
 **/
export const subscribe = ( userId ) => dispatch({
  type: SUBSCRIBE,
  payload: { userId }
});