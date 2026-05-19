import { CommonModule } from "@angular/common";
import { Component, EventEmitter, Input, OnInit, Output } from "@angular/core";
import { FormBuilder, FormGroup, ReactiveFormsModule } from "@angular/forms";

import { TipoLocacionService } from "../../../services/tipo-locacion-service";

@Component({
    selector: 'app-tipos-locacion-form-component',
    templateUrl: './tiposLocacion-form.component.html',
    styleUrl: './tiposLocacion-form.component.css',
    standalone: true,
    imports: [CommonModule, ReactiveFormsModule]
})

export class TiposLocacionFormComponent implements OnInit {
    @Input() tipoLocacion: any | null = null;
    @Output() onCreated = new EventEmitter<void>();

    form!: FormGroup;

    constructor(
        private service: TipoLocacionService,
        private formBuilder: FormBuilder
    ) {}

    ngOnInit() {
        this.form = this.formBuilder.group({
            Nombre: [''],
            Descripcion: ['']
        });
    }

    ngOnChanges() {
        if (this.tipoLocacion) {
            this.form.patchValue(this.tipoLocacion);
        }
    }

    guardar() {
        console.log('Guardando tipo de locación:', this.form.value);
        console.log('Tipo de locación actual:', this.tipoLocacion);
        if (this.tipoLocacion?.Id) {
            this.actualizar();
        } else {
            this.crear();
        }
        this.tipoLocacion = null; // Limpiar el formulario después de guardar
    }

    crear() {
        if (this.form.valid) {
            const newTipoLocacion = {
            nombre: this.form.value.Nombre,
            descripcion: this.form.value.Descripcion
        };

            this.service.create(newTipoLocacion).subscribe({
                next: () => {
                    this.onCreated.emit();
                    this.form.reset();
                }
            });
        }
    }

    actualizar() {
        if (this.form.valid && this.tipoLocacion?.Id) {
            const updatedTipoLocacion = {
                id: this.tipoLocacion.Id,
                nombre: this.form.value.Nombre,
                descripcion: this.form.value.Descripcion
            };
            this.service.update(this.tipoLocacion.Id, updatedTipoLocacion).subscribe({
                next: () => {
                    this.onCreated.emit();
                    this.form.reset();
                },
                error: (err) => {
                }
            });
        }
    }
}