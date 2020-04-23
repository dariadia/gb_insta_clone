module.exports = {
    pages: {
        index: {
            entry: 'src/main.js',
            template: 'public/index.html',
            filename: 'index.html',
            title: 'GeekGram',
        },
    },
    /**
     * отключить эти найстройки, чтоб не перезагружалась страница
     * если мы заливаем файл ( vue-cli считает это изменением и обновляет все )
     * мне при тестировании добавление поста, приходилось отключать, чтоб не не перезагружала страницу
     **/
    devServer: {
        hot: true, liveReload: true
    }
}