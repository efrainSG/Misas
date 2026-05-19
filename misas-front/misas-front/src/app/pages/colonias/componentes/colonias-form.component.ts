import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, EventEmitter, Input, OnInit, Output } from "@angular/core";
import { ReactiveFormsModule, FormBuilder, FormGroup } from "@angular/forms";
import { CiudadService } from "../../../services/ciudad-service";
import { ColoniaService } from "../../../services/colonia-service";
import { ApiResponse } from "../../../interfaces/ApiResponse";

@Component({
    selector: 'app-colonias-form-component',
    templateUrl: './colonias-form.component.html',
    styleUrl: './colonias-form.component.css',
    standalone: true,
    imports: [CommonModule, ReactiveFormsModule]
})

export class ColoniasFormComponent implements OnInit {
    @Input() colonia: any | null = null;
    @Output() onCreated = new EventEmitter<void>();

    ciudades: any[] = [];

    form!: FormGroup;

    constructor(
        private formBuilder: FormBuilder,
        private ciudadService: CiudadService,
        private coloniaService: ColoniaService,
        private cdr: ChangeDetectorRef
    ) {}

    ngOnInit() {
        this.form = this.formBuilder.group({
            Nombre: [''],
            CiudadId: [null]
        });

        this.cargarCiudades();
    }

    ngOnChanges() {
        if (this.colonia) {
            this.form.patchValue(this.colonia);
        }
    }

    guardar() {
        if (this.colonia?.Id) {
            this.actualizar();
        } else {
            this.crear();
        }
        this.colonia = null; // Limpiar el formulario después de guardar
    }

    cargarCiudades() {
        this.ciudadService.getAll().subscribe({
            next: (response: ApiResponse<any[]>) => {
                this.ciudades = response.data;
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            },
            error: (err) => {
                console.error('Error al cargar las ciudades:', err);
            }
        });
    }

    crear() {
        if (this.form.invalid) 
            return;

        const newColonia = {
            nombre: this.form.value.Nombre,
            ciudadid: this.form.value.CiudadId
        };

        this.coloniaService.create(newColonia).subscribe({
            next: (response: ApiResponse<any>) => {
                alert(response.message);
                this.onCreated.emit(); // Emitir evento para indicar que se creó una nueva colonia
                this.form.reset();

            },
            error: (err) => {
                console.error('Error al crear la colonia:', err);
                alert('Error al crear la colonia');
            }
        });
    }

    actualizar() {
        if (this.form.valid && this.colonia?.Id) {
            const updatedColonia = {
                id: this.colonia.Id,
                nombre: this.form.value.Nombre,
                ciudadid: this.form.value.CiudadId
            };
            this.coloniaService.update(this.colonia.Id, updatedColonia).subscribe({
                next: (response: ApiResponse<any>) => {
                    alert(response.message);
                    this.onCreated.emit();
                    this.form.reset();
                },
                error: (err) => {
                    console.error('Error al actualizar la colonia:', err);
                    alert('Error al actualizar la colonia');
                }
            });
        }
    }
}