import axios from 'axios';
import { Api } from "./Api";

class CommentApi extends Api {

    addComment( data ) {
        return axios.post(`${ Api.getBaseUrl() }v1/comment`, data )
            .then( ( res ) => res )
            .catch( error => error.response );
    }

    deleteComment( commentId ) {
        return axios.delete(`${ Api.getBaseUrl() }v1/comment/${ commentId }`)
            .then( ( res ) => res )
            .catch( error => error.response );
    }

}
const commentApi = new CommentApi();

export { commentApi };
