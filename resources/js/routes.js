import Group from './components/Group/Group'
import GroupDetail from "./components/Group/GroupDetail";
import ProjectDetail from "./components/Project/ProjectDetail";
import Projects from "./components/Project/Projects";


const routes = [
    {path: '/groups', component: Group},
    {path: '/group-view/:id', name: 'group-view', component: GroupDetail, props: true},


    {path: '/projects', component: Projects},
    {path: '/project-view/:id', name: 'project-view', component: ProjectDetail, props: true},

]


export default routes;
