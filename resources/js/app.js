import './bootstrap'

import Vue from 'vue'
// ルーティング
import router from './router'
// ルートコンポーネント（コンポーネントツリーの頂上）
import App from './App.vue'
// Vuex
import store from './store'

new Vue({
    el: '#app',
    router, //ルーティングの定義を読み込む
    store, //Vuex
    components: {
        App
    }, //ルートコンポーネントの使用を宣言
    template: '<App />' //ルートコンポーネントの描画
})