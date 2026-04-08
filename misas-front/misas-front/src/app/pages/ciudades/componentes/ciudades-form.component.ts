import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, EventEmitter, OnInit, Output } from "@angular/core";
import { FormBuilder, FormGroup, ReactiveFormsModule } from "@angular/forms";
import { CiudadService } from "../../../services/ciudad-service";

@Component({
    selector: 'app-ciudades-form-component',
    templateUrl: './ciudades-form.component.html',
    styleUrl: './ciudades-form.component.css',
    standalone: true,
    imports: [CommonModule, ReactiveFormsModule]
})

export class CiudadesFormComponent implements OnInit {
    @Output() onCreated = new EventEmitter<void>();

    form!: FormGroup;

    constructor(
        private formBuilder: FormBuilder,
        private ciudadService: CiudadService,
        private cdr: ChangeDetectorRef
    ) {}

    ngOnInit() {
        this.form = this.formBuilder.group({
            Nombre: ['']
        });
    }

    crear() {
        if (this.form.invalid) 
            return;
        
        const newCiudad = {
            nombre: this.form.value.Nombre
        };

        this.ciudadService.create(newCiudad).subscribe({
            next: () => {
                this.onCreated.emit();
                this.form.reset();
            },
            error: (err) => {
                console.error('Error al crear ciudad', err);
            }
        });
    }
}