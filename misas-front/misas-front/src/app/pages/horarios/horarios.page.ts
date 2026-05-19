import { Component } from "@angular/core";
import { HorariosFormComponent } from "./componentes/hotarios-form.component";
import { HorarioService } from "../../services/horarioService";
import { HorariosListComponent } from "./componentes/horarios-list.component";

@Component({
    selector: 'app-horarios-page',
    templateUrl: './horarios.page.html',
    styleUrl: './horarios.page.css',
    standalone: true,
    imports: [HorariosFormComponent,
        HorariosListComponent
    ]
})
export class HorariosPage {
    refreshFlag = false;

    horarioSeleccionado: any | null = null;

    constructor(private servicio: HorarioService) {}
    recargar() {
        this.refreshFlag = !this.refreshFlag;
    }

    editarHorario(horario: any) {
        this.horarioSeleccionado = horario;
    }
}