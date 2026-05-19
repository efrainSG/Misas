import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, EventEmitter, Input, OnChanges, OnInit, Output } from "@angular/core";
import { TipoLocacionService } from "../../../services/tipo-locacion-service";

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
            next: (data) => {
                this.tiposLocacion = data;
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            },
            error: (err) => {
            }
        });
    }

    eliminar(id: number) {
        if (confirm('¿Está seguro de eliminar este tipo de locación?')) {
            this.servicio.delete(id).subscribe({
                next: () => {
                    alert('Tipo de locación eliminado exitosamente');
                    this.cargar(); // Recargar la lista después de eliminar
                },
                error: (err) => {
                    alert('Error al eliminar el tipo de locación');
                }
            });
        }
    }   

    editarTipoLocacion(tipoLocacion: any) {
        this.editar.emit(tipoLocacion);
    }
}