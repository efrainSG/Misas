import { CommonModule } from "@angular/common";
import { Component, Input, OnChanges } from "@angular/core";
import { LocationService } from "../../../services/locationService";

@Component({
    selector: 'app-locaciones-list-component',
    templateUrl: './locaciones-list.component.html',
    styleUrl: './locaciones-list.component.css',
    standalone: true,
    imports: [CommonModule]
})

export class LocacionesListComponent implements OnChanges {
    locaciones: any[] = [];
    @Input() refreshFlag: boolean = false;
    
    constructor(private servicio: LocationService) {}

    ngoninit(): void {
        this.cargar();
    }
    
    ngOnChanges(): void {
        this.cargar();
    }

    cargar() {
        this.servicio.getAll().subscribe({
            next: (data) => {
                this.locaciones = data;
            },
            error: (err) => {
                console.error('Error al cargar locaciones', err);
            }
        });
    }
}