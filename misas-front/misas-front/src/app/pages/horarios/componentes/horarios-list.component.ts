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
                for (let horario of this.horarios) {
                    horario.DiaSemanaNombre = this.getDiaSemanaNombre(horario.DiaSemana);
                }
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            },
            error: (err) => {
                console.error('Error al cargar horarios', err);
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
                next: () => {
                    alert('Horario eliminado exitosamente');
                    this.cargar(); // Recargar la lista después de eliminar
                },
                error: (err) => {
                    console.error('Error al eliminar horario', err);
                    alert('Error al eliminar el horario');
                }
            });
        }
    }
}