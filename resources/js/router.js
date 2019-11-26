import Vue from 'vue'
import VueRouter from 'vue-router'

//ページコンポーネントをインポート
import ProductList from './pages/ProductList.vue'
import Login from './pages/Login.vue'


//VueRouterプラグインを使用
Vue.use(VueRouter)

//パスとコンポーネントのマッピング
const routes = [
    {
        path: '/',
        component: ProductList
    },
    {
        path: '/login',
        component: Login
    }
]

// VueRouterインスタンスを作成
const router = new VueRouter({
    mode: 'history', //historyモード（URLの＃を消す）
    routes
})

// app.jsでインポートするために、VurRouterインスタンスをエクスポート
export default router