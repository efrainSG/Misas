import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, Input, OnChanges, OnInit } from "@angular/core";
import { LocationService } from "../../../services/locationService";

@Component({
    selector: 'app-locaciones-list-component',
    templateUrl: './locaciones-list.component.html',
    styleUrl: './locaciones-list.component.css',
    standalone: true,
    imports: [CommonModule]
})

export class LocacionesListComponent implements OnChanges, OnInit {
    locaciones: any;
    @Input() refreshFlag: boolean = false;
    
    constructor(
        private servicio: LocationService,
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
                this.locaciones = data;
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            },
            error: (err) => {
                console.error('Error al cargar locaciones', err);
            }
        });
    }
}