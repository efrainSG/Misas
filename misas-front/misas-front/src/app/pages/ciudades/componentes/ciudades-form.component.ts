import { CommonModule } from "@angular/common";
import { Component, EventEmitter, Input, OnInit, Output } from "@angular/core";
import { FormBuilder, FormGroup, ReactiveFormsModule } from "@angular/forms";
import { CiudadService } from "../../../services/ciudad-service";
import { ApiResponse } from "../../../interfaces/ApiResponse";

@Component({
    selector: 'app-ciudades-form-component',
    templateUrl: './ciudades-form.component.html',
    styleUrl: './ciudades-form.component.css',
    standalone: true,
    imports: [CommonModule, ReactiveFormsModule]
})

export class CiudadesFormComponent implements OnInit {
    @Input() ciudad: any | null = null;
    @Output() onCreated = new EventEmitter<void>();

    form!: FormGroup;

    constructor(
        private formBuilder: FormBuilder,
        private ciudadService: CiudadService
    ) {}

    ngOnInit() {
        this.form = this.formBuilder.group({
            Nombre: ['']
        });
    }

    ngOnChanges() {
        if (this.ciudad) {
            this.form.patchValue(this.ciudad);
        }
    }

    guardar() {
        if (this.ciudad?.Id) {
            this.actualizar();
        } else {
            this.crear();
        }
        this.ciudad = null; // Limpiar el formulario después de guardar
    }

    crear() {
        if (this.form.invalid) 
            return;
        
        const newCiudad = {
            nombre: this.form.value.Nombre
        };

        this.ciudadService.create(newCiudad).subscribe({
            next: (response: ApiResponse<any>) => {
                alert(response.message);
                this.onCreated.emit();
                this.form.reset();
            },
            error: (err) => {
                console.error('Error al crear la ciudad:', err);
                alert('Error al crear la ciudad.');
            }
        });
    }

    actualizar() {
        if (this.form.valid && this.ciudad?.Id) {
            const updatedCiudad = {
                id: this.ciudad.Id,
                nombre: this.form.value.Nombre
            };
            this.ciudadService.update(this.ciudad.Id, updatedCiudad).subscribe({
                next: (response: ApiResponse<any>) => {
                    alert(response.message);
                    this.onCreated.emit();
                    this.form.reset();
                },
                error: (err) => {
                    console.error('Error al actualizar la ciudad:', err);
                }
            });
        }
    }
}