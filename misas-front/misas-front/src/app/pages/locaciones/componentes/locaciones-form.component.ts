import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, EventEmitter, OnInit, Output } from "@angular/core";
import { ReactiveFormsModule, FormBuilder, FormGroup } from "@angular/forms";

import { LocationService } from "../../../services/locationService";
import { CiudadService } from "../../../services/ciudad-service";
import { ColoniaService } from "../../../services/colonia-service";
import { TipoLocacionService } from "../../../services/tipo-locacion-service";

@Component({
    selector: 'app-locaciones-form-component',
    templateUrl: './locaciones-form.component.html',
    styleUrl: './locaciones-form.component.css',
    standalone: true,
    imports: [CommonModule, ReactiveFormsModule]
})

export class LocacionesFormComponent implements OnInit {
    @Output() onCreated = new EventEmitter<void>();

    ciudades: any[] = [];
    colonias: any[] = [];
    tiposLocacion: any[] = [];
    coloniaHighlight = false;

    form!: FormGroup;

    constructor(
        private service: LocationService,
        private ciudadService: CiudadService,
        private coloniaService: ColoniaService,
        private tipoLocacionService: TipoLocacionService,
        private formBuilder: FormBuilder,
        private cdr: ChangeDetectorRef
    ) {}

    ngOnInit() {
        this.form = this.formBuilder.group({
            Nombre: [''],
            Direccion: [''],
            Telefono: [''],
            ColoniaId: [null],
            TipoLocacionId: [null],
            CiudadId: [null]
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
        if (this.form.invalid) return;

        const newFormValue = {
            coloniaId: this.form.value.ColoniaId, // Asegurar que coloniaId se envíe como null si no se selecciona
            tipoLocacionId: this.form.value.TipoLocacionId,
            ciudadId: this.form.value.CiudadId,
            nombre: this.form.value.Nombre,
            direccion: this.form.value.Direccion,
            telefono: this.form.value.Telefono
        };

        this.service.create(newFormValue).subscribe({
            next: () => {
                this.onCreated.emit();
                this.form.reset({
                    TipoLocacionId: null
                });
                this.ciudades = []; // Clear ciudades when a new location is created
            },
            error: (err) => {
                console.error('Error al crear locación', err);
            }
        });
    }
}