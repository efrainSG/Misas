import { ChangeDetectorRef, Component, EventEmitter, Input, OnChanges, OnInit, Output } from "@angular/core";
import { CommonModule } from "@angular/common";
import { HorarioService } from "../../../services/horarioService";
import { ApiResponse } from "../../../interfaces/ApiResponse";

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
    @Output() editar = new EventEmitter<any>();

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
        this.servicio.getAllDescriptive().subscribe({
            next: (response: ApiResponse<any[]>) => {
                this.horarios = response.data;
                for (let horario of this.horarios) {
                    horario.DiaSemanaNombre = this.getDiaSemanaNombre(horario.DiaSemana);
                }
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            },
            error: (err) => {
                console.error('Error al cargar los horarios:', err);
            }
        });
    }

    getDiaSemanaNombre(diaSemana: number): string {
        const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        return diasSemana[diaSemana] || 'Desconocido';
    }

    eliminar(id: number) {
        if (confirm('¿Está seguro de que desea eliminar este horario?')) {
            this.servicio.delete(id).subscribe({
                next: (response: ApiResponse<any>) => {
                    alert(response.message);
                    this.cargar(); // Recargar la lista después de eliminar
                },
                error: (err) => {
                    console.error('Error al eliminar el horario:', err);
                    alert('Error al eliminar el horario');
                }
            });
        }
    }

    editarHorario(horario: any) {
        this.editar.emit(horario);
    }
}