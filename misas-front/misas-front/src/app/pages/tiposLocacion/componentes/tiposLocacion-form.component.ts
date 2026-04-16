import { CommonModule } from "@angular/common";
import { ChangeDetectorRef, Component, EventEmitter, OnInit, Output } from "@angular/core";
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
    @Output() onCreated = new EventEmitter<void>();

    form!: FormGroup;

    constructor(
        private service: TipoLocacionService,
        private formBuilder: FormBuilder,
        private cdRef: ChangeDetectorRef) {}

    ngOnInit() {
        this.form = this.formBuilder.group({
            Nombre: [''],
            Descripcion: ['']
        });
    }

    crear() {
        if (this.form.valid) {
            this.service.create(this.form.value).subscribe({
                next: () => {
                    this.onCreated.emit();
                    this.form.reset();
                }
            });
        }
    }
}