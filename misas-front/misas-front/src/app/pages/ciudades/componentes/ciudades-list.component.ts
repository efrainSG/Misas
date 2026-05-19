import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, EventEmitter, Input, OnChanges, OnInit, Output } from "@angular/core";
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
    @Output() editar = new EventEmitter<any>();

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
            }
        });
    }

    eliminar(id: number) {
        if (confirm('¿Está seguro de que desea eliminar esta ciudad?')) {
            this.servicio.delete(id).subscribe({
                next: () => {
                    alert('Ciudad eliminada exitosamente');
                    this.cargar(); // Recargar la lista después de eliminar
                },
                error: (err) => {
                    alert('Error al eliminar la ciudad');
                }
            });
        }
    }

    editarCiudad(ciudad: any) {
        this.editar.emit(ciudad);
    }
}