import Group from './components/Group/Group'
import GroupDetail from "./components/Group/GroupDetail";
import ProjectDetail from "./components/Project/ProjectDetail";
import Projects from "./components/Project/Projects";
import Wallets from "./components/Wallets/Wallet";
import WalletDetail from "./components/Wallets/WalletDetail";


const routes = [
    {path: '/groups', component: Group},
    {path: '/group-view/:id', name: 'group-view', component: GroupDetail, props: true},


    {path: '/projects', component: Projects},
    {path: '/project-view/:id', name: 'project-view', component: ProjectDetail, props: true},

    {path: '/wallets', component: Wallets},
    {path: '/wallet-view/:id', name: 'wallet-view', component: WalletDetail, props: true},

]


export default routes;
