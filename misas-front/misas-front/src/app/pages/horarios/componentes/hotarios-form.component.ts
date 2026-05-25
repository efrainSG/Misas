import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChange, SimpleChanges } from "@angular/core";
import { FormBuilder, FormGroup, ReactiveFormsModule } from "@angular/forms";
import { TipoLocacionService } from "../../../services/tipo-locacion-service";
import { LocationService } from "../../../services/locationService";
import { ColoniaService } from "../../../services/colonia-service";
import { CiudadService } from "../../../services/ciudad-service";
import { HorarioService } from "../../../services/horarioService";
import { ApiResponse } from "../../../interfaces/ApiResponse";

@Component({
    selector: 'app-horarios-form-component',
    templateUrl: './hotarios-form.component.html',
    styleUrl: './hotarios-form.component.css',
    standalone: true,
    imports: [CommonModule, ReactiveFormsModule]
})

export class HorariosFormComponent implements OnInit, OnChanges{
    @Input() horario: any | null = null;
    @Output() onCreated = new EventEmitter<void>();

    tiposLocacion: any[] = [];
    ciudades: any[] = [];
    colonias: any[] = [];
    locaciones: any[] = [];

    locacionIdSeleccionada: number | null = null;
    coloniaIdSeleccionada: number | null = null;
    ciudadIdSeleccionada: number | null = null;

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
            Activo: [true],
            CiudadId: [null],
            ColoniaId: [null],
            TipoLocacionId: [null],
            LocacionId: [null],
            Notas: ['']
        });

        this.cargarCatalogos();

        console.info('Formulario de horarios inicializado');
    }

    ngOnChanges(changes: SimpleChanges) {
        console.info('Cambios detectados en HorariosFormComponent:', changes); 
        if (changes['horario'] && this.horario) {
            console.info('Horario recibido para edición:', this.horario);
            this.cargarHorarioParaEdicion();
        } 
    }

    cargarHorarioParaEdicion() {
        this.horarioService.getById(this.horario.Id).subscribe({
            next: (horarioData: ApiResponse<any>) => {
                console.info('Horario cargado para edición:', horarioData.data);
                this.locationService.getById(horarioData.data.LocacionId).subscribe({
                    next: (locacionData: ApiResponse<any>) => {
                        console.info('Locación del horario:', locacionData.data);
                        this.coloniaService.getById(locacionData.data.ColoniaId).subscribe({
                            next: (coloniaData: ApiResponse<any>) => {
                                console.info('Colonia de la locación:', coloniaData.data);
                                this.locacionIdSeleccionada = horarioData.data.LocacionId;
                                this.ciudadIdSeleccionada = coloniaData.data.CiudadId;
                                this.coloniaIdSeleccionada = locacionData.data.ColoniaId;

                                this.coloniaService.getByCiudad(coloniaData.data.CiudadId).subscribe({
                                    next: (response: ApiResponse<any[]>) => {
                                        this.colonias = response.data;
                                        this.form.patchValue({
                                            DiaSemana: horarioData.data.DiaSemana,
                                            Hora: horarioData.data.Hora,
                                            Activo: horarioData.data.Activo,
                                            CiudadId: this.ciudadIdSeleccionada,
                                            ColoniaId: this.coloniaIdSeleccionada,
                                            TipoLocacionId: locacionData.data.TipoLocacionId,
                                            Notas: horarioData.data.Notas
                                        }, { emitEvent: false });
                                        this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
                                        this.cargarLocaciones(locacionData.data.TipoLocacionId, coloniaData.data.Id);
                                        }
                                    });
                                }
                        });
                    }
                });
            }
        });
    }

    cargarCatalogos() {
        this.ciudadService.getAll().subscribe({
            next: (response: ApiResponse<any[]>) => {
                this.ciudades = response.data;
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            }
        });

        this.tipoLocacionService.getAll().subscribe({
            next: (response: ApiResponse<any[]>) => {
                this.tiposLocacion = response.data;
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            }
        });
    }

    cargarLocaciones(tipoLocacionId: number | null, coloniaId: number | null) {

        console.info('Cargando locaciones para TipoLocacionId:', tipoLocacionId, 'y ColoniaId:', coloniaId);
        if (!tipoLocacionId || !coloniaId) {
            this.locaciones = [];
            return;
        }



        this.locationService
            .getByTipoAndColonia(tipoLocacionId, coloniaId)
            .subscribe({
                next: (response: ApiResponse<any[]>) => {
                    console.info('Locaciones cargadas:', response.data);
                    this.locaciones = response.data;

                    this.form.patchValue({
                        LocacionId: this.locacionIdSeleccionada
                     }, { emitEvent: false });
                }
            });
    }

    guardar() {
        if (this.horario?.Id) {
            this.actualizar();
        } else {
            this.crear();
        }
        this.horario = null; // Limpiar el formulario después de guardar
    }

    crear() {
        // Lógica para crear un nuevo tipo de locación
        if (this.form.invalid) return;

        const nuevoHorario = {
            diaSemana: this.form.value.DiaSemana,
            hora: this.form.value.Hora,
            activo: this.form.value.Activo,
            locacionId: this.form.value.LocacionId,
            notas: this.form.value.Notas,
            tipoLocacionId: this.form.value.TipoLocacionId
        };
        
        console.info('Creando horario con datos:', nuevoHorario);
        
        this.horarioService.create(nuevoHorario).subscribe({
            next: () => {
                this.onCreated.emit(); // Emitir evento para indicar que se creó un nuevo horario
                this.form.reset(); // Limpiar el formulario después de crear
            },
            error: (err) => {
                console.error('Error al crear el horario:', err);
            }
        });
    }

    actualizar() {
        if (this.form.valid && this.horario?.Id) {
            const updatedHorario = {
                id: this.horario.Id,
                diaSemana: this.form.value.DiaSemana,
                hora: this.form.value.Hora,
                activo: this.form.value.Activo,
                locacionId: this.form.value.LocacionId,
                notas: this.form.value.Notas,
                tipoLocacionId: this.form.value.TipoLocacionId
            };
            this.horarioService.update(this.horario.Id, updatedHorario).subscribe({
                next: () => {
                    this.onCreated.emit();
                    this.form.reset();
                },
                error: (err) => {
                    console.error('Error al actualizar el horario:', err);
                }
            });
        }
    }
}