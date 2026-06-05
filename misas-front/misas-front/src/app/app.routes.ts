import { Routes } from '@angular/router';

export const routes: Routes = [
    {
        path: '',
        loadComponent: () => import('./pages/public/horarios-search.page').then(m => m.HorariosSearchPage)
    },
    {
        path: 'login',
        loadComponent: () => import('./pages/admin/componentes/login-form').then(m => m.LoginFormComponent)
    },
    {
        path: 'admin',
        loadComponent: () => import('./pages/admin/admin.page').then(m => m.AdminPage)
    },
    {
        path: 'admin/tipos-locacion',
        loadComponent: () => import('./pages/tiposLocacion/tiposLocacion.page').then(m => m.TiposLocacionPage)
    },
    {
        path: 'admin/ciudades',
        loadComponent: () => import('./pages/ciudades/ciudades.page').then(m => m.CiudadesPage)
    },
    {
        path: 'admin/colonias',
        loadComponent: () => import('./pages/colonias/colonias.page').then(m => m.ColoniasPage)
    },
    {
        path: 'admin/horarios',
        loadComponent: () => import('./pages/horarios/horarios.page').then(m => m.HorariosPage)
    },
    {
        path: 'admin/locaciones',
        loadComponent: () => import('./pages/locaciones/locaciones.page').then(m => m.Locacionespage)
    }
];
