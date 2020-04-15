import { dispatch } from "../../../store";
import { INIT } from "../constants";

/**
 * @return { function }
 **/
export const init = () => dispatch({
  type: INIT, payload: {}
});