import { Component } from "@angular/core";
import { ColoniasFormComponent } from "./componentes/colonias-form.component";
import { ColoniasListComponent } from "./componentes/colonias-list.component";
import { ColoniaService } from "../../services/colonia-service";

@Component({
    selector: 'app-colonias-page',
    templateUrl: './colonias.page.html',
    styleUrl: './colonias.page.css',
    standalone: true,
    imports: [
        ColoniasFormComponent,
        ColoniasListComponent
    ]
})
export class ColoniasPage {
    refreshFlag = false;

    constructor(private servicio: ColoniaService) {}

    recargar() {
        this.refreshFlag = !this.refreshFlag;
    }
}