import axios from 'axios';
import { Api } from "./Api";

class ProfileApi extends Api {

    basePath = `${ Api.getBaseUrl() }v1/profile`;

    extraFields() {
        // return [ 'username' ];
    }
    /**
     * Получение списка профилей, по запроосу
     * @param { object<{ offset: number, limit: number|null }> } queryParams
     **/
    getProfilesList( queryParams ) {
        return axios.get(`${ this.basePath }${ this.buildYiiQuery(
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
        return axios.get(`${ this.basePath }${ this.buildYiiQuery( queryParams, this.extraFields() )}`)
            .then( ( res ) => res )
            .catch( error => error.response );
    }

    /**
     * Действие получение профиля по заголовку auth_token
     * @return { Promise }
     **/
    getProfileByAuthToken() {
        return axios.get(`${ this.basePath }/get`)
            .then( ( res ) => res )
            .catch( error => error.response );
    }

    /**
     * @return { Promise }
     **/
    uploadNewPhoto( files ) {
        const formData = new FormData();
        formData.append('file', files[ 0 ] );

        return axios.post(`${ this.basePath }/upload-photo`, formData, {
            headers: { 'Content-Type': `multipart/form-data` },
        })
            .then( ( res ) => res )
            .catch( error => error.response );
    }

    /**
     * @param { object } data
     * @return { Promise }
     **/
    updateUserProfile( data ) {
        return axios.post(`${ this.basePath }/update-profile`, data )
            .then( ( res ) => res )
            .catch( error => error.response );
    }
}
const profileApi = new ProfileApi();

export { profileApi };
