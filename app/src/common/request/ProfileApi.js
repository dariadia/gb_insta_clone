import axios from 'axios';
import { Api } from "./Api";

class ProfileApi extends Api {

    extraFields() {
        // return [ 'username' ];
    }
    /**
     * Получение списка профилей, по запроосу
     * @param { object<{ offset: number, limit: number|null }> } queryParams
     **/
    getProfilesList( queryParams ) {
        return axios.get(`${ Api.getBaseUrl() }v1/profile${ this.buildYiiQuery(
            queryParams,
            this.extraFields() )}`
        )
            .then( ( res ) => res )
            .catch( error => error.response );
    }

    /**
     * Получение профиля, по запроосу
     * @param { object<{username:string, offset: number, limit: number|null }> } queryParams
     **/
    getProfileItem( queryParams ) {
        return axios.get(`${ Api.getBaseUrl() }v1/profile${ this.buildYiiQuery( queryParams, this.extraFields() )}`)
            .then( ( res ) => res )
            .catch( error => error.response );
    }

    /**
     * Действие получение профиля по заголовку auth_token
     * @return { Promise }
     **/
    getProfileByAuthToken() {
        return axios.get(`${ Api.getBaseUrl() }v1/profile/get`)
            .then( ( res ) => res )
            .catch( error => error.response );
    }
}
const profileApi = new ProfileApi();

export { profileApi };
