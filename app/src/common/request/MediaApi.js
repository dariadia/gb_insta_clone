import axios from 'axios';
import { Api } from "./Api";

class MediaApi extends Api {
  /**
   * Получение списка медия, по запроосу
   * @param { object<{ userId: number, offset: number, limit: number|null }> } queryParams 
   **/
  getUserMedia( queryParams ) {
    return axios.get(`${ Api.getBaseUrl() }/v1/media/list${ this.buildQueryParams(queryParams) }`)
      .then( ({ data }) => data )
      .catch( error => console.warn( error ) );
  }
}

const mediaApi = new MediaApi();

export { mediaApi };
