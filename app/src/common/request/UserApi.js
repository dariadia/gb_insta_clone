import axios from 'axios';
import { Api } from "./Api";

/**
 * Класс для работы с пользователями
 **/
class UserApi extends Api {

  /**
   * Действие регистрации ( набросок, будет настраиватся в задаче после )
   * @param { object } data
   * @return { Promise }
   **/
  register( data ) {
    return axios.post(`${ Api.getBaseUrl() }v1/auth`, data )
        .then( ( res ) => res )
        .catch( error => console.warn( error ) );
  }
}
const userApi = new UserApi();

export { userApi };
