import Group from './components/Group/Group'
import GroupDetail from "./components/Group/GroupDetail";
import ProjectDetail from "./components/Project/ProjectDetail";
import Projects from "./components/Project/Projects";
import Wallets from "./components/Wallets/Wallet";
import WalletDetail from "./components/Wallets/WalletDetail";
import User from "./components/Users/User";
import UserDetail from "./components/Users/UserDetail";
import UserLogin from "./components/Users/UserLogin";
import GroupTransaction from "./components/Group/GroupTransaction";
import ProjectTransactions from "./components/Project/ProjectTransactions";


const routes = [
    {path: '/groups', component: Group},
    {path: '/group-view/:id', name: 'group-view', component: GroupDetail, props: true},
    {path: '/group-transactions', name: 'group-transaction', component: GroupTransaction, props: true},


    {path: '/projects', component: Projects},
    {path: '/project-view/:id', name: 'project-view', component: ProjectDetail, props: true},
    {path: '/project-transactions', name: 'project-transactions', component: ProjectTransactions, props: true},

    {path: '/wallets', component: Wallets},
    {path: '/wallet-view/:id', name: 'wallet-view', component: WalletDetail, props: true},


    {path: '/users', component: User},
    {path: '/user-view/:id', name: 'user-view', component: UserDetail, props: true},
    {path: '/authenticate', name: 'user-authenticate', component: UserLogin, props: true},

]


export default routes;
