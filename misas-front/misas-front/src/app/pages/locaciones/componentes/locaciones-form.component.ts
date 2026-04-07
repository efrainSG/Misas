import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, EventEmitter, OnInit, Output } from "@angular/core";
import { ReactiveFormsModule, FormBuilder, FormGroup } from "@angular/forms";

import { LocationService } from "../../../services/locationService";
import { CiudadService } from "../../../services/ciudad-service";
import { ColoniaService } from "../../../services/colonia-service";

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
    coloniaHighlight = false;

    form!: FormGroup;

    constructor(
        private service: LocationService,
        private ciudadService: CiudadService,
        private coloniaService: ColoniaService,
        private formBuilder: FormBuilder,
        private cdr: ChangeDetectorRef
    ) {}

    ngOnInit() {
        this.form = this.formBuilder.group({
            Nombre: [''],
            Direccion: [''],
            Telefono: [''],
            ColoniaId: [null],
            TipoLocacionId: [1],
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
    }

    crear() {
        if (this.form.invalid) return;

        this.service.create(this.form.value).subscribe({
            next: () => {
                this.onCreated.emit();
                this.form.reset({
                    TipoLocacionId: 1
                });
                this.colonias = []; // Clear colonias when a new location is created
            },
            error: (err) => {
                console.error('Error al crear locación', err);
            }
        });
    }
}