import axios from 'axios';
import { Api } from "./Api";

class LikeApi extends Api {

    extraFields() {
        return [];
    }


    doLike( mediaID ) {
        return axios.post(`${ Api.getBaseUrl() }v1/like`, mediaID)
            .then( ( res ) => res )
            .catch( error => error.response );
    }

    deleteLike( mediaID ) {
        return axios.delete(`${ Api.getBaseUrl() }v1/like/${ mediaID }`)
            .then( ( res ) => res )
            .catch( error => error.response );
    }

}
const likeApi = new LikeApi();

export { likeApi };
