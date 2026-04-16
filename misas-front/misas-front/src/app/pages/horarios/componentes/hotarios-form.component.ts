import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, EventEmitter, OnInit, Output } from "@angular/core";
import { FormBuilder, FormGroup, ReactiveFormsModule } from "@angular/forms";
import { TipoLocacionService } from "../../../services/tipo-locacion-service";
import { LocationService } from "../../../services/locationService";
import { ColoniaService } from "../../../services/colonia-service";
import { CiudadService } from "../../../services/ciudad-service";
import { HorarioService } from "../../../services/horarioService";

@Component({
    selector: 'app-horarios-form-component',
    templateUrl: './hotarios-form.component.html',
    styleUrl: './hotarios-form.component.css',
    standalone: true,
    imports: [CommonModule, ReactiveFormsModule]
})

export class HorariosFormComponent implements OnInit{
    @Output() onCreated = new EventEmitter<void>();
    tiposLocacion: any[] = [];
    ciudades: any[] = [];
    colonias: any[] = [];
    locaciones: any[] = [];
    diasSemana = [
        { Id: 0, Nombre: 'Domingo' },
        { Id: 1, Nombre: 'Lunes' },
        { Id: 2, Nombre: 'Martes' },
        { Id: 3, Nombre: 'Miércoles' },
        { Id: 4, Nombre: 'Jueves' },
        { Id: 5, Nombre: 'Viernes' },
        { Id: 6, Nombre: 'Sábado' }
    ];
    coloniaHighlight = false;

    form!: FormGroup;

    constructor(
        private horarioService: HorarioService,
        private tipoLocacionService: TipoLocacionService,
        private ciudadService: CiudadService,
        private coloniaService: ColoniaService,
        private locationService: LocationService,
        private formBuilder: FormBuilder,
        private cdr: ChangeDetectorRef
    ) {}

    ngOnInit() {
        this.form = this.formBuilder.group({
            DiaSemana: [0],
            Hora: [''],
            Activo: [''],
            LocacionId: [null],
            Notas: ['']
        });

        this.cargarCatalogos();

        this.form.get('CiudadId')?.valueChanges.subscribe(ciudadId => {
        if (ciudadId) {
            this.coloniaService.getByCiudad(ciudadId).subscribe({
                next: (colonias) => {
                    this.colonias = colonias;
                    this.form.patchValue({ ColoniaId: null }); // Reset colonia selection when ciudad changes
                    this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
                    this.coloniaHighlight = true;
                    setTimeout(() => {
                        this.coloniaHighlight = false;
                    }, 800);
                }
            });
        }
        });

        this.form.get('ColoniaId')?.valueChanges.subscribe(coloniaId => {
            if (coloniaId) {
                this.locationService.getByColonia(coloniaId).subscribe({
                    next: (locaciones) => {
                        this.locaciones = locaciones;
                        this.form.patchValue({ LocacionId: null }); // Reset locacion selection when colonia changes
                        this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
                    }
                });
            }
        });
    }

    cargarCatalogos() {
        this.ciudadService.getAll().subscribe({
            next: (ciudades) => {
                this.ciudades = ciudades;
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            }
        });

        this.tipoLocacionService.getAll().subscribe({
            next: (tipos) => {
                this.tiposLocacion = tipos;
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            }
        });
    }

    crear() {
        // Lógica para crear un nuevo tipo de locación
        if (this.form.invalid) return;

        const nuevoHorario = {
            diaSemana: this.form.value.DiaSemana,
            hora: this.form.value.Hora,
            activo: this.form.value.Activo,
            locacionId: this.form.value.LocacionId,
            notas: this.form.value.Notas
        };
        
        this.horarioService.create(nuevoHorario).subscribe({
            next: () => {
                this.onCreated.emit(); // Emitir evento para indicar que se creó un nuevo horario
                this.form.reset(); // Limpiar el formulario después de crear
            },
            error: (err) => {
                console.error('Error al crear horario', err);
            }
        });

    }
}