import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, Input, OnChanges, OnInit } from "@angular/core";
import { CiudadService } from "../../../services/ciudad-service";

@Component({
    selector: 'app-ciudades-list-component',
    templateUrl: './ciudades-list.component.html',
    styleUrl: './ciudades-list.component.css',
    standalone: true,
    imports: [CommonModule]
})

export class CiudadesListComponent implements OnInit, OnChanges {
    ciudades: any;
    @Input() refreshFlag: boolean = false;

    constructor(
        private servicio: CiudadService,
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
                this.ciudades = data;
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            },
            error: (err) => {
                console.error('Error al cargar ciudades', err);
            }
        });
    }
}