import { Component } from "@angular/core";
import { LocacionesListComponent } from "./componentes/locaciones-list.component";
import { LocacionesFormComponent } from "./componentes/locaciones-form.component";
import { LocationService } from "../../services/locationService";

@Component({
    selector: 'app-locaciones-page',
    templateUrl: './locaciones.page.html',
    styleUrl: './locaciones.page.css',
    standalone: true,
    imports: [
        LocacionesListComponent,
        LocacionesFormComponent
    ]
})
export class Locacionespage {
    refreshFlag = false;

    constructor(private servicio: LocationService) {}
    
    recargar() {
        this.refreshFlag = !this.refreshFlag;
    }
}