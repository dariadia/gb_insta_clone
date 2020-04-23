import axios from "axios";

const EMPTY_QUERY = '';

export class Api {
  static STATUS_OK = 200;
  static STATUS_DELETED = 204;
  _token = null;

  /**
   * Сеттер для токена, и установка его в заголовки axios
   * @return { this }
   **/
  setToken( token ) {
    this._token = token;
    axios.defaults.headers.common['Authorization'] = `Bearer ${ token }`;
    return this;
  }

  /**
   * Геттер для токена
   * @return { string }
   **/
  getToken() {
    return this._token;
  }

  /**
   * Получение базового URL с переменных окружений
   * @return { string }
   **/
  static getBaseUrl() {
    return process.env.VUE_APP_BACKEND_HOST;
  }

  /**
   * Построение строки GET запросов
   * @param { object } props
   * @return { string }
   **/
  buildQueryParams( props ){
    const entries = Object.entries( props );
    if ( !entries ) {
      return EMPTY_QUERY;
    }
    return entries.reduce( ( acc, [ key, value ], idx) => {
      const symbol = idx ? '&' : '?';
      return  value ?  acc + `${ symbol }${ key }=${ value }` : acc ;
    }, EMPTY_QUERY );
  }

  /**
   * Построение строки GET запросов для yii rest методов
   * @param { object } params
   * @param { array|null } extraFields
   * @return { string }
   *
   * @todo добавить проверки
   **/
  buildYiiQuery( params, extraFields = null ) {
    const { filter, query } = params;
    const rawQueryParams = {
      ...filter,
      expand: extraFields,
      ...query,
    };
    return this.buildQueryParams( rawQueryParams );
  }
  
   /**
    * Функция помощник, парсинга заголовков пагинации, и установка удобных ключей
    * @return { object }
    **/
  static parseHeaders( headers ) {
    return !headers ? {} : {
      currentPage: Number( headers['x-pagination-current-page'] ),
      limit: Number( headers['x-pagination-per-page'] ),
      pagesCount: Number( headers['x-pagination-page-count'] ),
      totalItems: Number( headers['x-pagination-total-count'] ),
    };
  }
}