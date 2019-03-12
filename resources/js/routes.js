import Chamaa from './components/Chamaa/Chamaa'
import ChamaaDetail from "./components/Chamaa/ChamaaDetail";
import ProjectDetail from "./components/Project/ProjectDetail";
import Projects from "./components/Project/Projects";


const routes = [
    {path: '/groups', component: Chamaa},
    {path: '/chamaa-view/:id', name: 'chamaa-view', component: ChamaaDetail, props: true},


    {path: '/projects', component: Projects},
    {path: '/project-view/:id', name: 'project-view', component: ProjectDetail, props: true},

]


export default routes;
