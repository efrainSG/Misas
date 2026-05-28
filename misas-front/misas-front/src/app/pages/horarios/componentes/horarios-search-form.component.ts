import { ChangeDetectorRef, Component, OnInit } from "@angular/core";
import { HorarioService } from "../../../services/horarioService";
import { ApiResponse } from "../../../interfaces/ApiResponse";
import { CommonModule } from "@angular/common";

@Component({
    selector: 'app-horarios-search-form-component',
    templateUrl: './horarios-search-form.component.html',
    styleUrl: './horarios-search-form.component.css',
    standalone: true,
    imports: [CommonModule]
})
export class HorariosSearchFormComponent implements OnInit {
    horarios: any;

    constructor(
        private servicio: HorarioService,
        private cdr: ChangeDetectorRef
    ) {}

    ngOnInit(): void {
        this.cargar();
    }

    cargar() {
        this.servicio.search().subscribe({
            next: (response: ApiResponse<any[]>) => {
                this.horarios = response.data;
                for (let horario of this.horarios) {
                    horario.DiaSemanaNombre = this.getDiaSemanaNombre(horario.DiaSemana);
                }
                this.cdr.detectChanges();
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

}