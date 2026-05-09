import { ChangeDetectorRef, Component, Input, OnChanges, OnInit } from "@angular/core";
import { CommonModule } from "@angular/common";
import { HorarioService } from "../../../services/horarioService";

@Component({
    selector: 'app-horarios-list-component',
    templateUrl: './horarios-list.component.html',
    styleUrl: './horarios-list.component.css',
    standalone: true,
    imports: [CommonModule]
})
export class HorariosListComponent implements OnInit , OnChanges{
    horarios: any;
    @Input() refreshFlag: boolean = false;

    constructor(
        private servicio: HorarioService,
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
                this.horarios = data;
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            },
            error: (err) => {
                console.error('Error al cargar horarios', err);
            }
        });
    }
}