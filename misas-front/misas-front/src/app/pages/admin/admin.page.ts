import { Component } from "@angular/core";
import { TiposLocacionPage } from "../tiposLocacion/tiposLocacion.page";
import { Locacionespage } from "../locaciones/locaciones.page";
import { ColoniasPage } from "../colonias/colonias.page";
import { CiudadesPage } from "../ciudades/ciudades.page";
import { HorariosPage } from "../horarios/horarios.page";
import { Router } from "@angular/router";

@Component({
    selector: 'app-admin-page',
    templateUrl: './admin.page.html',
    styleUrl: './admin.page.css',
    standalone: true,
    imports: [TiposLocacionPage,
    Locacionespage,
    ColoniasPage,
    CiudadesPage,
    HorariosPage
]
})
export class AdminPage {

    constructor(private router: Router) {}

    navigateTo(path: string) {
        this.router.navigate(['/admin', path]);
    }
}

