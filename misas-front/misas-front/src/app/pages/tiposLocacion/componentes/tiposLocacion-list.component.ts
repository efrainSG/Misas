import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, EventEmitter, Input, OnChanges, OnInit, Output } from "@angular/core";
import { TipoLocacionService } from "../../../services/tipo-locacion-service";
import { ApiResponse } from "../../../interfaces/ApiResponse";

@Component({
    selector: 'app-tipos-locacion-list-component',
    templateUrl: './tiposLocacion-list.component.html',
    styleUrl: './tiposLocacion-list.component.css',
    standalone: true,
    imports: [CommonModule]
})

export class TiposLocacionListComponent implements OnInit, OnChanges {
    tiposLocacion: any;
    @Input() refreshFlag: boolean = false;
    @Output() editar = new EventEmitter<any>();

    constructor(
        private servicio: TipoLocacionService,
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
            next: (response: ApiResponse<any[]>) => {
                this.tiposLocacion = response.data;
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            },
            error: (err) => {
                console.error('Error al cargar los tipos de locación', err);
            }
        });
    }

    eliminar(id: number) {
        if (confirm('¿Está seguro de eliminar este tipo de locación?')) {
            this.servicio.delete(id).subscribe({
                next: (response: ApiResponse<any>) => {
                    alert(response.message);
                    this.cargar(); // Recargar la lista después de eliminar
                },
                error: (err) => {
                    console.error('Error al eliminar el tipo de locación', err);
                    alert('Error al eliminar el tipo de locación');
                }
            });
        }
    }   

    editarTipoLocacion(tipoLocacion: any) {
        this.editar.emit(tipoLocacion);
    }
}