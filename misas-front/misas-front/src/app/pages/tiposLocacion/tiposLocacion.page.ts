import { Component } from "@angular/core";
import { TiposLocacionListComponent } from "./componentes/tiposLocacion-list.component";
import { TipoLocacionService } from "../../services/tipo-locacion-service";
import { TiposLocacionFormComponent } from "./componentes/tiposLocacion-form.component";

@Component({
    selector: 'app-tipos-locacion-page',
    templateUrl: './tiposLocacion.page.html',
    styleUrl: './tiposLocacion.page.css',
    standalone: true,
    imports: [
        TiposLocacionFormComponent,
        TiposLocacionListComponent
    ]
})
export class TiposLocacionPage {
    refreshFlag = false;

    tipoLocacionSeleccionado: any | null = null;

    constructor(private servicio: TipoLocacionService) {}

    recargar() {
        this.refreshFlag = !this.refreshFlag;
    }

    editarTipoLocacion(tipoLocacion: any) {
        this.tipoLocacionSeleccionado = tipoLocacion;
    }
}