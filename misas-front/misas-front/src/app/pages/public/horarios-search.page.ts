import { Component } from "@angular/core";
import { HorariosSearchFormComponent } from "../horarios/componentes/horarios-search-form.component";
import { HorarioService } from "../../services/horarioService";

@Component({
    selector: 'app-horarios-search-page',
    templateUrl: './horarios-search.page.html',
    styleUrl: './horarios-search.page.css',
    standalone: true,
    imports: [
        HorariosSearchFormComponent
    ]
})

export class HorariosSearchPage {
    refreshFlag = false;
    
    constructor(private servicio:HorarioService) {}

    recargar() {
        this.refreshFlag = !this.refreshFlag;
    }
}