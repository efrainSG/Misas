import { CommonModule } from "@angular/common";
import { Component, EventEmitter, Output } from "@angular/core";
import { FormsModule } from "@angular/forms";
import { LocationService } from "../../../services/locationService";

@Component({
    selector: 'app-locaciones-form-component',
    templateUrl: './locaciones-form.component.html',
    styleUrl: './locaciones-form.component.css',
    standalone: true,
    imports: [CommonModule, FormsModule]
})

export class LocacionesFormComponent {
    @Output() onCreated = new EventEmitter<void>();

    model = {
        Nombre: '',
        Direccion: '',
        Telefono: '',
        ColoniaId: 1,
        TipoLocacionId: 1
    };

    constructor(private service: LocationService) {}

    crear() {
        this.service.create(this.model).subscribe({
            next: () => {
                this.onCreated.emit();
                this.model = {
                    Nombre: '',
                    Direccion: '',
                    Telefono: '',
                    ColoniaId: 1,
                    TipoLocacionId: 1
                };
            },
            error: (err) => {
                console.error('Error al crear locación', err);
            }
        });
    }

}