import Chamaa from './components/Chamaa/Chamaa'
import ChamaaDetail from "./components/Chamaa/ChamaaDetail";


const routes = [
    {path: '/chamaa', component: Chamaa},
    {path: '/chamaa-view/:id', name: 'chamaa-view', component: ChamaaDetail, props: true},
]


export default routes;
