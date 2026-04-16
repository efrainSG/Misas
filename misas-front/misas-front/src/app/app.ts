import { Component, signal } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { Locacionespage } from './pages/locaciones/locaciones.page';
import { ColoniasPage } from './pages/colonias/colonias.page';
import { CiudadesPage } from './pages/ciudades/ciudades.page';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet,
    Locacionespage,
    ColoniasPage,
    CiudadesPage,
    
  ],
  templateUrl: './app.html',
  styleUrl: './app.css'
})
export class App {
  protected readonly title = signal('misas-front');
}
