import {userApi} from "../request/UserApi";

/**
 * Примерно так кешировать можно самые повторяемые функции
 * 1 - Обзываем по действию
 * 2 - передаем функцию, замокав входящий параметр
 * 3 - Експортируем где нужно, и вызываем memoSearch( ///какието параметры, они передадутся в params )
 * радуемся уменьшению запросов!
 *
 * Функции еще тестируются,
 * поэтому о всех пролблемах сразу писать этому человеку => https://github.com/Cheefs в whatsUpp, или в телеграмм https://t.me/schfst
 **/
export const memoSearch = memo( ( params ) => userApi.search( params ));

/**
 * Функция мемоизации
 * !ВНИМАНИЕ! Дананя функция еще 100% не обкатана, и немогу гарантировать что все функции будут нормально кешироватся
 *            Также кеширование работает до перезагрузки скриптов ( перезагрузки страници )
 * В поиске это критично, поэтому сделал ее
 * @param { Function } fn
 * @return { Function }
 *
 * @example Пример вызова функции, создаем переменную, и замыкаем то что хотим вызвать
 *          const memoSearch = memo( ( params ) => userApi.search( params ) );
 **/
export function memo( fn ) {
    const memoCache = {};
    return function () {
        const key = JSON.stringify( arguments );
        let value = memoCache[ key ] || null;
        if ( !value ) {
            value = fn.apply( null, arguments );
            memoCache[ key ] = value;
        }
        return value;
    }
}
