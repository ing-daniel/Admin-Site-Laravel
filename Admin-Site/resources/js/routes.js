import Vue from 'vue';
import Router from 'vue-router';
import lista_personas from './components/ListadoComponent';
import formulario from './components/FormularioComponent';
import error from './views/404';

Vue.use(Router);

export default new Router({
	routes: [
		{
			path: '/',
			component: lista_personas
        },
		{
			path: '/persona',
			name: 'formulario',
			component: formulario,
			props: true
		},
		{
			path: '*',
			component: error
		}
	],
	
	scrollBehavior() {
		return {x:0, y:0}
	}
})