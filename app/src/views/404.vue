<template>
    <div class="container">
        <div class="page-not-found">
            <h3>404</h3>
            <p>Страница не найдена</p>
            <router-link :to="{name: 'Home'}" class="link__404">На главную</router-link>
        </div>
    </div>
</template>

<style lang="scss">
    .page-not-found {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;

        & > h3 {
            margin-top: 30px;
            margin-bottom: 10px;
            font-family: Tahoma, sans-serif;
            font-size: 120px;
            color: #525252;
        }

        & > p {
            font-style: italic;
            font-size: 20px;
        }
    }

    .link__404 {
        width: 120px;
        padding-bottom: 3px;
        display: inline-block;
        text-align: center;
        font-size: 16px;
        color: #3079b4;
        text-decoration: none;
        border: 1px solid transparent;
        transition: border .25s ease-in-out;

        &:hover {
            border-bottom: 1px solid #3079b4;
        }
    }
</style>