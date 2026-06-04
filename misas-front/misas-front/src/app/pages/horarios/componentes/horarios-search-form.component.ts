import { ChangeDetectorRef, Component, OnInit } from "@angular/core";
import { HorarioService } from "../../../services/horarioService";
import { ApiResponse } from "../../../interfaces/ApiResponse";
import { CommonModule } from "@angular/common";
import { FormBuilder, FormGroup, ReactiveFormsModule } from "@angular/forms";
import { CiudadService } from "../../../services/ciudad-service";

@Component({
    selector: 'app-horarios-search-form-component',
    templateUrl: './horarios-search-form.component.html',
    styleUrl: './horarios-search-form.component.css',
    standalone: true,
    imports: [CommonModule, ReactiveFormsModule]
})
export class HorariosSearchFormComponent implements OnInit {
    horarios: any;
    ciudades: any[] = [];

    form!: FormGroup;
    
    diasSemana = [
        { Id: 0, Nombre: 'Domingo' },
        { Id: 1, Nombre: 'Lunes' },
        { Id: 2, Nombre: 'Martes' },
        { Id: 3, Nombre: 'Miércoles' },
        { Id: 4, Nombre: 'Jueves' },
        { Id: 5, Nombre: 'Viernes' },
        { Id: 6, Nombre: 'Sábado' }
    ];
    
    constructor(
        private servicio: HorarioService,
        private ciudadService: CiudadService,
        private cdr: ChangeDetectorRef,
        private formBuilder: FormBuilder
    ) {}

    ngOnInit(): void {
        this.form = this.formBuilder.group({
            hora: [''],
            diaSemana: [null],
            ciudadId: [null]
        });

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

        this.ciudadService.getAll().subscribe({
            next: (response: ApiResponse<any[]>) => {
                this.ciudades = response.data;
                this.cdr.detectChanges();
            },
            error: (err) => {
                console.error('Error al cargar las ciudades:', err);
            }
        });
    }

    getDiaSemanaNombre(diaSemana: number): string {
        const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        return diasSemana[diaSemana] || 'Desconocido';
    }

    buscarHorarios() {
        const hora = this.form.get('hora')?.value;
        const dia = this.form.get('diaSemana')?.value;
        const ciudadId = this.form.get('ciudadId')?.value;

        this.servicio.search(hora, dia, ciudadId).subscribe({
            next: (response: ApiResponse<any[]>) => {
                this.horarios = response.data;
                for (let horario of this.horarios) {
                    horario.DiaSemanaNombre = this.getDiaSemanaNombre(horario.DiaSemana);
                }
            },
            error: (err) => {
                console.error('Error al buscar los horarios:', err);
            }
        });
    }
}