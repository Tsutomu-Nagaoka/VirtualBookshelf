import Vue from 'vue'
import VueRouter from 'vue-router'

//ページコンポーネントをインポート
import ProductList from './pages/ProductList.vue'
import Login from './pages/Login.vue'
import ProductForm from './pages/ProductForm.vue'
import ProductDetail from './pages/ProductDetail.vue'

import store from './store'
import SystemError from './pages/errors/System.vue'
import NotFound from './pages/errors/NotFound.vue'


//VueRouterプラグインを使用
Vue.use(VueRouter)

//パスとコンポーネントのマッピング
const routes = [
    {
        path: '/',
        component: ProductList,
        props: route => {
            const page = route.query.page
            return {
                page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1
            }
        }
    },
    {
        path: '/login',
        component: Login,
        beforeEnter: (to, from, next) => {
            if(store.getters['auth/check']){
                next('/')
            }else{
                next()
            }
        }
    },
    {
        path: '/ProductForm',
        component: ProductForm,
        beforeEnter: (to, from, next) => {
            if(store.getters['auth/check']){
                next()
            }else{
                next('/')
            }
        }
    },
    {
        path: '/products/:id',
        component: ProductDetail,
        props: true
    },
    {
        path: '/500',
        component: SystemError
    },
    // {
    //     path: '*', // 指定されたルート以外はNotFound
    //     component: NotFound
    // }
]

// VueRouterインスタンスを作成
const router = new VueRouter({
    mode: 'history', //historyモード（URLの＃を消す）
    scrollBehavior() {
        return { x: 0, y: 500}
    },
    routes
})

// app.jsでインポートするために、VurRouterインスタンスをエクスポート
export default router