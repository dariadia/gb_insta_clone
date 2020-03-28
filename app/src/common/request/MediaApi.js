import axios from 'axios';
import { Api } from "./Api";

class MediaApi extends Api {

  extraFields() {
    return [ 'username', 'src', 'type', 'comments', 'likes' ];
  }
  /**
   * Получение списка медия, по запроосу
   * @param { object<{ userId: number, offset: number, limit: number|null }> } queryParams 
   **/
  getUserMedia( queryParams ) {
    return axios.get(`${ Api.getBaseUrl() }v1/media${ this.buildYiiQuery( queryParams, this.extraFields() )}`)
      .then( ( res ) => res )
      .catch( error => console.warn( error ) );
  }
}
const mediaApi = new MediaApi();

export { mediaApi };
