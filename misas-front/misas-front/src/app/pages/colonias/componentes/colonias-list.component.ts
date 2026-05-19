import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, EventEmitter, Input, OnChanges, OnInit, Output } from "@angular/core";
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
    @Output() editar = new EventEmitter<any>();

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
        this.servicio.getAllDescriptive().subscribe({
            next: (data) => {
                this.colonias = data;
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            },
            error: (err) => {
            }
        });
    }

    eliminar(id: number) {
        if (confirm('¿Estás seguro de que deseas eliminar esta colonia?')) {
            this.servicio.delete(id).subscribe({
                next: () => {
                    alert('Colonia eliminada exitosamente');
                    this.cargar(); // Recargar la lista después de eliminar
                },
                error: (err) => {
                    alert('Error al eliminar la colonia');
                }
            });
        }
    }

    editarColonia(colonia: any) {
        this.editar.emit(colonia);
    }
}