import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, EventEmitter, Input, OnChanges, OnInit, Output } from "@angular/core";
import { LocationService } from "../../../services/locationService";
import { ApiResponse } from "../../../interfaces/ApiResponse";

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
    @Output() editar = new EventEmitter<any>();
    
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
        this.servicio.getAllDescriptive().subscribe({
            next: (response: ApiResponse<any[]>) => {
                this.locaciones = response.data;
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            },
            error: (err) => {
                console.error('Error al cargar las locaciones:', err);
            }
        });
    }

    eliminar(id: number) {
        if (confirm('¿Estás seguro de que deseas eliminar esta locación?')) {
            this.servicio.delete(id).subscribe({
                next: (response: ApiResponse<any>) => {
                    alert(response.message);
                    this.cargar(); // Recargar la lista después de eliminar
                },
                error: (err) => {
                    console.error('Error al eliminar la locación:', err);
                    alert('Error al eliminar la locación');
                }
            });
        }
    }

    editarLocacion(locacion: any) {
        this.editar.emit(locacion);
    }
}