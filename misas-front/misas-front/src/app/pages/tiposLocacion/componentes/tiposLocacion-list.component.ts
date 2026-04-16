import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, Input, OnChanges, OnInit } from "@angular/core";
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
                console.error('Error al cargar tipos de locación', err);
            }
        });
    }
}