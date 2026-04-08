import { Component } from "@angular/core";
import { CiudadesFormComponent } from "./componentes/ciudades-form.component";
import { CiudadService } from "../../services/ciudad-service";
import { CiudadesListComponent } from "./componentes/ciudades-list.component";

@Component({
    selector: 'app-ciudades-page',
    templateUrl: './ciudades.page.html',
    styleUrl: './ciudades.page.css',
    standalone: true,
    imports: [
        CiudadesFormComponent,
        CiudadesListComponent
    ]
})
export class CiudadesPage {
    refreshFlag = false;

    constructor(private servicio: CiudadService) {}

    recargar() {
        this.refreshFlag = !this.refreshFlag;
    }
}