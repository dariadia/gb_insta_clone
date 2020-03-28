const EMPTY_QUERY = '';

export class Api {
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
      [ `filter[${ filter.key }]` ]: filter.value,
      expand: extraFields,
      ...query,
    };
    return this.buildQueryParams( rawQueryParams );
  }
}