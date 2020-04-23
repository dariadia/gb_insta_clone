import axios from 'axios';
import { Api } from "./Api";

class MediaApi extends Api {

    extraFields() {
        return [ 'name', 'username', 'src', 'type', 'comments', 'likes', 'like'];
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

    getMediaLikes( queryParams ) {
        return axios.get(`${ Api.getBaseUrl() }v1/media${ this.buildYiiQuery(
            queryParams,
            [ 'usersLikeIt' ] )}`
        )
            .then( ( res ) => res )
            .catch( error => error.response );
    }

    /**
     * Загрузка файла на сервер
     * @param { FileList } files
     * @return { Promise }
     **/
    uploadPost( files ) {
        const formData = new FormData();
        formData.append('file', files[ 0 ] );

        return axios.post(`${ Api.getBaseUrl() }v1/media`, formData, {
            headers: { 'Content-Type': `multipart/form-data` },
        })
        .then( ( res ) => res )
        .catch( error => error.response );
    }
}
const mediaApi = new MediaApi();

export { mediaApi };
