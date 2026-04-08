import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, EventEmitter, OnInit, Output } from "@angular/core";
import { ReactiveFormsModule, FormBuilder, FormGroup } from "@angular/forms";

import { CiudadService } from "../../../services/ciudad-service";
import { ColoniaService } from "../../../services/colonia-service";

@Component({
    selector: 'app-colonias-form-component',
    templateUrl: './colonias-form.component.html',
    styleUrl: './colonias-form.component.css',
    standalone: true,
    imports: [CommonModule, ReactiveFormsModule]
})

export class ColoniasFormComponent implements OnInit {
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

    cargarCiudades() {
        this.ciudadService.getAll().subscribe({
            next: (data) => {
                this.ciudades = data;
                this.cdr.detectChanges(); // Forzar actualización de la vista después de asignar los datos
            },
            error: (err) => {
                console.error('Error al cargar ciudades', err);
            }
        });
    }

    crear() {
        if (this.form.invalid) 
            return;

        const newColonia = {
            nombre: this.form.value.Nombre,
            ciudadId: this.form.value.CiudadId
        };

        this.coloniaService.create(newColonia).subscribe({
            next: () => {
                this.onCreated.emit(); // Emitir evento para indicar que se creó una nueva colonia
                this.form.reset();

            },
            error: (err) => {
                console.error('Error al crear colonia', err);
            }
        });
    }
}