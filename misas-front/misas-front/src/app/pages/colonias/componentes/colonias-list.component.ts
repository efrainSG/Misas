import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, Input, OnChanges, OnInit } from "@angular/core";
import { ColoniaService } from "../../../services/colonia-service";

@Component({
    selector: 'app-colonias-list-component',
    templateUrl: './colonias-list.component.html',
    styleUrl: './colonias-list.component.css',
    standalone: true,
    imports: [CommonModule]
})

export class ColoniasListComponent implements OnInit, OnChanges {
    colonias: any;
    @Input() refreshFlag: boolean = false;

    constructor(
        private servicio: ColoniaService,
        private cdr: ChangeDetectorRef
    ) {}

    ngOnInit(): void {
        this.cargar();
    }

    ngOnChanges(): void {
        this.cargar();
    }
    
    cargar() {
        this.servicio.getAll().subscribe({
            next: (data) => {
                this.colonias = data;
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            },
            error: (err) => {
                console.error('Error al cargar colonias', err);
            }
        });
    }
}