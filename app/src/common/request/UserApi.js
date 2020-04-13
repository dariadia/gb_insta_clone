import axios from 'axios';
import { Api } from "./Api";

/**
 * Класс для работы с пользователями
 **/
class UserApi extends Api {

  /**
   * Действие авторизации
   * @param { string } username
   * @param { string } password
   * @return { Promise }
   **/
  login( username, password ) {
    const base64String = btoa(`${ username }:${ password }`);
    const requestBody = {  auth: base64String };

    return axios.post(`${ Api.getBaseUrl() }v1/auth/login`, requestBody )
      .then( ( res ) => res )
      .catch( error => console.warn( error ) );
  }
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
