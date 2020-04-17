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
      .catch( error =>error.response  );
  }
  /**
   * Действие регистрации ( набросок, будет настраиватся в задаче после )
   * @param { object } data
   * @return { Promise }
   **/
  signUp( data ) {
    return axios.post(`${ Api.getBaseUrl() }v1/auth/signup`, data )
        .then( ( res ) => res )
        .catch( error => error.response )
  }

  /**
   * Действие получение профиля
   * @return { Promise }
   **/
  getProfile() {
    return axios.post(`${ Api.getBaseUrl() }v1/profile/get`)
        .then( ( res ) => res )
        .catch( error => error.response );
  }
}
const userApi = new UserApi();

export { userApi };
