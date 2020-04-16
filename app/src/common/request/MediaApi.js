import axios from 'axios';
import { Api } from "./Api";

class MediaApi extends Api {

  extraFields() {
    return [ 'name', 'username', 'src', 'type', 'comments', 'likes' ];
  }
  /**
   * Получение списка медия, по запроосу
   * @param { object<{ username: string, id: int, offset: number, limit: number|null }> } queryParams
   **/
  getMediaList( queryParams ) {
    return axios.get(`${ Api.getBaseUrl() }v1/media${ this.buildYiiQuery( 
        queryParams, 
        [ 'name', 'username', 'src', 'type', 'likes' ] )}`
    )
      .then( ( res ) => res )
      .catch( error => error.response );
  }

  getMediaItem( queryParams ) {
    return axios.get(`${ Api.getBaseUrl() }v1/media${ this.buildYiiQuery( queryParams, this.extraFields() )}`)
        .then( ( res ) => res )
        .catch( error => error.response );
  }
}
const mediaApi = new MediaApi();

export { mediaApi };
