
/** @todo Доработать как базовый валидатор, и начать использовать в логине и регистрации
 * @param { any } value
 * @param { object } rules
 * @return { boolean }
 **/
export const doValidateByRules = ( value, rules ) => {

    if ( !rules || !Object.keys( rules ).length ) {
        return true;
    }
   return Object.entries( rules ).every( ([ rule, expect ]) => {
        switch ( rule ) {
            case 'required': {
                return expect ? Boolean(value && value.trim() ) : true;
            }
            default: {
                return true;
            }
        }
    });
};
