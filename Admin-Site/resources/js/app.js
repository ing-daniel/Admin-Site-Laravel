import { 
    Table, 
    Icon,
    Button,
    Input,
    Dropdown,
    Menu,
    Form,
    DatePicker,
    Layout,
    Popconfirm,
    Divider,
    Avatar,
    message,
    notification,
    Spin
} from 'ant-design-vue';
require('./bootstrap');


window.Vue = require('vue');

Vue.component('app-component', require('./components/AppComponent').default);
Vue .use(Table)
    .use(Icon)
    .use(Button)
    .use(Input)
    .use(Dropdown)
    .use(Menu)
    .use(Form)
    .use(DatePicker)
    .use(Layout)
    .use(Popconfirm)
    .use(Divider)
    .use(Avatar)
    .use(message)
    .use(notification)
    .use(Spin);
    
Vue.prototype.$message = message ;  

import router from './routes';

const app = new Vue({
    el: '#app',
    router
});
